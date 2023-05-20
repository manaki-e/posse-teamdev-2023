<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
