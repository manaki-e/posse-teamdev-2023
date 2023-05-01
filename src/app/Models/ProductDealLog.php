<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDealLog extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at', 'returned_at', 'deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeCurrentMonth($query)
    {
        return $query->where('created_at', '>=', now()->startOfMonth());
    }
    public function scopeBorrowedThisMonth($query)
    {
        return $query->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
    }
}