<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    const STATUS = [
        'pending' => 1,
        'available' => 2,
        'occupied' => 3
    ];
    const JAPANESE_STATUS = [
        1 => '承認待ち',
        2 => '貸出可能',
        3 => '貸出中'
    ];
    public function scopeGetProductIds($query)
    {
        return $query->pluck('id')->toArray();
    }
    public function scopePendingProducts($query)
    {
        return $query->where('status', self::STATUS['pending']);
    }
    public function scopeAvailableProducts($query)
    {
        return $query->where('status', self::STATUS['available']);
    }
    public function scopeOccupiedProducts($query)
    {
        return $query->where('status', self::STATUS['occupied']);
    }
    public function scopeApprovedProducts($query)
    {
        return $query->where('status', '!=', self::STATUS['pending']);
    }
    public function productDeals()
    {
        return $this->hasMany(ProductDealLog::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function request()
    {
        return $this->belongsTo(Request::class);
    }
    public function product_tags()
    {
        return $this->hasMany(ProductTag::class);
    }
    public function product_likes()
    {
        return $this->hasMany(ProductLike::class);
    }
}
