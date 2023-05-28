<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Department extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name'];

    public static function getDepartmentIds()
    {
        return self::pluck('id')->toArray();
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
