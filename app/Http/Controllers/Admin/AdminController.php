<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rendezvous;
use App\Models\Service;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'etudiants'  => User::where('role', 'etudiant')->count(),
            'agents'     => User::where('role', 'agent')->count(),
            'services'   => Service::count(),
            'rendezvous' => Rendezvous::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}