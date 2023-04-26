<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    const PRODUCT_REQUEST_TYPE_ID = 1;
    const EVENT_REQUEST_TYPE_ID = 2;
    public function getTagIdsByRequestTypeId($request_type_id){
        return $this->where('request_type_id',$request_type_id)->pluck('id')->toArray();
    }
}