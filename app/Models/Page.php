<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'status',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'seo_metaable');
    }
}
