<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'nullable|string|max:100',
        ]);

        Service::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'duration'    => $request->duration,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'nullable|string|max:100',
        ]);

        $service->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'duration'    => $request->duration,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
