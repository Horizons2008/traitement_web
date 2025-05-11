<?php

namespace App\Http\Controllers;

use App\Models\Prime;
use App\Models\PrimeConfiguration;
use Illuminate\Http\Request;

class PrimeConfigurationController extends Controller
{
    public function index(Prime $prime)
    { 
        $configurations = $prime->configurations;
        return view('configurations.index', compact('prime', 'configurations'));
    }

    public function create(Prime $prime, PrimeConfiguration $configuration = null)
    {
        return view('configurations.create', compact('prime', 'configuration'));
    }

    public function store(Request $request, Prime $prime)
    {
        $validated = $request->validate([
            'min_cat' => 'nullable|integer',
            'max_cat' => 'nullable|integer',
            'valeur' => 'required|integer|min:0'
        ]);
       
        $validated['prime_id'] = $prime->id;

        // Check for existing configuration
        $exists = $prime->configurations()
            ->where('min_cat', $validated['min_cat'])
            ->where('max_cat', $validated['max_cat'])
            ->exists();
           
        if ($exists) {
            return back()->withInput()
                ->withErrors(['unique' => 'A configuration with these category ranges already exists for this prime.']);
        }

        $prime->configurations()->create($validated);

        return redirect()->route('primes.configurations.index', ['prime' => $prime->id])
            ->with('success', 'Configuration added successfully.');
    }

    public function edit(Prime $prime, PrimeConfiguration $configuration)
    {
        return $this->create($prime, $configuration);
    }

    public function update(Request $request, Prime $prime, PrimeConfiguration $configuration)
    {
        $validated = $request->validate([
            'min_cat' => 'nullable|integer',
            'max_cat' => 'nullable|integer',
            'valeur' => 'required|integer|min:0'
        ]);

        // Check for existing configuration (excluding current one)
        $exists = $prime->configurations()
            ->where('id', '!=', $configuration->id)
            ->where('min_cat', $validated['min_cat'])
            ->where('max_cat', $validated['max_cat'])
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->withErrors(['unique' => 'A configuration with these category ranges already exists for this prime.']);
        }

        $configuration->update($validated);

        return redirect()->route('primes.configurations.index', ['prime' => $prime->id])
            ->with('success', 'Configuration updated successfully.');
    }

    public function destroy(Prime $prime, PrimeConfiguration $configuration)
    {
        $configuration->delete();
        return redirect()->route('primes.configurations.index', ['prime' => $prime->id])
            ->with('success', 'Configuration deleted successfully.');
    }
}