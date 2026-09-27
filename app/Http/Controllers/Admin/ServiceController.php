<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::withCount('agents')->orderBy('nom')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:255|unique:services,nom',
            'description' => 'nullable|string',
        ]);

        Service::create($request->only('nom', 'description'));

        return redirect()->route('admin.services.index')->with('success', 'Service créé avec succès.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'nom'         => 'required|string|max:255|unique:services,nom,' . $service->id,
            'description' => 'nullable|string',
        ]);

        $service->update($request->only('nom', 'description'));

        return redirect()->route('admin.services.index')->with('success', 'Service mis à jour avec succès.');
    }

    public function destroy(Service $service)
    {
        if ($service->agents()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un service auquel des agents sont rattachés.');
        }

        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service supprimé avec succès.');
    }
}