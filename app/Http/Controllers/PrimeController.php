<?php

namespace App\Http\Controllers;

use App\Models\Prime;
use App\Models\Groupe;
use Illuminate\Http\Request;

class PrimeController extends Controller
{
    public function index(Request $request)

    {$groupe_id=$request->groupe_id;
       // dd($request->all());
        $primes = Prime::with('groupe')->where('groupe_id', $groupe_id )-> latest()->get();
        $groupes = Groupe::all();
        return view('primes.index', compact('primes','groupes','groupe_id'));
    }

    public function create()
    {
        $groupes = Groupe::all();
        return view('primes.create', compact('groupes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abrv' => 'required|string|max:10',
            'groupe_id' => 'required|exists:groupes,id',
            'min_cat' => 'nullable|integer|min:1',
            'max_cat' => 'nullable|integer|min:1|gte:min_cat',
            'mode' => 'integer|in:0,1,2',
        ]);

        Prime::create($validated);

        return redirect()->route('primes.index')
                         ->with('success', 'Prime created successfully.');
    }

    public function show(Prime $prime)
    {
        return view('primes.show', compact('prime'));
    }

    public function edit(Prime $prime)
    {
        $groupes = Groupe::all();
        return view('primes.edit', compact('prime', 'groupes'));
    }

    public function update(Request $request, Prime $prime)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abrv' => 'required|string|max:10',
            'groupe_id' => 'required|exists:groupes,id',
            'min_cat' => 'nullable|integer|min:1',
            'max_cat' => 'nullable|integer|min:1|gte:min_cat',
            'mode' => 'integer|in:0,1,2',

        ]);

        $prime->update($validated);

        return redirect()->route('primes.index')
                         ->with('success', 'Prime updated successfully.');
    }

    public function destroy(Prime $prime)
    {
        $prime->delete();

        return redirect()->route('primes.index')
                         ->with('success', 'Prime deleted successfully.');
    }
}