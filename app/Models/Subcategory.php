<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    // Define the relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Ensure subcategory names are unique within the same category
    public static function boot()
    {
        parent::boot();

        static::creating(function ($subcategory) {
            $exists = Subcategory::where('category_id', $subcategory->category_id)
                ->where('name', $subcategory->name)
                ->exists();

            if ($exists) {
                throw new \Exception('Subcategory name must be unique within the same category.');
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
