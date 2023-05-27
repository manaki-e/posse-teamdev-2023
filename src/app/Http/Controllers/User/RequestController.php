<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use App\Models\RequestLike;
use App\Models\RequestTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $event_request_type_id = ModelsRequest::EVENT_REQUEST_TYPE_ID;
        $product_request_type_id = ModelsRequest::PRODUCT_REQUEST_TYPE_ID;
        $app = [
            $product_request_type_id => ['color' => 'text-blue-400', 'name' => 'Peer Product Share', 'japanese_name' => 'アイテム'],
            $event_request_type_id => ['color' => 'text-pink-600', 'name' => 'Peer Event', 'japanese_name' => 'イベント']
        ];
        $product_tags = Tag::where('request_type_id', $product_request_type_id)->get();
        $event_tags = Tag::where('request_type_id', $event_request_type_id)->get();
        $requests = ModelsRequest::with(['user', 'requestTags.tag'])->withCount('requestLikes')->orderBy('created_at', 'desc')->unresolvedRequests()->get()->map(function ($request) {
            $request->description = $request->changeDescriptionReturnToBreakTag($request->description);
            $request->data_tag = '[' . implode(',', $request->requestTags->pluck('tag_id')->toArray()) . ']';
            if ($request->requestLikes->contains('user_id', Auth::id())) {
                $request->isLiked = 1;
            } else {
                $request->isLiked = 0;
            }
            return $request;
        });
        return view('user.requests.index', compact('requests', 'product_tags', 'event_tags', 'app', 'event_request_type_id', 'product_request_type_id'));
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
        return view('user.requests.create', compact('event_tags', 'product_tags', 'event_request_type_id', 'product_request_type_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //add record to requests table using title,description,type_id
        $request_instance = new ModelsRequest();
        $request_instance->title = $request->title;
        $request_instance->description = $request->description;
        $request_instance->type_id = $request->type_id;
        $request_instance->user_id = Auth::id();
        $request_instance->save();
        //add record to request_tag table using request_id,tag_id
        if ((int)$request->type_id === ModelsRequest::EVENT_REQUEST_TYPE_ID) {
            if (!empty($request->event_tags)) {
                foreach ($request->event_tags as $tag_id) {
                    RequestTag::create([
                        'request_id' => $request_instance->id,
                        'tag_id' => $tag_id
                    ]);
                }
            }
        } else {
            if (!empty($request->product_tags)) {
                foreach ($request->product_tags as $tag_id) {
                    RequestTag::create([
                        'request_id' => $request_instance->id,
                        'tag_id' => $tag_id
                    ]);
                }
            }
        }
        return Redirect::route('requests.index')->with(['flush.message' => 'リクエストを追加しました', 'flush.alert_type' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = ModelsRequest::with(['user', 'requestTags.tag'])->find($id);
        return view('backend_test.delete_request', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event_request_type_id = ModelsRequest::EVENT_REQUEST_TYPE_ID;
        $product_request_type_id = ModelsRequest::PRODUCT_REQUEST_TYPE_ID;
        $event_tags = Tag::where('request_type_id', $event_request_type_id)->get()->map(function ($tag) {
            $tag->checked = false;
            return $tag;
        });
        $product_tags = Tag::where('request_type_id', $product_request_type_id)->get()->map(function ($tag) {
            $tag->checked = false;
            return $tag;
        });
        $request = ModelsRequest::with(['requestTags.tag'])->find($id);
        if ($request->type_id == $event_request_type_id) {
            $request->requestTags->map(function ($request_tag) use (&$event_tags) {
                $event_tags->map(function ($event_tag) use ($request_tag) {
                    if ($event_tag->id === $request_tag->tag_id) {
                        $event_tag->checked = true;
                    }
                    return $event_tag;
                });
                return $request_tag;
            });
        } else {
            $request->requestTags->map(function ($request_tag) use ($product_tags) {
                $product_tags->map(function ($product_tag) use ($request_tag) {
                    if ($product_tag->id === $request_tag->tag_id) {
                        $product_tag->checked = true;
                    }
                    return $product_tag;
                });
                return $request_tag;
            });
        }
        return view('user.requests.edit', compact('request', 'event_tags', 'product_tags', 'event_request_type_id', 'product_request_type_id'));
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
        //request_tagテーブルのレコードを削除
        RequestTag::where('request_id', $id)->delete();
        //requestテーブルのレコードを更新
        $request_instance = ModelsRequest::find($id);
        $request_instance->title = $request->title;
        $request_instance->description = $request->description;
        $request_instance->type_id = $request->type_id;
        $request_instance->save();
        //request_tagテーブルのレコードを追加
        if ($request->type_id == ModelsRequest::EVENT_REQUEST_TYPE_ID) {
            if (!empty($request->event_tags)) {
                foreach ($request->event_tags as $tag_id) {
                    RequestTag::create([
                        'request_id' => $request_instance->id,
                        'tag_id' => $tag_id
                    ]);
                }
            }
        } else {
            if (!empty($request->product_tags)) {
                foreach ($request->product_tags as $tag_id) {
                    RequestTag::create([
                        'request_id' => $request_instance->id,
                        'tag_id' => $tag_id
                    ]);
                }
            }
        }
        return redirect()->route('requests.edit', $id)->with(['flush.message' => 'リクエストを更新しました', 'flush.alert_type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ModelsRequest::findOrFail($id)->delete();
        return redirect()->route('mypage.requests.posted');
    }

    public function resolve($id)
    {
        $request_instance = ModelsRequest::findOrFail($id);
        $request_instance->completed_at = now();
        $request_instance->save();

        return redirect()->route('mypage.requests.posted');
    }
    public function like($id)
    {
        RequestLike::where('request_id', $id)->where('user_id', Auth::id())->delete();
        $request_like_instance = new RequestLike();
        $request_like_instance->request_id = $id;
        $request_like_instance->user_id = Auth::id();
        $request_like_instance->save();
        return response()->json(['message' => 'liked', 'request' => RequestLike::where('request_id', $id)->where('user_id', Auth::id())->get()]);
    }
    public function unlike($id)
    {
        RequestLike::where('request_id', $id)->where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'unliked', 'request' => RequestLike::where('request_id', $id)->where('user_id', Auth::id())->get()]);
    }
}
