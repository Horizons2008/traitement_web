<?php

namespace App\Http\Controllers;

use App\Models\Fonction;
use App\Models\Groupe;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\Prime;

class FonctionController extends Controller
{
    public function index(Request $request)
    {
        $query = Fonction::query();
        
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('abrv', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('groupe_id')) {
            $query->where('groupe_id', $request->get('groupe_id'));
        }
        
        $fonctions = $query->with('groupe')->latest()->paginate(10);
        $groupes = Groupe::all();
        
        return view('fonctions.index', [
            'fonctions' => $fonctions,
            'groupes' => $groupes,
            'search' => $request->get('search', ''),
            'groupeId' => $request->get('groupe_id', '')
        ]);
    }

    public function create()
    {
        $groupes = Groupe::all();
        return view('fonctions.create', compact('groupes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abrv' => 'required|string|max:10',
            'cat' => 'required|integer',
            'groupe_id' => 'required|exists:groupes,id'
        ]);

        try {
            $data = $request->all();
            \Log::info('Creating fonction with data:', $data);
            
            $fonction = Fonction::create($data);
            \Log::info('Fonction created successfully:', ['id' => $fonction->id]);
            
            return redirect()->route('fonctions.index')
                           ->with('success', 'Fonction créée avec succès.');
        } catch (\Exception $e) {
            \Log::error('Error creating fonction: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Erreur: ' . $e->getMessage()]);
        }
    }

    public function show(Fonction $position)
    {
        return view('fonctions.show', compact('position'));
    }

    public function edit(Fonction $fonction)
    {
        $groupes = Groupe::all();
        return view('fonctions.edit', compact('fonction', 'groupes'));
    }

    public function update(Request $request, Fonction $fonction)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abrv' => 'required|string|max:10',
            'cat' => 'required|integer',
        ]);

        $fonction->update($request->all());

        return redirect()->route('fonctions.index')
                            ->with('success', 'Fonction updated successfully.');
    }

    public function destroy(Fonction $fonction)
    {
        $fonction->delete();

        return redirect()->route('fonctions.index')
                         ->with('success', 'Fonction deleted successfully.');
    }
}