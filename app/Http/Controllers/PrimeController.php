<?php

namespace App\Http\Controllers;

use App\Models\Prime;
use App\Models\Groupe;
use Illuminate\Http\Request;

class PrimeController extends Controller
{
    public function index(Request $request)
    {
        $query = Prime::query();
        
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
        
        $primes = $query->with('groupe')->paginate(10);
        $groupes = Groupe::all();
        
        return view('primes.index', compact('primes', 'groupes'));
    }

    public function create()
    {
        $groupes = Groupe::all();
        return view('primes.create', compact('groupes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abrv' => 'required|string|max:10',
            'groupe_id' => 'required|exists:groupes,id',
            'mode' => 'required|in:0,1,2',
            'min_cat' => 'nullable|integer|min:1',
            'max_cat' => 'nullable|integer|min:1|gte:min_cat'
        ]);

        try {
            Prime::create($request->all());
            return redirect()->route('primes.index')
                           ->with('success', 'Prime created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Error creating prime: ' . $e->getMessage());
        }
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
        $request->validate([
            'title' => 'required|string|max:255',
            'abrv' => 'required|string|max:10',
            'groupe_id' => 'required|exists:groupes,id',
            'mode' => 'required|in:0,1,2',
            'min_cat' => 'nullable|integer|min:1',
            'max_cat' => 'nullable|integer|min:1|gte:min_cat'
        ]);

        try {
            $prime->update($request->all());
            return redirect()->route('primes.index')
                           ->with('success', 'Prime updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Error updating prime: ' . $e->getMessage());
        }
    }

    public function destroy(Prime $prime)
    {
        try {
            $prime->delete();
            return redirect()->route('primes.index')
                           ->with('success', 'Prime deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting prime: ' . $e->getMessage());
        }
    }
}