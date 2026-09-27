<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rendezvous extends Model
{
    use HasFactory;

    // Nom exact de ta table en base de données
    protected $table = 'rendez_vouses';

    protected $fillable = [
        'etudiant_id',
        'agent_id',
        'disponibilite_id',
        'motif',
        'statut',
    ];

    public function disponibilite()
    {
        return $this->belongsTo(Disponibilite::class, 'disponibilite_id');
    }

    public function etudiant()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}