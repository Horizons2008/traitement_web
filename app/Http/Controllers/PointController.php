<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index()
    {
        $points = Point::orderBy('cat')->orderBy('echelon')->get();
        return view('points.index', compact('points'));
    }

    public function create()
    {
        return view('points.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cat' => 'required|integer|min:1',
            'echelon' => 'required|integer|min:0',
            'valeur' => 'required|integer|min:0',
        ]);

        Point::create($validated);

        return redirect()->route('points.index')
                         ->with('success', 'Point created successfully.');
    }

    public function show(Point $point)
    {
        return view('points.show', compact('point'));
    }

    public function edit(Point $point)
    {
        return view('points.edit', compact('point'));
    }

    public function update(Request $request, Point $point)
    {
        $validated = $request->validate([
            'cat' => 'required|integer|min:1',
            'echelon' => 'required|integer|min:0',
            'valeur' => 'required|integer|min:0',
        ]);

        $point->update($validated);

        return redirect()->route('points.index')
                         ->with('success', 'Point updated successfully.');
    }

    public function destroy(Point $point)
    {
        $point->delete();

        return redirect()->route('points.index')
                         ->with('success', 'Point deleted successfully.');
    }
}