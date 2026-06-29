<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // Alleen administrators mogen medewerkers beheren
    public function index()
    {
        if (Auth::user()->role !== 'administrator') {
            abort(403);
        }

        $employees = User::where('role', 'medewerker')->orderBy('name')->get();

        return view('admin.medewerkers', compact('employees'));
    }

    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'administrator') {
            abort(403);
        }

        // Voorkom dat admin zichzelf verwijdert
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.medewerkers')->with('error', 'Je kan je eigen account niet verwijderen.');
        }

        $user->delete();

        return redirect()->route('admin.medewerkers')->with('success', 'Medewerker succesvol verwijderd.');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'administrator') {
            abort(403);
        }

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // Rol wordt altijd 'medewerker', admin kan dat niet zelf kiezen
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'medewerker',
        ]);

        return redirect()->route('admin.medewerkers')->with('success', 'Medewerker succesvol toegevoegd.');
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'administrator') {
            abort(403);
        }

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);

        $user->update($request->only(['name', 'email']));

        return redirect()->route('admin.medewerkers')->with('success', 'Medewerker succesvol bijgewerkt.');
    }
}
