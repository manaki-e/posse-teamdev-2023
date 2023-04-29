<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public static function getEventIds(){
        return self::pluck('id')->toArray();
    }
    public function allParticipants(){
        return $this->hasMany(EventParticipantLog::class);
    }
    public function participants(){
        return $this->hasMany(EventParticipantLog::class)->whereNull('deleted_at');
    }
    public function scopeCompletedEvents(){
        return $this->whereNotNull('completed_at');
    }
}