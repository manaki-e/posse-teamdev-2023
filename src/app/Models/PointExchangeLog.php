<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class PointExchangeLog extends Model
{
    use HasFactory, SoftDeletes;
    const MULTIPLE_OF = 500;
    const STATUS = [
        'PENDING' => 1,
        'APPROVED' => 2
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS['PENDING']);
    }
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS['APPROVED']);
    }
    public static function getUserPointExchangeLogs($user_id)
    {
        return self::where('user_id', $user_id)->get();
    }
    public function formatPointExchangeLogForMyPageEarnedPointHistory()
    {
        return [
            'app' => 'PP',
            'name' => '換金申請',
            'created_at' => $this->created_at,
            'point' => -$this->point,
        ];
    }
}
