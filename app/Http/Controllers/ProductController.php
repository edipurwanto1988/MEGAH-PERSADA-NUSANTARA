<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        // Get product from database
        $product = Product::where('slug', $slug)->where('status', 'active')->firstOrFail();
        
        // Get related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->take(4)
            ->get();
        
        // Get company profile
        $companyProfile = CompanyProfile::first();
        
        return view('products.show', compact('product', 'relatedProducts', 'companyProfile'));
    }
    
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        // Get products from database
        $products = Product::where('status','active')->paginate(9);
        $categories = ProductCategory::get();
        
        // Get company profile
        $companyProfile = CompanyProfile::first();
        
        return view('products.index', compact('products', 'categories', 'companyProfile'));
    }
}