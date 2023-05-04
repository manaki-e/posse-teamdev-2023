<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class Product extends Model
{
    use HasFactory;
    use softDeletes;
    const STATUS = [
        'pending' => 1,
        'available' => 2,
        'occupied' => 3
    ];
    const JAPANESE_STATUS = [
        1 => '承認待ち',
        2 => '貸出可能',
        3 => '貸出中'
    ];
    public function scopeGetProductIds($query)
    {
        return $query->pluck('id')->toArray();
    }
    public function scopePendingProducts($query)
    {
        return $query->where('status', self::STATUS['pending']);
    }
    public function scopeAvailableProducts($query)
    {
        return $query->where('status', self::STATUS['available']);
    }
    public function scopeOccupiedProducts($query)
    {
        return $query->where('status', self::STATUS['occupied']);
    }
    public function scopeApprovedProducts($query)
    {
        return $query->where('status', '!=', self::STATUS['pending']);
    }
    public function scopeBelongsToLoginUser($query)
    {
        return $query->where('user_id', Auth::id());
    }
    public function productDeals()
    {
        return $this->hasMany(ProductDealLog::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function request()
    {
        return $this->belongsTo(Request::class);
    }
    public function productTags()
    {
        return $this->hasMany(ProductTag::class);
    }
    public function productLikes()
    {
        return $this->hasMany(ProductLike::class);
    }
    public function scopeWithRelations($query)
    {
        return $query->with('user')->with('request')->with('productImages')->with('productTags.tag')->withCount('productLikes')->with('productLikes');
    }
    public function changeDescriptionReturnToBreakTag($value)
    {
        return str_replace("\n", "<br>", e($value));
    }
    public function changeStatusToPending()
    {
        $this->status = self::STATUS['pending'];
        $this->save();
    }
    public function changeStatusToAvailable()
    {
        $this->status = self::STATUS['available'];
        $this->save();
    }
    public function changeStatusToOccupied()
    {
        $this->status = self::STATUS['occupied'];
        $this->save();
    }
    public function addProductImages($images, $product_id)
    {
        if (!empty($images)) {
            foreach ($images as $image) {
                $product_image_instance = new ProductImage();
                $next_public_images_file_name = 'sample_product_' . (count(File::files(public_path('images'))) + 1) . '.jpeg';
                $image->move(public_path('images'), $next_public_images_file_name);
                $product_image_instance->product_id = $product_id;
                $product_image_instance->image_url = $next_public_images_file_name;
                $product_image_instance->save();
            }
        }
        return;
    }
    public function deleteProductImages($product_image_id_array)
    {
        if (!empty($product_image_id_array)) {
            foreach ($product_image_id_array as $product_image_id) {
                $product_image_instance = ProductImage::findOrFail($product_image_id);
                $product_image_instance->delete();
            }
        }
        return;
    }
    public function updateProductTags($product_tag_id_array, $product_id)
    {
        //ロジックめんどいから全部削除して追加する
        ProductTag::belongsToProduct($product_id)->delete();
        if (!empty($product_tag_id_array)) {
            foreach ($product_tag_id_array as $product_tag_id) {
                $product_tags_instance = new ProductTag();
                $product_tags_instance->product_id = $product_id;
                $product_tags_instance->tag_id = $product_tag_id;
                $product_tags_instance->save();
            }
        }
        //idはテーブルのid,tag_idはタグのid
        return;
    }
}
