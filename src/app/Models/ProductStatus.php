<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    use HasFactory;
    const PENDING_PRODUCT_STATUS_ID = 1;
    const AVAILABLE_PRODUCT_STATUS_ID = 2;
    const OCCUPIED_PRODUCT_STATUS_ID = 3;
    public static function getProductStatusIds(){
        return self::pluck('id')->toArray();
    }
}