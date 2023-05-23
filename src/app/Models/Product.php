<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use App\Models\ProductDealLog;
use App\Models\User;
use App\Models\ProductImage;
use App\Models\Request;
use App\Models\ProductTag;
use App\Models\ProductLike;

class Product extends Model
{
    use HasFactory, softDeletes;
    const STATUS = [
        'pending' => 1,
        'available' => 2,
        'occupied' => 3,
        'delivering' => 4
    ];
    const JAPANESE_STATUS = [
        1 => '承認待ち',
        2 => '貸出可能',
        3 => '貸出中',
        4 => '配送中'
    ];
    public static function booted()
    {
        static::deleted(function ($product) {
            $product->productImages()->delete();
            $product->productTags()->delete();
            $product->productLikes()->delete();
            $product->productDealLogs()->delete();
        });
    }
    public function scopeGetProductIds($query)
    {
        return $query->pluck('id')->toArray();
    }
    public function scopeGetProductIdsAndPoints($query)
    {
        return $query->get(['point', 'id']);
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
    public function scopeDeliveringProducts($query)
    {
        return $query->where('status', self::STATUS['delivering']);
    }
    public function scopeApprovedProducts($query)
    {
        return $query->where('status', '!=', self::STATUS['pending']);
    }
    public function scopeBelongsToLoginUser($query)
    {
        return $query->where('user_id', Auth::id());
    }
    public function productDealLogs()
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
    public function changeStatusToDelivering()
    {
        $this->status = self::STATUS['delivering'];
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
    public function addProductDealLog($product_id, $user_id, $point)
    {
        $product_deal_log_instance = new ProductDealLog();
        $product_deal_log_instance->product_id = $product_id;
        $product_deal_log_instance->user_id = $user_id;
        $product_deal_log_instance->point = $point;
        //ログインユーザーが前回このproductを借りたときのレコードを取得
        $user_product_last_product_deal_log = ProductDealLog::where('user_id',$user_id)->where('product_id', $product_id)->latest()->first();
        if ($user_product_last_product_deal_log && !$user_product_last_product_deal_log->returned_at && !$user_product_last_product_deal_log->canceled_at) {
            //前回借りたときにcancelしてないかつreturnしてないなら連続借りとして扱う
            $product_deal_log_instance->start_of_streak_id = $user_product_last_product_deal_log->start_of_streak_id;
        } else {
            //連続取引ではない場合はstart_of_streak_idにこのレコードのidを入れる
            $last_product_deal_log_id = $product_deal_log_instance->latest('id')->value('id');
            $product_deal_log_instance->start_of_streak_id = $last_product_deal_log_id + 1;
        }
        $product_deal_log_instance->save();
        return;
    }
    public function productBelongsToLoginUser()
    {
        return $this->user_id === Auth::id();
    }
}
