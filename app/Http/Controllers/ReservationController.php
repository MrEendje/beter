<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Show;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    // Medewerker: Overzicht met zoekfunctie
    public function index(Request $request)
    {
        if (!in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            return redirect('/')->with('error', 'Geen toegang.');
        }

        $query = Reservation::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_barcode', 'like', "%{$search}%")
                  ->orWhere('show_name', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $reservations = $query->orderBy('show_date', 'asc')->get();
        $shows = Show::where('is_active', true)->orderBy('date')->get();
        $users = User::orderBy('name')->get();

        return view('employee.tickets', compact('reservations', 'shows', 'users'));
    }

    // Medewerker: Voeg handmatig een ticket toe
    public function storeManual(Request $request)
    {
        if (!in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            abort(403);
        }

        $request->validate([
            'user_id'           => ['required', 'exists:users,id'],
            'show_id'           => ['required', 'exists:shows,id'],
            'number_of_tickets' => ['required', 'integer', 'min:1'],
            'status'            => ['required', 'in:gereserveerd,gescand,geannuleerd'],
        ]);

        $show = Show::find($request->show_id);

        if ($show->available_tickets < $request->number_of_tickets) {
            return redirect()->route('tickets.index')
                ->with('error', "Niet genoeg beschikbare tickets. Er zijn nog {$show->available_tickets} tickets beschikbaar voor '{$show->title}'.");
        }

        Reservation::create([
            'user_id'           => $request->user_id,
            'show_id'           => $show->id,
            'show_name'         => $show->title,
            'show_date'         => $show->date,
            'number_of_tickets' => $request->number_of_tickets,
            'ticket_barcode'    => 'AUR-' . strtoupper(Str::uuid()),
            'status'            => $request->status,
        ]);

        $show->decrement('available_tickets', $request->number_of_tickets);

        return redirect()->route('tickets.index')->with('success', 'Ticket handmatig toegevoegd.');
    }

    // Medewerker: Bewerk reservering
    public function update(Request $request, $reservationId)
    {
        if (!in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            return redirect('/');
        }

        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            return redirect()->route('tickets.index')->with('error', 'Reservering niet gevonden. Deze is mogelijk al verwijderd.');
        }

        $request->validate([
            'show_name' => 'required|string',
            'show_date' => 'required|date',
            'number_of_tickets' => 'required|integer|min:1',
            'status' => 'required|in:gereserveerd,gescand,geannuleerd',
        ]);

        $oldCount = $reservation->number_of_tickets;
        $newCount = (int) $request->number_of_tickets;

        $reservation->update($request->only(['show_name', 'show_date', 'number_of_tickets', 'status']));

        // Pas beschikbare tickets aan als het aantal gewijzigd is
        if ($oldCount !== $newCount) {
            $show = Show::find($reservation->show_id);
            if ($show) {
                $diff = $oldCount - $newCount;
                $show->increment('available_tickets', $diff);
            }
        }

        return redirect()->route('tickets.index')->with('success', 'Reservering succesvol bijgewerkt.');
    }

    // Medewerker: Verwijder reservering
    public function destroy($reservationId)
    {
        if (!in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            return redirect('/');
        }

        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            return redirect()->route('tickets.index')->with('error', 'Reservering niet gevonden. Deze is mogelijk al verwijderd.');
        }

        // Geef tickets terug aan de voorstelling
        $show = Show::find($reservation->show_id);
        if ($show) {
            $show->increment('available_tickets', $reservation->number_of_tickets);
        }

        $reservation->delete();

        return redirect()->route('tickets.index')->with('success', 'Reservering verwijderd.');
    }

    // Bezoeker: Toon reserveringsformulier
    public function create()
    {
        return view('reservations.create');
    }

    // Bezoeker: Sla reservering op
    public function store(Request $request)
    {
        $request->validate([
            'show_name' => 'required|string',
            'show_date' => 'required|date',
            'number_of_tickets' => 'required|integer|min:1|max:10',
        ]);

        Reservation::create([
            'user_id' => Auth::id(),
            'show_name' => $request->show_name,
            'show_date' => $request->show_date,
            'number_of_tickets' => $request->number_of_tickets,
            'ticket_barcode' => 'AUR-' . strtoupper(Str::uuid()),
            'status' => 'gereserveerd',
        ]);

        return redirect()->route('mijn.tickets')->with('success', 'Uw reservering is bevestigd!');
    }

    // Bezoeker: Mijn tickets
    public function mijnTickets()
    {
        $reservations = Reservation::where('user_id', Auth::id())->orderBy('show_date')->get();
        return view('reservations.mijn-tickets', compact('reservations'));
    }

    // Medewerker: Scan ticket via barcode
    public function scan(Request $request)
    {
        if (!in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            abort(403);
        }

        if (!$request->filled('barcode')) {
            return view('employee.scan');
        }

        $reservation = Reservation::where('ticket_barcode', $request->barcode)->first();

        if (!$reservation) {
            return view('employee.scan')->with('error', 'Onbekende barcode: ' . $request->barcode);
        }

        if ($reservation->status === 'gescand') {
            return view('employee.scan')->with('warning', 'Ticket al eerder gescand voor: ' . $reservation->show_name);
        }

        $reservation->update(['status' => 'gescand']);

        return view('employee.scan')->with('success', 'Ticket geldig — ' . $reservation->show_name . ' (' . $reservation->number_of_tickets . 'x)');
    }

}
