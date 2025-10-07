<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'spec_name',
        'description',
    ];
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_specifications')
            ->withPivot('spec_value')
            ->withTimestamps();
    }
}
