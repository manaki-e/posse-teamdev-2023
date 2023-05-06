<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Tag;

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
        $japanese_product_statuses = Product::JAPANESE_STATUS;
        $not_pending_products = Product::approvedProducts()->with('user')->paginate(10, ['*'], 'not_pending')->appends(['pending' => request('pending')]);

        //登録申請対応待ちアイテム一覧
        $pending_products = Product::pendingProducts()->with('user')->paginate(5, ['*'], 'pending')->appends(['not_pending' => request('not_pending')]);

        return view('admin.items.index', compact('not_pending_products', 'pending_products'));
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
        $product = Product::with('user')->with('productImages')->with('request')->with('productDeals.user')->with('productTags.tag')->withCount('productLikes')->findOrFail($id);
        $product->japanese_status = Product::JAPANESE_STATUS[$product->status];
        return view('backend_test.admin_item', compact('product'));
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
        return view('backend_test.admin_edit_item', compact('product', 'tags'));
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
        $product_instance = Product::findOrFail($id);
        switch ($request->form_type) {
            case 'update_product':
                $images = $request->file('product_images');
                $product_instance->addProductImages($images, $id);
                $product_instance->deleteProductImages($request->delete_images);
                $product_instance->updateProductTags($request->product_tags, $id);
                $product_instance->title = $request->title;
                $product_instance->description = $request->description;
                break;
            case 'set_point_and_approve':
                $product_instance->point = $request->point;
                $product_instance->status = Product::STATUS['available'];
                break;
            case 'reset_point':
                $product_instance->point = $request->point;
                break;
        }
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
        return redirect('/admin/items');
    }
}
