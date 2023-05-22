<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use App\Models\RequestTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //タグのリクエストタイプID
        $event_request_type_id = ModelsRequest::EVENT_REQUEST_TYPE_ID;
        $product_request_type_id = ModelsRequest::PRODUCT_REQUEST_TYPE_ID;
        //タググループ分けして取得
        $event_tags = Tag::where('request_type_id', $event_request_type_id)->get();
        $product_tags = Tag::where('request_type_id', $product_request_type_id)->get();
        return view('backend_test.add_request', compact('event_tags', 'product_tags', 'event_request_type_id', 'product_request_type_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all_tags = Tag::all();
        //add record to requests table using title,description,type_id
        $request_instance = new ModelsRequest();
        $request_instance->title = $request->title;
        $request_instance->description = $request->description;
        $request_instance->type_id = $request->type_id;
        $request_instance->user_id = Auth::id();
        $request_instance->save();
        //add record to request_tag table using request_id,tag_id
        foreach ($request->tags as $tag_id) {
            //type_idによってレコード追加するか判断
            $is_proper_tag = $all_tags->find($tag_id)->request_type_id === $request->type_id;
            if ($is_proper_tag) {
                RequestTag::create([
                    'request_id' => $request_instance->id,
                    'tag_id' => $tag_id
                ]);
            }
        }
        return redirect()->route('requests.create')->with('success', 'リクエストを追加しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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