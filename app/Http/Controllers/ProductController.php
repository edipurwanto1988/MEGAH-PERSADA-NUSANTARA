<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        // Get product from database with specifications and images
        $product = Product::with(['category', 'images'])->where('slug', $slug)->where('status', 'active')->firstOrFail();
        
        // Explicitly load specifications
        $product->specifications = $product->specifications()->get();
        
        // Get related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();
        
        // Get company profile
        $companyProfile = CompanyProfile::first();
        
        return view('products.show', compact('product', 'relatedProducts', 'companyProfile'));
    }
    
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        // Start with base query
        $query = Product::where('status', 'active');
        
        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('product_name', 'LIKE', '%' . $searchTerm . '%');
        }
        
        // Apply category filter if provided
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }
        
        // Get products from database
        $products = $query->paginate(9);
        $categories = ProductCategory::get();
        
        // Get company profile
        $companyProfile = CompanyProfile::first();
        
        return view('products.index', compact('products', 'categories', 'companyProfile'));
    }
    
    /**
     * Display products by category.
     */
    public function byCategory($slug)
    {
        // Get category by slug
        $category = ProductCategory::where('slug', $slug)->firstOrFail();
        
        // Start with base query for products in this category
        $query = Product::where('status', 'active')
                        ->where('category_id', $category->id);
        
        // Apply search filter if provided
        if (request()->has('search') && !empty(request()->search)) {
            $searchTerm = request()->search;
            $query->where('product_name', 'LIKE', '%' . $searchTerm . '%');
        }
        
        // Get products from database
        $products = $query->paginate(9);
        $categories = ProductCategory::get();
        
        // Get company profile
        $companyProfile = CompanyProfile::first();
        
        return view('products.index', compact('products', 'categories', 'companyProfile', 'category'));
    }
}