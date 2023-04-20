<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointExchange extends Model
{
    use HasFactory;
    const MULTIPLE_OF = 500;
    public function createPointExchange($point, $user_id)
    {
        $this->create([
            'point' => $point,
            'user_id' => $user_id,
        ]);
    }
}