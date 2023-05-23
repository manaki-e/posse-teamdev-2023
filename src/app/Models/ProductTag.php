<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductTag extends Model
{
    protected $table = 'product_tag';
    use HasFactory, SoftDeletes;
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    public function scopeBelongsToProduct($query, $product_id)
    {
        return $query->where('product_id', $product_id);
    }
}
