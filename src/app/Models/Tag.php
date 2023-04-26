<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    const REQUEST_TYPE_ID=[
        'product'=>1,
        'event'=>2,
    ];

    public function getTagIdsByRequestTypeId($request_type_id){
        return $this->where('request_type_id',$request_type_id)->pluck('id')->toArray();
    }
}