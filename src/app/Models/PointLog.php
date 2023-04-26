<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointLog extends Model
{
    use HasFactory;
    const EARNED_POINT_TYPE='換金可能';
    const DISTRIBUTION_POINT_TYPE='配布';

}
