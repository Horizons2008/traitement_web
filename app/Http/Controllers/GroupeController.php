<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $positions = Groupe::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                        ;
        })->paginate(10);

        return view('groupes.index', compact('positions', 'search'));
    }

    public function create()
    {
        return view('groupes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            
        ]);

        Groupe::create($request->all());

        return redirect()->route('groupes.index')
                         ->with('success', 'Position created successfully.');
    }

    public function show(Groupe $position)
    {
        return view('groupes.show', compact('position'));
    }

    public function edit(Groupe $position)
    {
        return view('groupes.edit', compact('position'));
    }

    public function update(Request $request, Groupe $position)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            
        ]);

        $position->update($request->all());

        return redirect()->route('groupes.index')
                         ->with('success', 'Position updated successfully.');
    }

    public function destroy(Groupe $position)
    {dd($position);
        $position->delete();

        return redirect()->route('groupes.index')
                         ->with('success', 'Position deleted successfully.');
    }
}