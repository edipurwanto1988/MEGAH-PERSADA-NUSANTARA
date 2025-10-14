<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specification;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $specifications = Specification::withCount('products')
            ->when($search, function ($query, $search) {
                return $query->where('spec_name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();
            
        return view('admin.specifications.index', compact('specifications', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.specifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'spec_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Specification::create($validated);

        return redirect()->route('admin.specifications.index')
            ->with('success', 'Specification created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specification $specification)
    {
        $specification->load('products');
        return view('admin.specifications.show', compact('specification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specification $specification)
    {
        return view('admin.specifications.edit', compact('specification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specification $specification)
    {
        $validated = $request->validate([
            'spec_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $specification->update($validated);

        return redirect()->route('admin.specifications.index')
            ->with('success', 'Specification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specification $specification)
    {
        // Check if specification has products
        if ($specification->products()->count() > 0) {
            return redirect()->route('admin.specifications.index')
                ->with('error', 'Cannot delete a specification that is being used by products.');
        }

        $specification->delete();

        return redirect()->route('admin.specifications.index')
            ->with('success', 'Specification deleted successfully.');
    }

    /**
     * Check if specification exists or create a new one
     */
    public function checkOrCreate(Request $request)
    {
        $validated = $request->validate([
            'spec_name' => 'required|string|max:255',
        ]);

        // Check if specification already exists
        $specification = Specification::where('spec_name', $validated['spec_name'])->first();

        if ($specification) {
            return response()->json([
                'success' => true,
                'message' => 'Specification already exists',
                'specification_id' => $specification->id
            ]);
        }

        // Create new specification
        $specification = Specification::create([
            'spec_name' => $validated['spec_name'],
            'description' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Specification created successfully',
            'specification_id' => $specification->id
        ]);
    }
}