<?php

namespace App\Http\Controllers;

use App\Models\Verklaring;
use Illuminate\Http\Request;

class WizardController extends Controller
{
    public function step1()
    {
        return view('wizard.step1');
    }

    public function step1Store(Request $request)
    {
        $request->validate([
            'naam'           => 'required|string|max:255',
            'adres'          => 'required|string|max:255',
            'postcode'       => 'required|string|max:20',
            'stad'           => 'required|string|max:255',
            'aantal_groepen' => 'required|integer|min:1|max:100',
            'installateur'   => 'nullable|string|max:255',
        ]);

        session([
            'wizard.naam'           => $request->naam,
            'wizard.adres'          => $request->adres,
            'wizard.postcode'       => $request->postcode,
            'wizard.stad'           => $request->stad,
            'wizard.aantal_groepen' => (int) $request->aantal_groepen,
            'wizard.installateur'   => $request->installateur,
        ]);

        return redirect()->route('wizard.step2');
    }

    public function step2()
    {
        if (! session()->has('wizard.aantal_groepen')) {
            return redirect()->route('wizard.step1');
        }

        return view('wizard.step2', [
            'aantalGroepen' => session('wizard.aantal_groepen'),
        ]);
    }

    public function step2Store(Request $request)
    {
        if (! session()->has('wizard.aantal_groepen')) {
            return redirect()->route('wizard.step1');
        }

        $aantalGroepen = session('wizard.aantal_groepen');
        $groepen = [];
        $rules = [];

        foreach (range(1, $aantalGroepen) as $i) {
            $rules["groep_{$i}"] = 'nullable|string|max:255';
        }

        $request->validate($rules);

        foreach (range(1, $aantalGroepen) as $i) {
            $groepen[$i] = $request->input("groep_{$i}", '');
        }

        session(['wizard.groepen' => $groepen]);

        return redirect()->route('wizard.store');
    }

    public function store()
    {
        if (! session()->has('wizard.groepen')) {
            return redirect()->route('wizard.step1');
        }

        Verklaring::create([
            'user_id'        => auth()->id(),
            'naam'           => session('wizard.naam'),
            'adres'          => session('wizard.adres'),
            'postcode'       => session('wizard.postcode'),
            'stad'           => session('wizard.stad'),
            'aantal_groepen' => session('wizard.aantal_groepen'),
            'groepen'        => session('wizard.groepen'),
            'installateur'   => session('wizard.installateur'),
        ]);

        session()->forget(['wizard.naam', 'wizard.adres', 'wizard.postcode', 'wizard.stad', 'wizard.aantal_groepen', 'wizard.groepen', 'wizard.installateur']);

        return redirect()->route('verklaringen.index')
            ->with('success', 'Verklaring succesvol aangemaakt.');
    }
}
