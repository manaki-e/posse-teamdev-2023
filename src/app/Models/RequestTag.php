<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestTag extends Model
{
    use HasFactory;
    protected $table='request_tag';
    public function request(){
        return $this->belongsTo(Request::class);
    }
    public function tag(){
        return $this->belongsTo(Tag::class);
    }
}
