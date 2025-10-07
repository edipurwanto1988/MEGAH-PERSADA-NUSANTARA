<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with('category', 'author');
        
        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%')
                  ->orWhere('excerpt', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Handle status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Handle category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }
        
        // Handle sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $posts = $query->paginate(10)->withQueryString();
        $categories = PostCategory::all();
        
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PostCategory::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug logging
        \Log::info('Post store method called');
        \Log::info('Request data', ['data' => $request->all()]);
        \Log::info('Has file', ['has_file' => $request->hasFile('featured_image')]);
        \Log::info('Files in request', ['files' => $request->allFiles()]);
        
        if ($request->hasFile('featured_image')) {
            \Log::info('File details', [
                'originalName' => $request->file('featured_image')->getClientOriginalName(),
                'size' => $request->file('featured_image')->getSize(),
                'mimeType' => $request->file('featured_image')->getMimeType(),
                'error' => $request->file('featured_image')->getError(),
                'errorMessage' => $request->file('featured_image')->getErrorMessage()
            ]);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:post_categories,id',
            'status' => 'required|in:draft,published',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);
        
        // Set author to current logged in user
        $validated['author_id'] = auth()->id();
        
        // Set published_at if status is published
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            \Log::info('Attempting to store file');
            try {
                $imagePath = $request->file('featured_image')->store('posts', 'public');
                \Log::info('File stored at', ['path' => $imagePath]);
                $validated['featured_image'] = $imagePath;
            } catch (\Exception $e) {
                \Log::error('Error storing file', ['error' => $e->getMessage()]);
                throw $e;
            }
        }

        $post = Post::create($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = PostCategory::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:post_categories,id',
            'status' => 'required|in:draft,published',
        ]);

        // Generate slug if title changed
        if ($validated['title'] !== $post->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set published_at if status changed to published
        if ($validated['status'] === 'published' && $post->status !== 'published') {
            $validated['published_at'] = now();
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            
            $imagePath = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $imagePath;
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Delete featured image
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
