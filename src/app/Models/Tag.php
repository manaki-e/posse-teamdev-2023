<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function getIdsByRequestTypeId($request_type_id)
    {
        return $this->where('request_type_id', $request_type_id)->pluck('id')->toArray();
    }
    public function scopeProductTags($query)
    {
        return $query->where('request_type_id', Request::PRODUCT_REQUEST_TYPE_ID);
    }
    public function scopeEventTags($query)
    {
        return $query->where('request_type_id', Request::EVENT_REQUEST_TYPE_ID);
    }
}