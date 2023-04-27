<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipantLog extends Model
{
    use HasFactory;
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
}
