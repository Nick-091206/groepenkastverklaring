<?php

namespace App\Http\Controllers;

use App\Models\Verklaring;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class VerklaringController extends Controller
{
    public function index(): View
    {
        $verklaringen = auth()->user()->verklaringen()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('verklaringen.index', [
            'verklaringen' => $verklaringen,
            'title'        => 'Mijn Verklaringen',
            'showOwner'    => false,
        ]);
    }

    public function all(): View
    {
        $verklaringen = Verklaring::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('verklaringen.index', [
            'verklaringen' => $verklaringen,
            'title'        => 'Alle Verklaringen',
            'showOwner'    => true,
        ]);
    }

    public function edit(Verklaring $verklaring): View
    {
        return view('verklaringen.edit', compact('verklaring'));
    }

    public function update(Request $request, Verklaring $verklaring): RedirectResponse
    {
        $request->validate([
            'naam'                  => 'required|string|max:255',
            'adres'                 => 'required|string|max:255',
            'postcode'              => 'required|string|max:20',
            'stad'                  => 'required|string|max:255',
            'aantal_groepen'        => 'required|integer|min:1|max:100',
            'installateur'          => 'nullable|string|max:255',
            'installateur_telefoon' => 'nullable|string|max:255',
        ]);

        $aantalGroepen = (int) $request->aantal_groepen;
        $groepen = [];

        foreach (range(1, $aantalGroepen) as $i) {
            $groepen[$i] = $request->input("groep_{$i}", '');
        }

        $verklaring->update([
            'naam'                  => $request->naam,
            'adres'                 => $request->adres,
            'postcode'              => $request->postcode,
            'stad'                  => $request->stad,
            'aantal_groepen'        => $aantalGroepen,
            'groepen'               => $groepen,
            'installateur'          => $request->installateur,
            'installateur_telefoon' => $request->installateur_telefoon,
        ]);

        return redirect()->route('verklaringen.index')
            ->with('success', 'Verklaring succesvol bijgewerkt.');
    }

    public function download(Verklaring $verklaring): Response
    {
        $data = [
            'naam'                  => $verklaring->naam,
            'adres'                 => $verklaring->adres,
            'postcode'              => $verklaring->postcode,
            'stad'                  => $verklaring->stad,
            'groepen'               => $verklaring->groepen,
            'installateur'          => $verklaring->installateur,
            'installateur_telefoon' => $verklaring->installateur_telefoon,
            'datum'                 => $verklaring->updated_at->format('d-m-Y'),
        ];

        $pdf = Pdf::loadView('pdf.verklaring', $data)->setPaper('a4', 'portrait');
        $filename = 'groepenkast_verklaring_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $data['naam']) . '.pdf';

        return $pdf->download($filename);
    }

    public function destroy(Verklaring $verklaring): RedirectResponse
    {
        if ($verklaring->user_id !== auth()->id()) {
            abort(403);
        }

        $verklaring->delete();

        return redirect()->route('verklaringen.index')
            ->with('success', 'Verklaring succesvol verwijderd.');
    }
}
