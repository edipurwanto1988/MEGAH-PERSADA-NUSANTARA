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
        $article = Post::where('slug', $slug)->firstOrFail();
        
        // Get related articles
        $relatedArticles = Post::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();
        
        // Get company profile
        $companyProfile = CompanyProfile::first();
        
        return view('articles.show', compact('article', 'relatedArticles', 'companyProfile'));
    }
    
    /**
     * Display a listing of the articles.
     */
    public function index()
    {
        // Get articles from database
        $articles = Post::orderBy('published_date', 'desc')->paginate(9);
        $categories = PostCategory::where('status', 1)->get();
        
        // Get company profile
        $companyProfile = CompanyProfile::first();
        
        return view('articles.index', compact('articles', 'categories', 'companyProfile'));
    }
}