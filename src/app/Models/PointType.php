<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointType extends Model
{
    use HasFactory;
    protected $table = null;
    const EARNED_POINT_TYPE_ID = 1;
    const DISTRIBUTION_POINT_TYPE_ID = 2;
    public function getName($id)
    {
        switch ($id) {
            case self::EARNED_POINT_TYPE_ID:
                return '換金可能';
            case self::DISTRIBUTION_POINT_TYPE_ID:
                return '配布';
        }
    }
}