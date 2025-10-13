<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Advantage;
use App\Models\CompanyProfile;
use App\Models\Contact;
use App\Models\Menu;
use App\Models\FooterLink;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Get data from database
        $sliders = Slider::orderBy('order_no')->get();
        $products = Product::with('images')->where('status','active' )->take(6)->get();
        $posts = Post::with(['category', 'author'])
                     ->orderBy('published_date', 'desc')
                     ->take(3)
                     ->get();
        $partners = Partner::orderBy('order_no')->get();
        $companyProfile = CompanyProfile::first();
        $advantages = Advantage::orderBy('order_no')->get();
        $menus = Menu::orderBy('order_no')->get();
        
        // Get meta description, site email, and site address from settings
        $metaDescription = setting('meta_description');
        $siteEmail = setting('site_email');
        $siteAddress = setting('site_address');
        
        // Debug logs for products
        Log::info('Total products found: ' . $products->count());
        foreach ($products as $product) {
            Log::info('Product ID: ' . $product->id . ', Name: ' . $product->product_name . ', Images count: ' . $product->images->count());
            if ($product->images->count() > 0) {
                Log::info('First image URL: ' . $product->images->first()->image_url);
            }
        }
        
        return view('home', compact('sliders', 'products', 'posts', 'partners', 'companyProfile', 'advantages', 'menus', 'metaDescription', 'siteEmail', 'siteAddress'));
    }
    
    /**
     * Display the about page.
     */
    public function about()
    {
        $companyProfile = CompanyProfile::first();
        $advantages = Advantage::where('status', 'active')->orderBy('order_no')->get();
        $partners = Partner::where('status', 'active')->orderBy('order_no')->get();
        $menus = Menu::orderBy('order_no')->get();
        
        return view('about', compact('companyProfile', 'advantages', 'partners', 'menus'));
    }
    
    /**
     * Display the contact page.
     */
    public function contact()
    {
        $companyProfile = CompanyProfile::first();
        $menus = Menu::orderBy('order_no')->get();
        
        return view('contact', compact('companyProfile', 'menus'));
    }
    
    /**
     * Handle the contact form submission.
     */
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        Contact::create($validated);
        
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
    
    /**
     * Display all products.
     */
    public function products()
    {
        $products = Product::where('status', 1)->paginate(12);
        $categories = ProductCategory::where('status', 1)->get();
        $menus = Menu::orderBy('order_no')->get();
        
        return view('products', compact('products', 'categories', 'menus'));
    }
    
    /**
     * Display products by category.
     */
    public function productsByCategory($slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->where('status', 1)->paginate(12);
        $categories = ProductCategory::where('status', 1)->get();
        $menus = Menu::orderBy('order_no')->get();
        
        return view('products', compact('products', 'categories', 'category', 'menus'));
    }
    
    /**
     * Display a single product.
     */
    public function product($slug)
    {
        $product = Product::where('slug', $slug)->where('status', 1)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->take(4)
            ->get();
        $menus = Menu::orderBy('order_no')->get();
        
        return view('product', compact('product', 'relatedProducts', 'menus'));
    }
    
    /**
     * Display all posts.
     */
    public function posts()
    {
        $posts = Post::orderBy('published_date', 'desc')->paginate(9);
        $categories = PostCategory::where('status', 1)->get();
        $menus = Menu::orderBy('order_no')->get();
        
        return view('posts', compact('posts', 'categories', 'menus'));
    }
    
    /**
     * Display posts by category.
     */
    public function postsByCategory($slug)
    {
        $category = PostCategory::where('slug', $slug)->firstOrFail();
        $posts = Post::where('category_id', $category->id)->orderBy('published_date', 'desc')->paginate(9);
        $categories = PostCategory::where('status', 1)->get();
        $menus = Menu::orderBy('order_no')->get();
        
        return view('posts', compact('posts', 'categories', 'category', 'menus'));
    }
    
    /**
     * Display a single post.
     */
    public function post($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->orderBy('published_date', 'desc')
            ->take(3)
            ->get();
        $menus = Menu::orderBy('order_no')->get();
        
        return view('post', compact('post', 'relatedPosts', 'menus'));
    }
    
    /**
     * Display a page.
     */
    public function page($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 1)->firstOrFail();
        $menus = Menu::orderBy('order_no')->get();
        
        return view('page', compact('page', 'menus'));
    }
}
