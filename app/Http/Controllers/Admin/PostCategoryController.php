<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = PostCategory::with('parent', 'children')->get();
        return view('admin.post-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PostCategory::whereNull('parent_id')->get();
        return view('admin.post-categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:post_categories,id',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Set category_name for backward compatibility
        $validated['category_name'] = $validated['name'];

        $category = PostCategory::create($validated);

        // Check if request is AJAX (for modal form)
        if ($request->header('X-Requested-With') === 'XMLHttpRequest' ||
            $request->ajax() ||
            $request->wantsJson() ||
            $request->has('_ajax')) {
            return response()->json([
                'success' => true,
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug
                ],
                'message' => 'Post category created successfully.'
            ]);
        }

        return redirect()->route('admin.post-categories.index')
            ->with('success', 'Post category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PostCategory $postCategory)
    {
        return view('admin.post-categories.show', compact('postCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostCategory $postCategory)
    {
        $categories = PostCategory::whereNull('parent_id')
            ->where('id', '!=', $postCategory->id)
            ->get();
        return view('admin.post-categories.edit', compact('postCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostCategory $postCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:post_categories,id',
        ]);

        // Generate slug if category name changed
        if ($validated['name'] !== $postCategory->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Set category_name for backward compatibility
        $validated['category_name'] = $validated['name'];

        // Prevent setting a category as its own parent or descendant
        if ($validated['parent_id'] == $postCategory->id) {
            return redirect()->back()
                ->with('error', 'A category cannot be its own parent.')
                ->withInput();
        }

        $postCategory->update($validated);

        return redirect()->route('admin.post-categories.index')
            ->with('success', 'Post category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostCategory $postCategory)
    {
        // Check if category has children
        if ($postCategory->children()->count() > 0) {
            return redirect()->route('admin.post-categories.index')
                ->with('error', 'Cannot delete a category with subcategories.');
        }

        // Check if category has posts
        if ($postCategory->posts()->count() > 0) {
            return redirect()->route('admin.post-categories.index')
                ->with('error', 'Cannot delete a category with posts.');
        }

        $postCategory->delete();

        return redirect()->route('admin.post-categories.index')
            ->with('success', 'Post category deleted successfully.');
    }
}
