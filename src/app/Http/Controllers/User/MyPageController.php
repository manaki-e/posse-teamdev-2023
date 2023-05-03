<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\Event_participants;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyPageController extends Controller
{
    // イベントID
    public function eventsOrganized()
    {
        // Authのid
        $auth_id = Auth::id();
        //Authのidに紐づいているテーブルを全部取得
        $event_organizes = Event::with('participants')->where('user_id', '=', $auth_id)->get();
        foreach ($event_organizes as $event_organize) {
            print_r($event_organize->title);
            print_r($event_organize->created_at);
            print_r($event_organize->completed_at);
        }
        dd();
        // return view();
    }
}
