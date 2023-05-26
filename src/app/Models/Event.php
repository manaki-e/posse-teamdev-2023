<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\EventParticipantLog;
use App\Models\EventTag;
use App\Models\EventLike;
use App\Models\User;

class Event extends Model
{
    use HasFactory, softDeletes;
    protected $dates = ['created_at', 'updated_at', 'date', 'deleted_at', 'completed_at'];
    const LOCATIONS = [
        '対面', 'オンライン', '対面・オンライン併用', '未定'
    ];
    public static function booted()
    {
        static::deleted(function ($event) {
            $event->eventParticipants()->delete();
            $event->eventTags()->delete();
            $event->eventLikes()->delete();
        });
    }
    public static function getEventIds()
    {
        return self::pluck('id')->toArray();
    }
    public function eventParticipants()
    {
        return $this->hasMany(EventParticipantLog::class);
    }
    public function eventTags()
    {
        return $this->hasMany(EventTag::class);
    }
    public function eventLikes()
    {
        return $this->hasMany(EventLike::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeCompletedEvents($query)
    {
        return $query->whereNotNull('completed_at');
    }
    public function changeDescriptionReturnToBreakTag($value)
    {
        return str_replace("\n", "<br>", e($value));
    }
}
