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
        $this->slackGlobalAnnouncementChannelId = $slackController->searchChannelId('peerperk全体お知らせ', false);
        $this->slackAdminChannelId = $slackController->searchChannelId('peerperk管理者', true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $events = Event::withCount('eventLikes')->withCount(['eventParticipantLogs' => function ($query) {
            $query->where('cancelled_at', null);
        }])->with(['user', 'eventTags.tag', 'eventLikes.user'])->with(['eventParticipantLogs' => function ($query) {
            $query->where('cancelled_at', null)->with('user');
        }])->get()->map(function ($event) use ($user_id) {
            $event->isLiked = $event->eventLikes->contains('user_id', $user_id);
            $event->isParticipated = $event->eventParticipantLogs->contains('user_id', $user_id);
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
        $event_id = Event::withTrashed()->max('id') + 1;
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
        //slackイベント
        $this->slackController->sendNotification($slackId, "このチャンネルは参加者と連絡を取るためのものです。他のユーザが参加申し込みをすると、このチャンネルに招待されます！");
        //slack全体
        $this->slackController->sendNotification($this->slackGlobalAnnouncementChannelId, "<@" . Auth::user()->slackID . "> より、新たなイベントが追加されました！\n```" . env('APP_URL') . "events```");
        //リクエストに紐づいていたら、リクエストの投稿者にslack通知
        if (!empty($request->request_id)) {
            $request = ModelsRequest::find($request->request_id);
            $this->slackController->sendNotification($request->user->slackID, "<@" . Auth::user()->slackID . "> より、あなたのリクエストに対して、イベントが登録されました！確認してみましょう。\n```" . env('APP_URL') . "events```");
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
        if (!empty($request->tags)) {
            foreach ($request->tags as $tag_id) {
                $event_tag = new EventTag();
                $event_tag->event_id = $id;
                $event_tag->tag_id = $tag_id;
                $event_tag->save();
            }
        }
        //slackイベント
        $this->slackController->sendNotification($event->slack_channel, "<!channel>イベントの登録内容が更新されました！確認しましょう。\n```" . env('APP_URL') . "events```");
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
        $event_instance->user->earned_point += $event_points;
        $event_instance->user->save();
        //slackイベント
        $this->slackController->sendNotification($event_instance->slack_channel, "<!channel>イベントの開催を完了しました！次は、他のイベントにも積極的に参加したり、イベントを開催したりしてみましょう。");
        //slack全体
        $this->slackController->sendNotification($this->slackGlobalAnnouncementChannelId, "イベントの開催が完了しました！<@" . $event_instance->user->slackID . ">はこのチャンネルで感想を一言お願いします！");
        return redirect()->route('mypage.events.organized');
    }
    public function cancel($event)
    {
        $user = Auth::user();
        $event_data = Event::findOrFail($event);

        if ($user->id === $event_data->user_id) {
            $event_data->cancelled_at = now();
            $event_data->save();

            //slackイベント
            $this->slackController->sendNotification($event_data->slack_channel, "<!channel>主催者により、イベントの開催が中止されました。");
            return redirect()->route('mypage.events.organized')->with(['flush.message' => 'イベントの開催を中止しました。', 'flush.alert_type' => 'success']);
        } else {
            $event_participant_log = EventParticipantLog::where('event_id', $event)->where('user_id', $user->id)->where('cancelled_at', null)->first();
            $event_participant_log->cancelled_at = now();
            $event_participant_log->save();
            //slackイベント
            $this->slackController->sendNotification($event_data->slack_channel, "<@" . $user->slackID . ">さんがイベントへの参加をキャンセルしました。");
            $this->slackController->removeUserFromChannel($event_data->slack_channel, $user->slackID);
            return redirect()->route('mypage.events.joined')->with(['flush.message' => 'イベントへの参加をキャンセルしました。', 'flush.alert_type' => 'success']);
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
            return redirect()->back()->with(['flush.message' => 'Peer Pointが足りません。', 'flush.alert_type' => 'error']);
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
        //slackイベント
        $this->slackController->sendNotification($channel_id, "<!channel><@" . $user_slack_id . ">がこのイベントへの参加を申し込みました！チャンネル内でイベントについての詳細を決めましょう。もし詳細が決定している場合は、教えてあげましょう！");
        // 処理後redirect back
        return redirect()->back()->with(['flush.message' => 'イベントへの参加を申し込みました。', 'flush.alert_type' => 'success']);
    }
    public function createWithRequest($chosen_request_id)
    {
        $locations = Event::LOCATIONS;
        //未完了のリクエストを取得
        $requests = ModelsRequest::unresolvedRequests()->eventRequests()->get();
        //イベントタグ一覧を取得
        $tags = Tag::eventTags()->get();
        //リクエストのタグを取得して、チェック済みにする
        $request_tags = ModelsRequest::findOrFail($chosen_request_id)->requestTags->map(function ($request_tag) use ($tags) {
            $tags->find($request_tag->tag_id)->setAttribute('checked', true);
        });
        return view('user.events.create', compact('requests', 'tags', 'chosen_request_id', 'locations'));
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
