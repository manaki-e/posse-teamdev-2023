<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointExchange extends Model
{
    use HasFactory;
    const MULTIPLE_OF = 500;
    const STATUS=[
        'PENDING'=>1,
        'APPROVED'=>2,
        'REJECTED'=>3
    ];
}