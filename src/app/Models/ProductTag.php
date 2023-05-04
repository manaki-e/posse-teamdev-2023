<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $table = 'product_tag';
    use HasFactory;
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    public function scopeBelongsToProduct($query, $product_id)
    {
        return $query->where('product_id', $product_id);
    }
}