<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'slug',
        'description',
        'price',
        'final_price',
        'external_link',
        'status',
        'category_id',
        'image',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'seo_metaable');
    }
    
    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'product_specifications')
            ->withPivot('spec_value')
            ->withTimestamps();
    }
}
