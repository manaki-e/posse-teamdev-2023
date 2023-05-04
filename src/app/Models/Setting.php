<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    public static function maximumEventParticipatePoint()
    {
        return self::first()->maximum_event_participate_point;
    }
    public static function monthlyDistributionPoint()
    {
        return self::first()->monthly_distribution_point;
    }
}