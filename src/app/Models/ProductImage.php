<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use App\Models\Image;
use App\Models\User;
use App\Models\ProductImageLike;

class ProductImage extends Model
{
    use HasFactory, SoftDeletes;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function productImageLike()
    {
        return $this->hasMany(ProductImageLike::class);
    }
}
