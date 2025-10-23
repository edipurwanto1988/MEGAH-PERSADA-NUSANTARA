<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display the specified article.
     */
    public function show($slug)
    {
        // Get article from database
        $article = Post::with('category')
                    ->where('slug', $slug)
                    ->firstOrFail();
        
        // Get related articles
        $relatedArticles = Post::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();
        
        // Get company profile
        $companyProfile = CompanyProfile::first();
        
        // SEO data for article detail
        $title = $article->title . ' - ' . setting('company_name', 'Megah Persada Nusantara');
        $metaDescription = $article->meta_description ?? substr(strip_tags($article->content ?? ''), 0, 160);
        $metaKeywords = $article->meta_keywords ?? $article->title . ', ' . ($article->category->category_name ?? '') . ', ' . setting('company_name', 'Megah Persada Nusantara');
        
        // OG data
        $ogImage = $article->featured_image ?? setting('og_image');
        $ogUrl = url()->current();
        
        return view('articles.show', compact('article', 'relatedArticles', 'companyProfile', 'title', 'metaDescription', 'metaKeywords', 'ogImage', 'ogUrl'));
    }
    
    /**
     * Display a listing of the articles.
     */
    public function index()
    {
        // Get articles from database with category relationship
        $articles = Post::with('category')->orderBy('published_date', 'desc')->paginate(9);
        $categories = PostCategory::where('status', 1)->get();
        
        // Get company profile
        $companyProfile = CompanyProfile::first();
        
        // SEO data for articles listing
        $title = 'Artikel - ' . setting('company_name', 'Megah Persada Nusantara');
        $metaDescription = setting('meta_description', 'Baca artikel menarik dari ' . setting('company_name', 'Megah Persada Nusantara'));
        $metaKeywords = 'artikel, blog, ' . setting('company_name', 'Megah Persada Nusantara');
        
        return view('articles.index', compact('articles', 'categories', 'companyProfile', 'title', 'metaDescription', 'metaKeywords'));
    }
    
    /**
     * Display articles by category.
     */
    public function byCategory($slug)
    {
        // Get category by slug
        $category = PostCategory::where('slug', $slug)->firstOrFail();
        
        // Get articles from database with category relationship
        $articles = Post::with('category')
                        ->where('category_id', $category->id)
                        ->orderBy('published_date', 'desc')
                        ->paginate(9);
        $categories = PostCategory::where('status', 1)->get();
        
        // Get company profile
        $companyProfile = CompanyProfile::first();
        
        // SEO data for category articles
        $title = ($category->category_name ?? 'Artikel') . ' - ' . setting('company_name', 'Megah Persada Nusantara');
        $metaDescription = 'Baca artikel kategori ' . ($category->category_name ?? '') . ' dari ' . setting('company_name', 'Megah Persada Nusantara');
        $metaKeywords = ($category->category_name ?? '') . ', artikel, blog, ' . setting('company_name', 'Megah Persada Nusantara');
        
        return view('articles.index', compact('articles', 'categories', 'companyProfile', 'category', 'title', 'metaDescription', 'metaKeywords'));
    }
}