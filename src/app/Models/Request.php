<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasFactory, SoftDeletes;
    const PRODUCT_REQUEST_TYPE_ID = 1;
    const EVENT_REQUEST_TYPE_ID = 2;
    public static function booted()
    {
        static::deleted(function ($request) {
            $request->requestLikes()->delete();
            $request->requestTags()->delete();
        });
    }
    public static function getRequestIds()
    {
        return self::pluck('id')->toArray();
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function requestLikes()
    {
        return $this->hasMany(RequestLike::class);
    }
    public function requestTags()
    {
        return $this->hasMany(RequestTag::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getRequestType($id)
    {
        if ($id == self::PRODUCT_REQUEST_TYPE_ID) {
            return 'アイテム';
        } else {
            return 'イベント';
        }
    }
    public function scopeResolvedRequests($query)
    {
        return $query->where('completed_at', '!=', null);
    }
    public function scopeUnresolvedRequests($query)
    {
        return $query->where('completed_at', null);
    }
    public function scopeProductRequests($query)
    {
        return $query->where('type_id', self::PRODUCT_REQUEST_TYPE_ID);
    }
    public function scopeEventRequests($query)
    {
        return $query->where('type_id', self::EVENT_REQUEST_TYPE_ID);
    }
    public function changeDescriptionReturnToBreakTag($value)
    {
        return str_replace("\n", "<br>", e($value));
    }
}
