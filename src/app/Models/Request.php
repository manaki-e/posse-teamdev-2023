<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    const PRODUCT_REQUEST_TYPE_ID = 1;
    const EVENT_REQUEST_TYPE_ID = 2;
    public static function getRequestIds()
    {
        return self::pluck('id')->toArray();
    }
}
