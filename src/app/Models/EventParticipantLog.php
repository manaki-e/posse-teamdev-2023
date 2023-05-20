<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
