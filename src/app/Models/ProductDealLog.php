<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use App\Models\User;

class ProductDealLog extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'returned_at', 'deleted_at'];
    const UNCHARGEABLE_MONTH_COUNT = 1;
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
    public function scopeUserInvolved($query, $user_id)
    {
        return $query->where('user_id', $user_id)->with('product.user')->orwhereHas('product', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        });
    }
    public function scopeNotCancelled($query)
    {
        return $query->whereNull('cancelled_at');
    }
    public function changeReturnedAtToNow()
    {
        $this->returned_at = now();
        $this->save();
    }
    public function changeCancelledAtToNow()
    {
        $this->cancelled_at = now();
        $this->save();
    }
    public function scopeChargeable($query)
    {
        return $query->where('month_count', '!=', self::UNCHARGEABLE_MONTH_COUNT);
    }
}