<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SlackController;
use App\Models\Event;
use App\Models\EventLike;
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
     * @var SlackController
     */
    public function __construct(SlackController $slackController)
    {
        $this->slackController = $slackController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $events = Event::withCount('eventLikes')->withCount(['eventParticipants' => function ($query) {
            $query->where('cancelled_at', null);
        }])->with(['user', 'eventTags.tag', 'eventLikes.user'])->with(['eventParticipants' => function ($query) {
            $query->where('cancelled_at', null)->with('user');
        }])->get()->map(function ($event) use ($user_id) {
            $event->isLiked = $event->eventLikes->contains('user_id', $user_id);
            $event->isParticipated = $event->eventParticipants->contains('user_id', $user_id);
            if (empty($event->completed_at)) {
                $event->isCompleted = Event::COMPLETED_STATUSES[0];
            } else {
                $event->isCompleted = Event::COMPLETED_STATUSES[1];
            }
            $event->data_tag = '[' . implode(',', $event->eventTags->pluck('tag_id')->toArray()) . ']';
            $event->description = $event->changeDescriptionReturnToBreakTag($event->description);
            if ($event->eventLikes->contains('user_id', Auth::id())) {
                $event->isLiked = 1;
            } else {
                $event->isLiked = 0;
            }
            return $event;
        })->sortByDesc('created_at');
        $tags = Tag::eventTags()->get();
        $completed_statuses = Event::COMPLETED_STATUSES;
        return view('user.events.index', compact('events', 'tags', 'completed_statuses'));
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
        $locations = Event::LOCATIONS;
        return view('user.events.create', compact('requests', 'tags', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // slackチャンネル作成
        $event_id = Event::max('id') + 1;
        $slackId = $this->slackController->createChannel($event_id, $request->title, false);

        //events追加
        $event = new Event();
        $event->user_id = Auth::id();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->location = $request->location;
        $event->request_id = $request->request_id;
        $event->slack_channel = $slackId;
        $event->save();
        //event_tags追加
        if (!empty($request->tags)) {
            foreach ($request->tags as $tag_id) {
                $event_tag = new EventTag();
                $event_tag->event_id = $event->id;
                $event_tag->tag_id = $tag_id;
                $event_tag->save();
            }
        }
        //作ったイベント詳細にとぶor redirect back
        return redirect()->route('events.index')->with(['flush.message' => 'イベント登録完了しました。', 'flush.alert_type' => 'success']);
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
        $login_user_event_participant_instance = $event->eventParticipants->where('user_id', Auth::id())->where('cancelled_at', null)->first();
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
        $tags = Tag::EventTags()->get()->map(function ($tag) {
            $tag->is_selected = false;
            return $tag;
        });
        //所持するevent_tagsのis_selectedをtrueにする
        EventTag::where('event_id', $id)->get()->map(function ($selected_event_tag) use ($tags) {
            $tags->find($selected_event_tag->tag_id)->is_selected = true;
        });
        $requests = ModelsRequest::unresolvedRequests()->eventRequests()->get();
        $locations = Event::LOCATIONS;
        return view('user.events.edit', compact('event', 'tags', 'requests', 'locations'));
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
            return redirect()->back()->with(['flush.message' => 'あなたは主催者ではありません', 'flush.alert_type' => 'error']);
        }
        //イベント更新
        $event->title = $request->title;
        $event->description = $request->description;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
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
        return redirect()->route('mypage.events.organized')->with(['flush.message' => 'イベント更新を完了しました。', 'flush.alert_type' => 'success']);
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
        return redirect()->route('mypage.events.organized');
    }
    public function cancel($event)
    {
        $user = Auth::user();
        $event_data = Event::findOrFail($event);

        if ($user->id === $event_data->user_id) {
            $event_data->cancelled_at = now();
            $event_data->save();

            return redirect()->route('mypage.events.organized');
        } else {
            $event_participant_log = EventParticipantLog::where('event_id', $event)->where('user_id', $user->id)->where('cancelled_at', null)->first();
            $event_participant_log->cancelled_at = now();
            $event_participant_log->save();

            return redirect()->route('mypage.events.joined');
        }
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

        $channel_id = Event::findOrFail($event)->slack_channel;
        $user_slack_id = $user->slackID;
        $this->slackController->inviteUsersToChannel($channel_id, $user_slack_id);

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
    public function like($id)
    {
        EventLike::where('event_id', $id)->where('user_id', Auth::id())->delete();
        $event_like_instance = new EventLike();
        $event_like_instance->event_id = $id;
        $event_like_instance->user_id = Auth::id();
        $event_like_instance->save();
        return response()->json(['message' => 'liked', 'event' => EventLike::where('event_id', $id)->where('user_id', Auth::id())->get()]);
    }
    public function unlike($id)
    {
        EventLike::where('event_id', $id)->where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'unliked', 'event' => EventLike::where('event_id', $id)->where('user_id', Auth::id())->get()]);
    }
}
