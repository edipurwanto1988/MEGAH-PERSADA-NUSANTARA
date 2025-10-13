<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_name',
        'slug',
        'description',
        'parent_id',
        'status',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'featured_image',
        'tags',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the name attribute.
     */
    public function getNameAttribute()
    {
        return $this->category_name;
    }

    /**
     * Set the name attribute.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['category_name'] = $value;
    }

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(PostCategory::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(PostCategory::class, 'parent_id');
    }

    /**
     * Get the posts for the category.
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
