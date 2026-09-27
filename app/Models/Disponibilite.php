<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disponibilite extends Model
{
    protected $fillable = [
        'agent_id',
        'date',
        'heure_debut',
        'heure_fin',
        'est_reservee',
    ];

    protected $casts = [
        'est_reservee' => 'boolean',
    ];

    /**
     * Relation : Une disponibilité appartient à un agent (utilisateur).
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Relation : Une disponibilité peut être liée à un rendez-vous.
     */
    public function rendezVous()
    {
        return $this->hasOne(RendezVous::class);
    }
}