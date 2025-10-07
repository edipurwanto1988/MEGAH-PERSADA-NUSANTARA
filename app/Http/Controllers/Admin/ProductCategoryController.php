<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::with('parent', 'children')->get();
        return view('admin.product-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::whereNull('parent_id')->get();
        return view('admin.product-categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:product_categories,id',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['category_name']);

        ProductCategory::create($validated);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        return view('admin.product-categories.show', compact('productCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        $categories = ProductCategory::whereNull('parent_id')
            ->where('id', '!=', $productCategory->id)
            ->get();
        return view('admin.product-categories.edit', compact('productCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:product_categories,id',
        ]);

        // Generate slug if category name changed
        if ($validated['category_name'] !== $productCategory->category_name) {
            $validated['slug'] = Str::slug($validated['category_name']);
        }

        // Prevent setting a category as its own parent or descendant
        if ($validated['parent_id'] == $productCategory->id) {
            return redirect()->back()
                ->with('error', 'A category cannot be its own parent.')
                ->withInput();
        }

        $productCategory->update($validated);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        // Check if category has children
        if ($productCategory->children()->count() > 0) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Cannot delete a category with subcategories.');
        }

        // Check if category has products
        if ($productCategory->products()->count() > 0) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Cannot delete a category with products.');
        }

        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category deleted successfully.');
    }
}
