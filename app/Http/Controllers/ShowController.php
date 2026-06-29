<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShowController extends Controller
{
    /**
     * Toon de homepagina met alle beschikbare shows
     */
    public function index()
    {
        $shows = Show::where('is_active', true)
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->get();

        return view('welcome', compact('shows'));
    }

    /**
     * Toon een enkel show detail
     */
    public function show(Show $show)
    {
        if (!$show->is_active) {
            abort(404);
        }

        return view('shows.show', compact('show'));
    }

    /**
     * Boek een ticket voor een show (moet ingelogd zijn)
     */
    public function book(Show $show)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('info', 'Log in om tickets te kunnen bestellen voor ' . $show->title);
        }

        return view('shows.book', compact('show'));
    }

    /**
     * Sla een boeking op
     */
    public function storeBooking(Request $request, Show $show)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'U moet ingelogd zijn om tickets te bestellen.');
        }

        $request->validate([
            'number_of_tickets' => 'required|integer|min:1|max:10',
        ]);

        $numberOfTickets = $request->number_of_tickets;

        $booked = DB::transaction(function () use ($show, $numberOfTickets) {
            // Lock de rij zodat gelijktijdige requests niet allebei door de check komen
            $locked = Show::lockForUpdate()->find($show->id);

            if ($locked->available_tickets < $numberOfTickets) {
                return false;
            }

            Reservation::create([
                'user_id'           => Auth::id(),
                'show_id'           => $locked->id,
                'show_name'         => $locked->title,
                'show_date'         => $locked->date,
                'number_of_tickets' => $numberOfTickets,
                'ticket_barcode'    => 'AUR-' . strtoupper(Str::uuid()),
                'status'            => 'gereserveerd',
            ]);

            $locked->decrement('available_tickets', $numberOfTickets);
            return true;
        });

        if (!$booked) {
            return back()->with('error', 'Er zijn niet genoeg tickets meer beschikbaar.');
        }

        return redirect()->route('mijn.tickets')
            ->with('success', 'Uw tickets voor "' . $show->title . '" zijn bevestigd!');
    }

    /**
     * Toon de over ons informatiepagina
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Toon de contact en FAQ pagina
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Toon overzicht van alle voorstellingen voor medewerkers
     */
    public function employeeIndex(Request $request)
    {
        // Alleen toegankelijk voor medewerkers of administrators
        if (!Auth::check() || !in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            abort(403, 'Onbevoegde toegang.');
        }

        $query = Show::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $shows = $query->orderBy('date', 'asc')->get();

        return view('employee.shows', compact('shows'));
    }

    /**
     * Sla een nieuwe voorstelling op (voor medewerkers)
     */
    public function employeeStore(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'image_url' => 'nullable|url|max:255',
            'available_tickets' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        // Default to active if not provided
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        Show::create($validated);

        return redirect()->route('employee.shows.index')
            ->with('success', 'Voorstelling succesvol toegevoegd!');
    }

    /**
     * Update een bestaande voorstelling (voor medewerkers)
     */
    public function employeeUpdate(Request $request, Show $show)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'image_url' => 'nullable|url|max:255',
            'available_tickets' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : false;

        $show->update($validated);

        return redirect()->route('employee.shows.index')
            ->with('success', 'Voorstelling succesvol bijgewerkt!');
    }

    /**
     * Verwijder een voorstelling (voor medewerkers)
     */
    public function employeeDestroy(Show $show)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            abort(403);
        }

        // Check of er al reserveringen zijn voor deze show
        if ($show->reservations()->count() > 0) {
            return redirect()->route('employee.shows.index')
                ->with('error', 'Kan voorstelling niet verwijderen: er zijn al tickets voor gereserveerd. Zet de voorstelling in plaats daarvan op inactief.');
        }

        $show->delete();

        return redirect()->route('employee.shows.index')
            ->with('success', 'Voorstelling succesvol verwijderd!');
    }
}