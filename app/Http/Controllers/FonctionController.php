<?php

namespace App\Http\Controllers;

use App\Models\Fonction;
use App\Models\Groupe;
use App\Models\Position;
use Illuminate\Http\Request;

class FonctionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $positions = Fonction::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                        ->orWhere('abrv', 'like', "%{$search}%");
        })->paginate(10);

        return view('fonctions.index', compact('positions', 'search'));
    }

    public function create()
    {
        $groupes = Groupe::all();
    return view('fonctions.create', compact('groupes'));
      
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abrv' => 'required|string|max:10',
            'cat' => 'required|integer',
        ]);

        Fonction::create($request->all());

        return redirect()->route('fonctions.index')
                         ->with('success', 'Position created successfully.');
    }

    public function show(Fonction $position)
    {
        return view('fonctions.show', compact('position'));
    }

    public function edit(Fonction $position)
    {
        $groupes = Groupe::all();
    return view('fonctions.edit', compact('fonction', 'groupes'));
       
    }

    public function update(Request $request, Fonction $position)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abrv' => 'required|string|max:10',
            'cat' => 'required|integer',
        ]);

        $position->update($request->all());

        return redirect()->route('fonctions.index')
                         ->with('success', 'Position updated successfully.');
    }

    public function destroy(Fonction $position)
    {
        $position->delete();

        return redirect()->route('fonctions.index')
                         ->with('success', 'Position deleted successfully.');
    }
}