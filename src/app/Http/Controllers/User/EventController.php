<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\EventTag;
use App\Models\Request as ModelsRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $events = Event::withCount('eventLikes')->withCount(['eventParticipants'=>function($query){
            $query->where('canceled_at',null);
        }])->with(['user', 'eventTags.tag', 'eventLikes.user'])->with(['eventParticipants'=>function($query){
            $query->where('canceled_at',null)->with('user');
        }])->get()->map(function ($event) use ($user_id) {
            $event->isLiked = $event->eventLikes->contains('user_id', $user_id);
            $event->isParticipated = $event->eventParticipants->contains('user_id', $user_id);
            if(empty($event->date)){
                $event->show_date='未定';
            }else{
                $event->show_date=$event->date->format('Y.m.d');
            }
            $event->data_tag = '[' . implode(',', $event->eventTags->pluck('tag_id')->toArray()) . ']';
            $event->description=$event->changeDescriptionReturnToBreakTag($event->description);
            return $event;
        });
        $tags = Tag::eventTags()->get();
        return view('user.events.index', compact('events', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //未完了のリクエストを取得
        $requests = ModelsRequest::unresolvedRequests()->eventRequests()->get();
        //イベントタグ一覧を取得
        $tags = Tag::eventTags()->get();
        return view('backend_test.add_event', compact('requests', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //events追加
        $event = new Event();
        $event->user_id = Auth::id();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->location = $request->location;
        $event->request_id = $request->request_id;
        //ここにslackchannel自動生成の処理を書く。今は仮置き
        $event->slack_channel = 'test';
        $event->save();
        //event_tags追加
        foreach ($request->tags as $tag_id) {
            $event_tag = new EventTag();
            $event_tag->event_id = $event->id;
            $event_tag->tag_id = $tag_id;
            $event_tag->save();
        }
        //作ったイベント詳細にとぶor redirect back
        // return redirect()->back();
        return redirect()->route('events.show', $event->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $event = Event::withCount(['eventParticipants', 'eventLikes'])->with(['user', 'eventParticipants.user', 'eventTags.tag', 'eventLikes.user'])->findOrFail($id);
        $event->isLiked = $event->eventLikes->contains('user_id', Auth::id());
        $login_user_event_participant_instance = $event->eventParticipants->where('user_id', Auth::id())->where('canceled_at', null)->first();
        //nullの場合はキャンセル済みまたはそもそも参加予約したことない
        if (empty($login_user_event_participant_instance)) {
            $event->isParticipated = false;
        } else {
            $event->isParticipated = true;
        }
        return view('backend_test.event', compact('event', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        //checkbox用にすべてのevent_tagsを取得
        $event_tags = Tag::EventTags()->get()->map(function ($event_tag) {
            $event_tag->is_selected = false;
            return $event_tag;
        });
        //所持するevent_tagsのis_selectedをtrueにする
        $chosen_event_tags = EventTag::where('event_id', $id)->get()->map(function ($chosen_event_tag) use ($event_tags) {
            $event_tags->find($chosen_event_tag->tag_id)->is_chosen = true;
            return $chosen_event_tag;
        });
        return view('backend_test.edit_event', compact('event', 'event_tags'));
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
        $user = Auth::user();
        $event = Event::with('eventTags.tag')->findOrFail($id);
        //ログインユーザーのイベントか確認
        if ($user->id !== $event->user_id) {
            return redirect()->back()->withErrors(['not_event_organizer' => 'あなたは主催者ではないです']);
        }
        //イベント更新
        $event->title = $request->title;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->location = $request->location;
        $event->save();
        //event_tags更新
        //まずはevent_tagsをすべて削除
        EventTag::where('event_id', $id)->delete();
        //event_tags追加
        foreach ($request->tags as $tag_id) {
            $event_tag = new EventTag();
            $event_tag->event_id = $id;
            $event_tag->tag_id = $tag_id;
            $event_tag->save();
        }
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
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('events.index');
    }
    public function held($event)
    {
        //completed_at入力
        $event_instance = Event::findOrFail($event);
        $event_instance->completed_at = Carbon::now();
        $event_instance->save();
        //参加者のポイント集める=>メソッドuserモデルに書いてあるから後で修正
        $event_points = EventParticipantLog::where('event_id', $event)->sum('point');
        // var_dump($event_instance->user->earned_point);
        $event_instance->user->earned_point += $event_points;
        $event_instance->user->save();
        // var_dump($event_instance->user->earned_point);
        //リダイレクト先は未確定
        return redirect()->route('events.show', $event);
    }
    public function cancel($event)
    {
        // canceled_atを入力
        $event_participant_log = EventParticipantLog::where('event_id', $event)->where('user_id', Auth::id())->where('canceled_at', null)->first();
        $event_participant_log->canceled_at = now();
        $event_participant_log->save();
        // 処理後redirect back
        return redirect()->back();
    }
    public function participate(Request $request, $event)
    {
        $user = Auth::user();
        //ポイント入力チェック
        $request->validate([
            'point' => 'required',
        ]);
        //ポイント足りるかチェック
        if ($user->distribution_point < $request->point) {
            return redirect()->back()->withErrors(['not_enough_point' => 'ポイントが足りません']);
        }
        // 提示したポイント差し引かれる
        $user->distribution_point -= $request->point;
        $user->save();
        //専用slackチャンネルに招待される＝＞slackの実装できたらやる
        // event_participantsにレコード追加
        $event_participant_log = new EventParticipantLog();
        $event_participant_log->event_id = $event;
        $event_participant_log->user_id = $user->id;
        $event_participant_log->point = $request->point;
        $event_participant_log->save();
        // 処理後redirect back
        return redirect()->back();
    }
    public function createWithRequest($chosen_request_id)
    {
        //未完了のリクエストを取得
        $requests = ModelsRequest::unresolvedRequests()->eventRequests()->get();
        //イベントタグ一覧を取得
        $tags = Tag::eventTags()->get();
        return view('user.events.create', compact('requests', 'tags', 'chosen_request_id'));
    }
}
