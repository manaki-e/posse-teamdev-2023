<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    const STATUS=[
        'pending'=>1,
        'available'=>2,
        'occupied'=>3
    ];
    public static function getProductIds(){
        return self::pluck('id')->toArray();
    }
    public static function getPendingProductIds(){
        return self::where('point',null)->pluck('id')->toArray();
    }
    public static function getApprovedProductIds(){
        return self::where('point','!=',null)->pluck('id')->toArray();
    }
}