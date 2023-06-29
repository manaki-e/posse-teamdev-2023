<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Event;
use App\Models\User;

class EventParticipantLog extends Model
{
    use HasFactory, SoftDeletes;
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeCurrentMonth($query)
    {
        return $query->where('created_at', '>=', now()->startOfMonth());
    }
    //今月に参加登録した人=>今月の支払い対象者
    public function scopeCreatedThisMonth($query)
    {
        return $query->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
    }
    public static function getSumOfUsedPoints($user_id)
    {
        return self::where('user_id', $user_id)->sum('point');
    }
    public static function getUserEventParticipantLogsIncludingTrashedEvent($user_id)
    {
        return self::withTrashed()->where('user_id', $user_id)->with(['event' => function ($query) {
            $query->withTrashed();
        }])->get();
    }
    public function formatEventParticipantLogForMyPageDistributionPointHistory()
    {
        return [
            'app' => 'PE',
            'name' => $this->event->title,
            'created_at' => $this->created_at->format('Y.m.d H:i'),
            'point' => -$this->point,
        ];
    }
}
