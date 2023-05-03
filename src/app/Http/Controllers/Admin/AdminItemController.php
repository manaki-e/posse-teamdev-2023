<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //登録済みアイテム一覧
        $product_japanese_statuses = Product::JAPANESE_STATUS;
        $not_pending_products = Product::approvedProducts()->with('user')->get()->map(function ($not_pending_product) use ($product_japanese_statuses) {
            $not_pending_product->japanese_status = $product_japanese_statuses[$not_pending_product->status];
            return $not_pending_product;
        });
        foreach ($not_pending_products as $not_pending_product) {
            var_dump($not_pending_product->title);
            var_dump($not_pending_product->point);
            var_dump($not_pending_product->user->name);
            var_dump($not_pending_product->japanese_status);
            print_r('<br>');
        }
        //登録申請対応待ちアイテム一覧
        $pending_products = Product::pendingProducts()->with('user')->get();
        foreach ($pending_products as $pending_product) {
            var_dump($pending_product->title);
            var_dump($pending_product->user->name);
            var_dump($pending_product->created_at->format('Y年m月d日 H:i:s'));
            print_r('<br>');
        }
        // return view('admin.item.index',compact('not_pending_products','pending_products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('user')->with('product_images')->with('request')->with('product_deals.user')->with('product_tags.tag')->withCount('product_likes')->findOrFail($id);
        $product->japanese_status = Product::JAPANESE_STATUS[$product->status];
        print_r('タイトル' . $product->title . '<br>');
        print_r('ステータス' . $product->japanese_status . '<br>');
        print_r('ポイント' . $product->point . '<br>');
        print_r('いいね' . $product->product_likes_count . '<br>');
        print_r('説明' . $product->description . '<br>');
        print_r('タグ<br>');
        foreach ($product->product_tags as $product_tag) {
            print_r($product_tag->tag->name . '<br>');
        }
        print_r('貸出履歴<br>');
        foreach ($product->product_deals as $product_deal) {
            print_r($product_deal->user->name . $product_deal->created_at->format('Y年m月d日 H:i:s') . '<br>');
        }
        print_r('出品者' . $product->user->name . '<br>');
        dd($product);
        return view('admin.item.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}