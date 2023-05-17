<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDealLog extends Model
{
    use HasFactory;
    use softDeletes;
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
    public function scopeUserInvolved($query, $user_id)
    {
        return $query->where('user_id', $user_id)->with('product.user')->orwhereHas('product', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        });
    }
    public function scopeNotCanceled($query)
    {
        return $query->whereNull('canceled_at');
    }
    public function changeReturnedAtToNow()
    {
        $this->returned_at = now();
        $this->save();
    }
    public function changeCanceledAtToNow()
    {
        $this->canceled_at = now();
        $this->save();
    }
}