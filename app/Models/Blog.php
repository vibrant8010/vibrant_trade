<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading',
        'detail_subcontent',
        'image_url',
    ];

    // Define the relationship with BlogSection
    public function sections()
    {
        return $this->hasMany(BlogSection::class);
    }
}