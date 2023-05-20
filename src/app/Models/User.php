<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
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
    public function requests()
    {
        return $this->hasMany(Request::class);
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