<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestType extends Model
{
    use HasFactory;
    public static function getRequestTypeIds(){
        return self::pluck('id')->toArray();
    }
}