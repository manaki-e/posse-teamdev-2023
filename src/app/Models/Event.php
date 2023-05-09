<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use softDeletes;
    protected $dates = ['created_at', 'updated_at', 'date', 'deleted_at', 'completed_at'];
    public static function getEventIds()
    {
        return self::pluck('id')->toArray();
    }
    public function allParticipants()
    {
        return $this->hasMany(EventParticipantLog::class);
    }
    public function participants()
    {
        return $this->hasMany(EventParticipantLog::class)->whereNull('deleted_at');
    }
    public function eventTags()
    {
        return $this->hasMany(EventTag::class);
    }
    public function scopeCompletedEvents($query)
    {
        return $query->whereNotNull('completed_at');
    }
}
