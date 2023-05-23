<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Event;
use App\Models\EventLike;
use App\Models\EventParticipantLog;
use App\Models\ProductDealLog;
use App\Models\PointExchangeLog;
use App\Models\Product;
use App\Models\ProductLike;
use App\Models\Request;
use App\Models\RequestLike;
use App\Models\Department;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static function booted()
    {
        static::deleted(function ($user) {
            $user->eventLikes()->delete();
            $user->events()->delete();
            $user->eventParticipantLogs()->delete();
            $user->productDealLogs()->delete();
            $user->pointExchangeLogs()->delete();
            $user->products()->delete();
            $user->productLikes()->delete();
            $user->requests()->delete();
            $user->requestLikes()->delete();
        });
    }
    public static function getUserIds()
    {
        return self::pluck('id')->toArray();
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function eventLikes()
    {
        return $this->hasMany(EventLike::class);
    }
    public function eventParticipantLogs()
    {
        return $this->hasMany(EventParticipantLog::class);
    }
    public function productDealLogs()
    {
        return $this->hasMany(ProductDealLog::class);
    }
    public function pointExchangeLogs()
    {
        return $this->hasMany(PointExchangeLog::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function productLikes()
    {
        return $this->hasMany(ProductLike::class);
    }
    public function requests()
    {
        return $this->hasMany(Request::class);
    }
    public function requestLikes()
    {
        return $this->hasMany(RequestLike::class);
    }
    public function changeEarnedPoint($earned_point)
    {
        $this->earned_point += $earned_point;
        $this->save();
    }
    public function changeDistributionPoint($distribution_point)
    {
        $this->distribution_point += $distribution_point;
        $this->save();
    }
}
