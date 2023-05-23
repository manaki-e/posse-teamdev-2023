<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Request;
use App\Models\Tag;

class RequestTag extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'request_tag';
    protected $fillable = [
        'request_id',
        'tag_id',
    ];
    public function request()
    {
        return $this->belongsTo(Request::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
