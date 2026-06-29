<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        Contact::create($request->only(['name', 'email', 'subject', 'message']));

        return back()->with('success', 'Bedankt! Uw bericht is succesvol verzonden. We beantwoorden uw vraag zo spoedig mogelijk.');
    }

    public function index(Request $request)
    {
        if (!in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            abort(403);
        }

        $query = Contact::latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('subject', 'like', "%$s%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contacts = $query->get();

        return view('employee.klachten', compact('contacts'));
    }

    public function update(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            abort(403);
        }

        $contact = Contact::find($id);

        if (!$contact) {
            return redirect()->route('employee.contacts.index')
                ->with('error', 'Deze melding bestaat niet meer. Mogelijk is hij al verwijderd.');
        }

        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'status'  => ['required', 'in:nieuw,in_behandeling,gereed'],
        ]);

        $contact->update($request->only(['name', 'email', 'subject', 'message', 'status']));

        return redirect()->route('employee.contacts.index')->with('success', 'Melding succesvol bijgewerkt.');
    }

    public function markGereed($id)
    {
        if (!in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            abort(403);
        }

        $contact = Contact::find($id);

        if (!$contact) {
            return redirect()->route('employee.contacts.index')
                ->with('error', 'Deze melding bestaat niet meer. Mogelijk is hij al verwijderd.');
        }

        $contact->update(['status' => 'gereed']);

        return redirect()->route('employee.contacts.index')->with('success', 'Melding gemarkeerd als gereed.');
    }

    public function destroy($id)
    {
        if (!in_array(Auth::user()->role, ['medewerker', 'administrator'])) {
            abort(403);
        }

        $contact = Contact::find($id);

        if (!$contact) {
            return redirect()->route('employee.contacts.index')
                ->with('error', 'Deze melding bestaat niet meer. Mogelijk is hij al verwijderd.');
        }

        $contact->delete();

        return redirect()->route('employee.contacts.index')->with('success', 'Melding verwijderd.');
    }
}
