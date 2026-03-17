<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class WizardController extends Controller
{
    public function step1()
    {
        return view('wizard.step1');
    }

    public function step1Store(Request $request)
    {
        $request->validate([
            'naam'      => 'required|string|max:255',
            'adres'     => 'required|string|max:255',
            'postcode'  => 'required|string|max:20',
            'stad'      => 'required|string|max:255',
            'aantal_groepen' => 'required|integer|min:1|max:100',
        ]);

        session([
            'wizard.naam'           => $request->naam,
            'wizard.adres'          => $request->adres,
            'wizard.postcode'       => $request->postcode,
            'wizard.stad'           => $request->stad,
            'wizard.aantal_groepen' => (int) $request->aantal_groepen,
        ]);

        return redirect()->route('wizard.step2');
    }

    public function step2()
    {
        if (! session()->has('wizard.aantal_groepen')) {
            return redirect()->route('wizard.step1');
        }

        $aantalGroepen = session('wizard.aantal_groepen');

        return view('wizard.step2', compact('aantalGroepen'));
    }

    public function step2Store(Request $request)
    {
        if (! session()->has('wizard.aantal_groepen')) {
            return redirect()->route('wizard.step1');
        }

        $aantalGroepen = session('wizard.aantal_groepen');

        $rules = [];
        for ($i = 1; $i <= $aantalGroepen; $i++) {
            $rules["groep_{$i}"] = 'nullable|string|max:255';
        }

        $request->validate($rules);

        $groepen = [];
        for ($i = 1; $i <= $aantalGroepen; $i++) {
            $groepen[$i] = $request->input("groep_{$i}", '');
        }

        session(['wizard.groepen' => $groepen]);

        return redirect()->route('wizard.pdf');
    }

    public function generatePdf()
    {
        if (! session()->has('wizard.groepen')) {
            return redirect()->route('wizard.step1');
        }

        $data = [
            'naam'    => session('wizard.naam'),
            'adres'   => session('wizard.adres'),
            'postcode' => session('wizard.postcode'),
            'stad'    => session('wizard.stad'),
            'groepen' => session('wizard.groepen'),
        ];

        $pdf = Pdf::loadView('pdf.verklaring', $data)
            ->setPaper('a4', 'portrait');

        $naam = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $data['naam']);
        $bestandsnaam = "groepenkast_verklaring_{$naam}.pdf";

        return $pdf->download($bestandsnaam);
    }
}
