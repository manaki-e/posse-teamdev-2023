<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;

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
        return view('backend_test.items');
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
        $product_instance->title = $request->title;
        $product_instance->user_id = Auth::id();
        $product_instance->description = $request->description;
        $product_instance->request_id = $request->request_id;
        $product_instance->save();
        return view('backend_test.items');
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
        $product->japanese_status = Product::JAPANESE_STATUS[$product->status];
        $product->description = $product->changeDescriptionReturnToBreakTag($product->description);
        return view('backend_test.item', compact('product'));
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
    public function borrow($id)
    {
        $product_instance = Product::findOrFail($id);
        $product_instance->changeStatusToOccupied();
        return redirect()->back();
    }
    public function return($id)
    {
        $product_instance = Product::findOrFail($id);
        $product_instance->changeStatusToAvailable();
        return redirect()->back();
    }
    public function cancel($id)
    {
        $product_instance = Product::findOrFail($id);
        $product_instance->changeStatusToAvailable();
        return redirect()->back();
    }
}