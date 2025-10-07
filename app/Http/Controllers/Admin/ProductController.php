<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Search by product name
        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Sort products
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('product_name', 'asc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $query->paginate(10);
        $categories = ProductCategory::all();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        $specifications = Specification::all();
        return view('admin.products.create', compact('categories', 'specifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'final_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'status' => 'required|in:active,inactive',
            'external_link' => 'nullable|url',
            'seo_description' => 'nullable|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specifications' => 'nullable|array',
            'specifications.*.specification_id' => 'required|exists:specifications,id',
            'specifications.*.spec_value' => 'required|string|max:255',
        ]);

        // Generate unique slug
        $slug = Str::slug($validated['product_name']);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        $validated['slug'] = $slug;

        // Extract specifications from validated data
        $specifications = $validated['specifications'] ?? [];
        unset($validated['specifications']);

        $product = Product::create($validated);

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('products', 'public');
                $thumbnailPath = $this->generateThumbnail($image);
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imagePath,
                    'thumbnail_url' => $thumbnailPath,
                ]);
            }
        }

        // Handle specifications
        if (!empty($specifications)) {
            foreach ($specifications as $spec) {
                $product->specifications()->attach($spec['specification_id'], [
                    'spec_value' => $spec['spec_value']
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        $specifications = Specification::all();
        $product->load('specifications');
        
        // Debug: Log product specifications
        \Log::info('Product specifications for product ' . $product->id . ': ' . json_encode($product->specifications));
        \Log::info('Specifications count: ' . ($product->specifications ? $product->specifications->count() : 'null'));
        
        // Debug: Check if specifications relationship exists
        if ($product->specifications) {
            \Log::info('Specifications relationship exists');
        } else {
            \Log::info('Specifications relationship is null');
        }
        
        return view('admin.products.edit', compact('product', 'categories', 'specifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'final_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'status' => 'required|in:active,inactive',
            'external_link' => 'nullable|url',
            'seo_description' => 'nullable|string|max:255',
            'new_images' => 'nullable|array',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specifications' => 'nullable|array',
            'specifications.*.specification_id' => 'required|exists:specifications,id',
            'specifications.*.spec_value' => 'required|string|max:255',
        ]);

        // Generate slug if product name changed
        if ($validated['product_name'] !== $product->product_name) {
            $slug = Str::slug($validated['product_name']);
            $originalSlug = $slug;
            $counter = 1;
            
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $validated['slug'] = $slug;
        }

        // Extract specifications from validated data
        $specifications = $validated['specifications'] ?? [];
        unset($validated['specifications']);

        // Debug: Log specifications data
        \Log::info('Specifications data: ' . json_encode($specifications));

        $product->update($validated);

        // Handle new images
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $index => $image) {
                $imagePath = $image->store('products', 'public');
                $thumbnailPath = $this->generateThumbnail($image);
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imagePath,
                    'thumbnail_url' => $thumbnailPath,
                ]);
            }
        }

        // Handle specifications
        if (!empty($specifications)) {
            // Debug: Log that we're processing specifications
            \Log::info('Processing specifications for product ' . $product->id);
            
            // Remove existing specifications
            $product->specifications()->detach();
            
            // Add new specifications
            foreach ($specifications as $spec) {
                // Debug: Log each specification being attached
                \Log::info('Attaching specification: ' . json_encode($spec));
                
                $product->specifications()->attach($spec['specification_id'], [
                    'spec_value' => $spec['spec_value']
                ]);
            }
        } else {
            // Debug: Log that specifications are empty
            \Log::info('No specifications provided for product ' . $product->id);
            
            // Remove all specifications if none provided
            $product->specifications()->detach();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete product images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url);
            if ($image->thumbnail_url) {
                Storage::disk('public')->delete($image->thumbnail_url);
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Delete a product image.
     */
    public function deleteImage(Product $product, ProductImage $image)
    {
        // Check if the image belongs to the product
        if ($image->product_id !== $product->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action'], 403);
        }

        // Delete image file
        Storage::disk('public')->delete($image->image_url);
        if ($image->thumbnail_url) {
            Storage::disk('public')->delete($image->thumbnail_url);
        }

        // Delete image record
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    /**
     * Save a single specification for a product.
     */
    public function saveSpecification(Request $request, Product $product)
    {
        $validated = $request->validate([
            'specification_id' => 'required|exists:specifications,id',
            'spec_value' => 'required|string|max:255',
        ]);

        // Remove existing specification if it exists
        $product->specifications()->wherePivot('specification_id', $validated['specification_id'])->detach();
        
        // Attach new specification
        $product->specifications()->attach($validated['specification_id'], [
            'spec_value' => $validated['spec_value']
        ]);

        return response()->json(['success' => true, 'message' => 'Specification saved successfully']);
    }

    /**
     * Delete a specification for a product.
     */
    public function deleteSpecification(Product $product, Specification $specification)
    {
        // Detach the specification from the product
        $product->specifications()->detach($specification->id);

        return response()->json(['success' => true, 'message' => 'Specification deleted successfully']);
    }

    /**
     * Generate a thumbnail for the uploaded image.
     */
    private function generateThumbnail($image)
    {
        $thumbnailWidth = 40;
        $thumbnailHeight = 40;
        
        try {
            // Check if Intervention Image is available
            if (class_exists('Intervention\Image\ImageManager')) {
                // Create an intervention image manager instance with GD driver
                $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                
                // Create an intervention image instance
                $img = $manager->read($image);
                
                // Resize the image to create a thumbnail
                $img->scale($thumbnailWidth, $thumbnailHeight);
                
                // Generate a unique filename for the thumbnail
                $filename = 'thumbnail_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Store the thumbnail
                $thumbnailPath = 'products/thumbnails/' . $filename;
                
                // Encode the image and store it
                $imageData = $img->encode();
                Storage::disk('public')->put($thumbnailPath, $imageData);
                
                return $thumbnailPath;
            } else {
                // If Intervention Image is not available, return null
                // This will allow the application to continue working without thumbnails
                return null;
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Thumbnail generation failed: ' . $e->getMessage());
            return null;
        }
    }
}
