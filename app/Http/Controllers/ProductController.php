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
        
        // SEO data for product detail
        $title = $product->product_name . ' - ' . setting('company_name', 'Megah Persada Nusantara');
        $metaDescription = $product->short_description ?? substr(strip_tags($product->description ?? ''), 0, 160);
        $metaKeywords = $product->product_name . ', ' . ($product->category->category_name ?? '') . ', ' . setting('company_name', 'Megah Persada Nusantara');
        
        // OG data
        $ogImage = $product->images->first()->image_url ?? setting('og_image');
        $ogUrl = url()->current();
        
        return view('products.show', compact('product', 'relatedProducts', 'companyProfile', 'title', 'metaDescription', 'metaKeywords', 'ogImage', 'ogUrl'));
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
        
        // SEO data for products listing
        $title = 'Produk - ' . setting('company_name', 'Megah Persada Nusantara');
        $metaDescription = setting('meta_description', 'Lihat daftar produk berkualitas dari ' . setting('company_name', 'Megah Persada Nusantara'));
        $metaKeywords = 'produk, ' . setting('company_name', 'Megah Persada Nusantara') . ', kualitas';
        
        return view('products.index', compact('products', 'categories', 'companyProfile', 'title', 'metaDescription', 'metaKeywords'));
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
        
        // SEO data for category products
        $title = ($category->category_name ?? 'Produk') . ' - ' . setting('company_name', 'Megah Persada Nusantara');
        $metaDescription = 'Lihat daftar produk kategori ' . ($category->category_name ?? '') . ' dari ' . setting('company_name', 'Megah Persada Nusantara');
        $metaKeywords = ($category->category_name ?? '') . ', produk, ' . setting('company_name', 'Megah Persada Nusantara');
        
        return view('products.index', compact('products', 'categories', 'companyProfile', 'category', 'title', 'metaDescription', 'metaKeywords'));
    }
}