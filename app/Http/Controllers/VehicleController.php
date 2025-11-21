<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;

use App\Models\Vehicle;

class VehicleController extends Controller
{
    
    public function index()
    {
        $vehicles = Vehicle::orderBy('license_plate')->get();
        return Inertia::render('vehicles/Index', [
            'vehicles' => $vehicles,
        ]);
    }

    public function create()
    {
        return Inertia::render('vehicles/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|max:255|unique:vehicles',
            'description' => 'required|string|max:255',
        ]);

        Vehicle::create([
            'license_plate' => $validated['license_plate'],
            'description' => $validated['description'],
        ]);

        return to_route('vehicles.index');
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return Inertia::render('vehicles/Show', [
            'vehicle' => $vehicle,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|max:255|unique:vehicles,license_plate,' . $id,
            'description' => 'required|string|max:255',
        ]);

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update([
            'license_plate' => $validated['license_plate'],
            'description' => $validated['description'],
        ]);

        return to_route('vehicles.index');
    }

    public function destroy(Request $request, $id)
    {

        $vehicle = Vehicle::findOrFail($id);
        $validated = $request->validate([
            'licensePlate' => 'required|string|in:' . $vehicle->license_plate,
        ], [
            'licensePlate.in' => 'The license plate you entered does not match.',
        ]);

        if ($validated) {
            $vehicle->delete();
            return to_route('vehicles.index');
        }
        
    }

}
