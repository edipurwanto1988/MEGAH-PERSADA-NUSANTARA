<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'category_id',
        'tags',
        'author_id',
        'published_date',
        'published_at',
        'status',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'seo_metaable');
    }
}
