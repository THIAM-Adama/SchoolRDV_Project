<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Agent\DisponibiliteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Etudiant\RendezVousController as EtudiantRendezVousController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Page d'accueil publique
Route::get('/', function () {
    return view('welcome');
});

// Dashboard générique
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Dashboards spécifiques
Route::get('/agent/dashboard', function () {
    return view('agent.dashboard');
})->middleware(['auth', 'verified', 'role:agent'])->name('agent.dashboard');

// Page de Contact globale (accessible à tous les utilisateurs connectés)
Route::middleware('auth')->group(function () {
    Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
});


// ==========================================
// ROUTES ACCESSIBLES UNIQUEMENT À L'ADMIN
// ==========================================
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // CRUD Utilisateurs
    Route::resource('users', UserController::class);

    // CRUD Services
    Route::resource('services', ServiceController::class);
});


// ==========================================
// ROUTES ACCESSIBLES UNIQUEMENT AUX AGENTS
// ==========================================
Route::middleware(['auth', 'verified', 'role:agent'])->prefix('agent')->name('agent.')->group(function () {
    // Gestion des disponibilités
    Route::get('/disponibilites', [DisponibiliteController::class, 'index'])->name('disponibilites.index');
    Route::get('/disponibilites/creer', [DisponibiliteController::class, 'create'])->name('disponibilites.create');
    Route::post('/disponibilites', [DisponibiliteController::class, 'store'])->name('disponibilites.store');
    
    // Génération en masse des créneaux
    Route::get('/disponibilites/masse', [DisponibiliteController::class, 'createMass'])->name('disponibilites.create_mass');
    Route::post('/disponibilites/masse', [DisponibiliteController::class, 'storeMass'])->name('disponibilites.store_mass');

    // Suivi et gestion des rendez-vous par l'agent
    Route::get('/rendezvous', [DisponibiliteController::class, 'mesRendezVous'])->name('rendezvous.index');
    Route::patch('/rendezvous/{rendezvous}/statut', [DisponibiliteController::class, 'updateStatut'])->name('rendezvous.update_statut');
});


// =============================================
// ROUTES ACCESSIBLES UNIQUEMENT AUX ÉTUDIANTS
// =============================================
Route::middleware(['auth', 'verified', 'role:etudiant'])->prefix('etudiant')->name('etudiant.')->group(function () {
    Route::get('/rendezvous', [EtudiantRendezVousController::class, 'index'])->name('rendezvous.index');
    Route::post('/rendezvous', [EtudiantRendezVousController::class, 'store'])->name('rendezvous.store');
    Route::patch('/rendezvous/{rendezvous}/deplacer', [EtudiantRendezVousController::class, 'deplacer'])->name('rendezvous.deplacer');
    Route::get('/mes-rendezvous', [EtudiantRendezVousController::class, 'mesRendezVous'])->name('rendezvous.mes_rdv');
    Route::patch('/rendezvous/{rendezvous}/annuler', [EtudiantRendezVousController::class, 'annuler'])->name('rendezvous.annuler');
});


// Profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Page Politique de confidentialité & RGPD
Route::get('/politique-confidentialite', function () {
    return view('politique_confidentialite');
})->name('politique.confidentialite');


require __DIR__.'/auth.php';