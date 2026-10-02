<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Disponibilite;
use App\Models\RendezVous;
use App\Models\Service;
use App\Mail\AppointmentCancelledByStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RendezVousController extends Controller
{
    /**
     * Page de réservation des rendez-vous.
     */
    public function index(Request $request)
    {
        $services = Service::all();
        $selectedServiceId = $request->query('service_id');
        $selectedService = null;

        // IDs des créneaux déjà réservés (exclus de la liste)
        $creneauxReservesIds = Rendezvous::whereIn('statut', ['confirme', 'en_attente'])
            ->pluck('disponibilite_id')
            ->toArray();

        $query = Disponibilite::whereNotIn('id', $creneauxReservesIds);

        if ($selectedServiceId) {
            $selectedService = Service::find($selectedServiceId);

            $query->whereHas('agent', function ($subQ) use ($selectedServiceId) {
                $subQ->where('service_id', $selectedServiceId);
            });
        }

        $disponibilites = $query->get();

        $mesRendezvous = Rendezvous::with(['disponibilite', 'agent'])
            ->where('etudiant_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $rendezVous = $mesRendezvous;

        return view('etudiant.rendezvous.index', compact(
            'services', 
            'selectedService', 
            'selectedServiceId', 
            'disponibilites', 
            'mesRendezvous',
            'rendezVous'
        ));
    }

    /**
     * Liste des rendez-vous de l'étudiant.
     */
    public function mesRendezVous()
    {
        $mesRendezvous = Rendezvous::with(['disponibilite', 'agent'])
            ->where('etudiant_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $rendezVous = $mesRendezvous;

        return view('etudiant.rendezvous.mes_rdv', compact('mesRendezvous', 'rendezVous'));
    }

    /**
     * Réservation d'un créneau.
     */
    public function store(Request $request)
    {
        $request->validate([
            'disponibilite_id' => 'required|exists:disponibilites,id',
            'motif'            => 'nullable|string|max:500',
        ]);

        $disponibilite = Disponibilite::with('agent')->findOrFail($request->disponibilite_id);
        $agent = $disponibilite->agent;

        // 1. Créneau déjà pris ?
        $dejaReserve = Rendezvous::where('disponibilite_id', $disponibilite->id)
            ->whereIn('statut', ['confirme', 'en_attente'])
            ->exists();

        if ($dejaReserve) {
            return back()->with('error', 'Ce créneau vient tout juste d\'être réservé par un autre étudiant.');
        }

        // 2. Anti-spam : Un seul RDV actif par service
        if ($agent && $agent->service_id) {
            $hasActiveRdv = Rendezvous::where('etudiant_id', Auth::id())
                ->whereIn('statut', ['confirme', 'en_attente'])
                ->whereHas('agent', function ($q) use ($agent) {
                    $q->where('service_id', $agent->service_id);
                })
                ->exists();

            if ($hasActiveRdv) {
                return back()->with('error', 'Vous possédez déjà un rendez-vous actif pour ce service. Vous devez l\'annuler ou le déplacer pour pouvoir choisir une autre date.');
            }
        }

        DB::transaction(function () use ($request, $disponibilite) {
            $agentId = $disponibilite->agent_id ?? $disponibilite->user_id;

            Rendezvous::create([
                'etudiant_id'      => Auth::id(),
                'agent_id'         => $agentId,
                'disponibilite_id' => $disponibilite->id,
                'motif'            => $request->motif,
                'statut'           => 'confirme',
            ]);
        });

        return redirect()->route('etudiant.rendezvous.index')
            ->with('success', 'Votre rendez-vous a été confirmé avec succès !');
    }

    /**
     * Fonctionnalité : Déplacer / Replanifier un rendez-vous vers un nouveau créneau
     */
    public function deplacer(Request $request, Rendezvous $rendezvous)
    {
        if ($rendezvous->etudiant_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'nouvelle_disponibilite_id' => 'required|exists:disponibilites,id',
        ]);

        $nouvelleDispo = Disponibilite::findOrFail($request->nouvelle_disponibilite_id);

        // Vérifier si le nouveau créneau est disponible
        $dejaPris = Rendezvous::where('disponibilite_id', $nouvelleDispo->id)
            ->whereIn('statut', ['confirme', 'en_attente'])
            ->exists();

        if ($dejaPris) {
            return back()->with('error', 'Le créneau sélectionné n\'est plus disponible.');
        }

        DB::transaction(function () use ($rendezvous, $nouvelleDispo) {
            // Mettre à jour le rendez-vous vers la nouvelle disponibilité
            $rendezvous->update([
                'disponibilite_id' => $nouvelleDispo->id,
                'agent_id'         => $nouvelleDispo->agent_id ?? $nouvelleDispo->user_id,
                'statut'           => 'confirme',
            ]);
        });

        return redirect()->route('etudiant.rendezvous.index')
            ->with('success', 'Votre rendez-vous a bien été déplacé vers le nouveau créneau.');
    }

    /**
     * Annulation du RDV avec envoi de mail automatique.
     */
    public function annuler(Rendezvous $rendezvous)
    {
        if ($rendezvous->etudiant_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $rendezvous->update(['statut' => 'annule']);

        // Chargement des relations pour le mail
        $rendezvous->load(['etudiant', 'agent', 'disponibilite']);

        // Envoi automatique du mail de confirmation à l'étudiant
        if ($rendezvous->etudiant && $rendezvous->etudiant->email) {
            Mail::to($rendezvous->etudiant->email)->send(new AppointmentCancelledByStudent($rendezvous));
        }

        return back()->with('success', 'Votre rendez-vous a été annulé avec succès. Un e-mail de confirmation vous a été envoyé.');
    }
}