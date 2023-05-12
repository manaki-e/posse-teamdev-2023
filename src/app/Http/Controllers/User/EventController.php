<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipantLog;
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
        $events = Event::withCount(['eventParticipants', 'eventLikes'])->with(['user', 'eventParticipants.user', 'eventTags.tag', 'eventLikes.user'])->get()->map(function ($event) use ($user_id) {
            $event->isLiked = $event->eventLikes->contains('user_id', $user_id);
            $event->isParticipated = $event->eventParticipants->contains('user_id', $user_id);
            return $event;
        });
        $tags = Tag::eventTags()->get();
        return view('backend_test.events', compact('events', 'tags'));
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
        $user = Auth::user();
        $event = Event::withCount(['eventParticipants', 'eventLikes'])->with(['user', 'eventParticipants.user', 'eventTags.tag', 'eventLikes.user'])->findOrFail($id);
        $event->isLiked = $event->eventLikes->contains('user_id', Auth::id());
        $event->isParticipated = $event->eventParticipants->contains('user_id', Auth::id());
        return view('backend_test.event', compact('event', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($event)
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
    public function update(Request $request, $event)
    {
        $form_data=$request->all();
        foreach($form_data as $key=>$value){
            dd($key);
        }
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
        // ポイントは戻ってこない
        // event_participantsから削除
        $event_participant_log = EventParticipantLog::where('event_id', $event)->where('user_id', Auth::id())->first();
        $event_participant_log->delete();
        // 処理後redirect back
        return redirect()->back();
    }
    public function participate(Request $request, $event)
    {
        $user = Auth::user();
        //ポイント足りるかチェック
        if ($user->distribution_point < $request->point) {
            return redirect()->back()->withErrors(['not_enough_point' => 'ポイントが足りません']);
        }
        // 提示したポイント差し引かれる
        $user->distribution_point -= $request->point;
        $user->save();
        // event_participantsにレコード追加
        $event_participant_log = new EventParticipantLog();
        $event_participant_log->event_id = $event;
        $event_participant_log->user_id = $user->id;
        $event_participant_log->point = $request->point;
        $event_participant_log->save();
        // 処理後redirect back
        return redirect()->back();
    }
}