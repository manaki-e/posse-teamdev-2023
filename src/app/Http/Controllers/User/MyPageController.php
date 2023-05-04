<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\Event_participants;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//#82-主催したイベント情報
class MyPageController extends Controller
{
    // イベントID
    public function eventsOrganized()
    {
        // Authのid
        $auth_id = Auth::id();
        //Authのidに紐づいているテーブルを全部取得
        $event_organizes = Event::with('participants')->where('user_id', '=', $auth_id)->with('event')->get();
        foreach ($event_organizes as $event_organize) {
            print_r($event_organize->title . '<br>');
            print_r($event_organize->created_at . '<br>');
            print_r($event_organize->completed_at . '<br>');
        }
        $earned_points = Event::where('user_id', $auth_id)->with('participants')->withSum('participants', 'point')->get();
        foreach ($earned_points as $earned_point) {
            print_r($earned_point->participants_sum_point);
        }
        dd();
        // return view();
    }

    #81-参加したイベント情報
    public function eventsJoined()
    {
        $auth_id = Auth::id();
        $event_joins = EventParticipantLog::where('user_id', $auth_id)->get();
        foreach ($event_joins as $event_join) {
            print_r($event_join->event->title . '<br>');
            print_r($event_join->point . '<br>');
            print_r($event_join->user->name . '<br>');
        }
    }
}
