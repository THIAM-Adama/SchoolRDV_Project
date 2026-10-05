<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Disponibilite;
use App\Models\Rendezvous;
use App\Mail\RendezVousAnnuleMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DisponibiliteController extends Controller
{
    public function index()
    {
        $disponibilites = Disponibilite::where('agent_id', Auth::id())
            ->orderBy('date', 'asc')
            ->orderBy('heure_debut', 'asc')
            ->paginate(15);

        return view('agent.disponibilites.index', compact('disponibilites'));
    }

    public function create()
    {
        return view('agent.disponibilites.create');
    }

    /**
     * Enregistrement d'un créneau unitaire de 30 minutes.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $date = Carbon::parse($value);
                    if ($date->isWeekend()) {
                        $fail('Les disponibilités ne peuvent pas être fixées le week-end.');
                    }

                    $joursFeries = [
                        '2026-01-01', '2026-04-06', '2026-05-01', '2026-05-08',
                        '2026-05-14', '2026-05-25', '2026-07-14', '2026-08-15',
                        '2026-11-01', '2026-11-11', '2026-12-25'
                    ];
                    if (in_array($date->format('Y-m-d'), $joursFeries)) {
                        $fail('La date sélectionnée est un jour férié.');
                    }
                },
            ],
            'heure_debut' => 'required',
        ]);

        $start = Carbon::parse($request->date . ' ' . $request->heure_debut);
        $end = $start->copy()->addMinutes(30);

        $heureDebutFormatted = $start->format('H:i:s');
        $heureFinFormatted   = $end->format('H:i:s');

        $exists = Disponibilite::where('agent_id', Auth::id())
            ->where('date', $request->date)
            ->where('heure_debut', $heureDebutFormatted)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['heure_debut' => 'Un créneau existe déjà à cette date et heure pour votre compte.']);
        }

        Disponibilite::create([
            'agent_id'    => Auth::id(),
            'date'        => $request->date,
            'heure_debut' => $heureDebutFormatted,
            'heure_fin'   => $heureFinFormatted,
            'est_reserve' => false,
        ]);

        return redirect()->route('agent.disponibilites.index')
            ->with('success', 'Le créneau de 30 minutes a été ajouté avec succès.');
    }

    public function createMass()
    {
        return view('agent.disponibilites.generate_mass');
    }

    public function storeMass(Request $request)
    {
        $request->validate([
            'date_debut'  => 'required|date|after_or_equal:today',
            'date_fin'    => 'required|date|after_or_equal:date_debut',
            'heure_debut' => 'required',
            'heure_fin'   => 'required',
            'jours'       => 'required|array|min:1',
            'jours.*'     => 'integer|between:1,5',
        ]);

        $startDay = Carbon::parse($request->date_debut);
        $endDay   = Carbon::parse($request->date_fin);
        $joursSelectionnes = array_map('intval', $request->jours);
        $duree    = 30;
        $count    = 0;

        $joursFeries = [
            '2026-01-01', '2026-04-06', '2026-05-01', '2026-05-08',
            '2026-05-14', '2026-05-25', '2026-07-14', '2026-08-15',
            '2026-11-01', '2026-11-11', '2026-12-25'
        ];

        for ($day = $startDay->copy(); $day->lte($endDay); $day->addDay()) {
            if ($day->isWeekend() || in_array($day->format('Y-m-d'), $joursFeries)) {
                continue;
            }

            $dayOfWeek = (int) $day->format('N');
            if (!in_array($dayOfWeek, $joursSelectionnes)) {
                continue;
            }

            $currentTime = Carbon::parse($day->toDateString() . ' ' . $request->heure_debut);
            $endTime     = Carbon::parse($day->toDateString() . ' ' . $request->heure_fin);

            while ($currentTime->copy()->addMinutes($duree)->lte($endTime)) {
                $slotStart = $currentTime->format('H:i:s');
                $slotEnd   = $currentTime->copy()->addMinutes($duree)->format('H:i:s');

                $exists = Disponibilite::where('agent_id', Auth::id())
                    ->where('date', $day->toDateString())
                    ->where('heure_debut', $slotStart)
                    ->exists();

                if (!$exists) {
                    Disponibilite::create([
                        'agent_id'    => Auth::id(),
                        'date'        => $day->toDateString(),
                        'heure_debut' => $slotStart,
                        'heure_fin'   => $slotEnd,
                        'est_reserve' => false,
                    ]);
                    $count++;
                }

                $currentTime->addMinutes($duree);
            }
        }

        return redirect()->route('agent.disponibilites.index')
            ->with('success', "$count créneaux ont été générés avec succès.");
    }

    public function mesRendezVous(Request $request)
    {
        $agent = Auth::user();

        // Tri chronologique : de la date la plus proche à la plus éloignée
        $query = Rendezvous::select('rendez_vouses.*')
            ->join('disponibilites', 'rendez_vouses.disponibilite_id', '=', 'disponibilites.id')
            ->with(['etudiant', 'disponibilite'])
            ->whereHas('agent', function ($q) use ($agent) {
                if ($agent->service_id) {
                    $q->where('service_id', $agent->service_id);
                } else {
                    $q->where('id', $agent->id);
                }
            });

        if ($request->filled('statut')) {
            $query->where('rendez_vouses.statut', $request->statut);
        }

        $rendezvous = $query->orderBy('disponibilites.date', 'asc')
            ->orderBy('disponibilites.heure_debut', 'asc')
            ->paginate(10);

        return view('agent.rendezvous.index', compact('rendezvous'));
    }

    public function updateStatut(Request $request, Rendezvous $rendezvous)
    {
        $request->validate([
            'statut' => 'required|in:confirme,termine,absent,annule',
        ]);

        $rendezvous->update([
            'statut' => $request->statut,
        ]);

        // Si l'agent choisit d'annuler, on envoie le mail d'annulation
        if ($request->statut === 'annule') {
            $rendezvous->load(['etudiant', 'disponibilite']);

            if ($rendezvous->etudiant && $rendezvous->etudiant->email) {
                Mail::to($rendezvous->etudiant->email)->send(new RendezVousAnnuleMail($rendezvous));
            }
        }

        return back()->with('success', 'Le statut du rendez-vous a été mis à jour.');
    }
}