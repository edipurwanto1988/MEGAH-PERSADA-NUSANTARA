<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'slug',
        'description',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(PostCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(PostCategory::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'seo_metaable');
    }

    // Accessor for compatibility with frontend that uses 'name'
    public function getNameAttribute()
    {
        return $this->attributes['category_name'] ?? null;
    }

    // Mutator to handle both field names
    public function setNameAttribute($value)
    {
        $this->attributes['category_name'] = $value;
    }

    // Override the save method to handle field mapping
    public function save(array $options = [])
    {
        // If 'name' is set but 'category_name' is not, copy the value
        if (isset($this->attributes['name']) && !isset($this->attributes['category_name'])) {
            $this->attributes['category_name'] = $this->attributes['name'];
        }
        
        // Remove the 'name' attribute to prevent database errors
        unset($this->attributes['name']);
        
        return parent::save($options);
    }
}
