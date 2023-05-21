<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\User;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $japanese_product_statuses = Product::JAPANESE_STATUS;
        unset($japanese_product_statuses[1]);
        $product_tags = Tag::productTags()->get();
        $products = Product::approvedProducts()->withRelations()->paginate(8)->map(function ($product) use ($japanese_product_statuses) {
            $product->japanese_status = $japanese_product_statuses[$product->status];
            return $product;
        });
        return view('backend_test.items', compact('products', 'japanese_product_statuses', 'product_tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_tags = Tag::productTags()->get();
        return view('backend_test.items', compact('product_tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_instance = new Product();
        $images = $request->file('product_images');
        $product_instance->title = $request->title;
        $product_instance->user_id = Auth::id();
        $product_instance->description = $request->description;
        $product_instance->request_id = $request->request_id;
        $product_instance->save();
        $product_instance->addProductImages($images, $product_instance->id);
        $product_instance->updateProductTags($request->product_tags, $product_instance->id);
        return redirect('/items');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::withRelations()->findOrFail($id);
        //Productモデルからuser_idを取得して、そのユーザーのemailを取得
        $product->email = User::findOrFail($product->user_id)->email;
        $product->japanese_status = Product::JAPANESE_STATUS[$product->status];
        $product->japanese_condition = Product::CONDITION[$product->condition];
        $product->description = $product->changeDescriptionReturnToBreakTag($product->description);
        // このproduct_idをもつproduct_deal_logの最後のレコードのuser_idがログインユーザーの場合表示
        $last_product_deal_log = $product->productDealLogs->last();
        $login_user_can_borrow_this_product = $product->status === Product::STATUS['available'] && !$product->productBelongsToLoginUser();
        $login_borrower_can_cancel_or_receive_this_product = $product->status === Product::STATUS['delivering'] && $last_product_deal_log->user_id === Auth::id();
        $login_lender_can_return_this_product = $product->status === Product::STATUS['occupied'] && $product->productBelongsToLoginUser();
        return view('user.items.detail', compact('product', 'login_borrower_can_cancel_or_receive_this_product', 'login_lender_can_return_this_product', 'login_user_can_borrow_this_product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tags = Tag::productTags()->get()->map(function ($tag) {
            $tag->is_chosen = false;
            return $tag;
        });
        $chosen_product_tags = ProductTag::where('product_id', $id)->get();
        $product = Product::withRelations()->findOrFail($id);
        $product->japanese_product_status = Product::JAPANESE_STATUS[$product->status];
        foreach ($chosen_product_tags as $chosen_product_tag) {
            $tags->find($chosen_product_tag->tag_id)->is_chosen = true;
        }
        return view('backend_test.edit_item', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $images = $request->file('product_images');
        $product_instance = Product::findOrFail($id);
        $product_instance->addProductImages($images, $id);
        $product_instance->deleteProductImages($request->delete_images);
        $product_instance->updateProductTags($request->product_tags, $id);
        $product_instance->title = $request->title;
        $product_instance->description = $request->description;
        $product_instance->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        //ここはたぶんマイページに遷移
        return redirect('/items');
    }
    public function borrow($item)
    {
        $borrower_user_instance = Auth::user();
        $product_instance = Product::findOrFail($item);
        $lender_user_instance = $product_instance->user;
        // ポイント足りるか確認
        if ($borrower_user_instance->distribution_point < $product_instance->point) {
            return redirect()->back()->withErrors(['not_enough_points' => '消費ポイントが足りません']);
        }
        // 借りた人のポイント減る
        $borrower_user_instance->changeDistributionPoint(-$product_instance->point);
        // 貸した人のポイント増える
        $lender_user_instance->changeEarnedPoint($product_instance->point);
        // product_deal_log増える
        $product_instance->addProductDealLog($item, $borrower_user_instance->id);
        // productのステータス変更
        $product_instance->changeStatusToDelivering();
        // 処理が終わった後redirect back
        return redirect()->back();
    }
    public function return($item)
    {
        $product_instance = Product::findOrFail($item);
        $product_deal_log_instance = $product_instance->productDealLogs->last();
        // product_deal_logのreturned_at変更
        $product_deal_log_instance->changeReturnedAtToNow();
        // productのステータス変更
        $product_instance->changeStatusToAvailable();
        // 処理が終わった後redirect back
        return redirect()->back();
    }
    public function cancel($item)
    {
        $product_instance = Product::findOrFail($item);
        $product_deal_log_instance = $product_instance->productDealLogs->last();
        $lender_user_instance = $product_instance->user;
        // 貸した人のポイント減る
        $lender_user_instance->changeEarnedPoint(-$product_instance->point);
        // 借りた人のポイント変動なし
        // productのステータス変更
        $product_instance->changeStatusToAvailable();
        // product_deal_logのcanceled_at変更
        $product_deal_log_instance->changeCanceledAtToNow();
        // 処理が終わった後redirect back
        return redirect()->back();
    }
    public function receive($item)
    {
        //productのステータス変更
        $product_instance = Product::findOrFail($item);
        $product_instance->changeStatusToOccupied();
        //処理が終わった後redirect back
        return redirect()->back();
    }
}