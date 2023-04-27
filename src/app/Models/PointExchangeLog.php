<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointExchangeLog extends Model
{
    use HasFactory;
    const MULTIPLE_OF = 500;
    const STATUS = [
        'PENDING' => 1,
        'APPROVED' => 2,
        'REJECTED' => 3
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function scopePending($query){
        return $query->where('status',self::STATUS['PENDING']);
    }
    public function scopeApproved($query){
        return $query->where('status',self::STATUS['APPROVED']);
    }
    public function scopeRejected($query){
        return $query->where('status',self::STATUS['REJECTED']);
    }
    public function scopeNotRejected($query){
        return $query->where('status','!=',self::STATUS['REJECTED']);
    }
}