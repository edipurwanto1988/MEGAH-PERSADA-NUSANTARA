<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_name',
        'parent_id',
        'link_type',
        'link_id',
        'custom_url',
        'order_no',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order_no');
    }

    public function getLinkedItem()
    {
        switch($this->link_type) {
            case 'page':
                return $this->belongsTo(Page::class, 'link_id');
            case 'post':
                return $this->belongsTo(Post::class, 'link_id');
            case 'product':
                return $this->belongsTo(Product::class, 'link_id');
            case 'category':
                return $this->belongsTo(ProductCategory::class, 'link_id');
            default:
                return null;
        }
    }

    public function getUrl()
    {
        try {
            switch($this->link_type) {
                case 'page':
                    $page = Page::find($this->link_id);
                    return $page ? route('pages.show', $page->slug) : '#';
                case 'post':
                    $post = Post::find($this->link_id);
                    return $post ? route('articles.show', $post->slug) : '#';
                case 'product':
                    $product = Product::find($this->link_id);
                    return $product ? route('products.show', $product->id) : '#';
                case 'category':
                    $category = ProductCategory::find($this->link_id);
                    return $category ? route('products.index', ['category' => $category->slug]) : '#';
                case 'custom':
                    return $this->custom_url ?: '#';
                default:
                    return '#';
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Menu URL generation error: ' . $e->getMessage());
            return '#';
        }
    }

    public function getLinkLabel()
    {
        switch($this->link_type) {
            case 'page':
                $page = Page::find($this->link_id);
                return $page ? $page->title : 'Page not found';
            case 'post':
                $post = Post::find($this->link_id);
                return $post ? $post->title : 'Post not found';
            case 'product':
                $product = Product::find($this->link_id);
                return $product ? $product->product_name : 'Product not found';
            case 'category':
                $category = ProductCategory::find($this->link_id);
                return $category ? $category->category_name : 'Category not found';
            case 'custom':
                return $this->custom_url ?: 'Custom URL';
            default:
                return 'Unknown';
        }
    }
}
