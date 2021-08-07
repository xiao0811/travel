<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NewEnergy extends Base
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "car_number",
        "start_mileage",
        "end_mileage",
        "mileage",
        "type",
        "status",
        "remark"
    ];

    public static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            if ($model->type == 1) {
                $emission = $model->mileage;
                Bubble::create(Auth::id(), $emission, 13, 1);
            } elseif ($model->type == 2) {
                $emission = $model->mileage;
                Bubble::create(Auth::id(), $emission, 13, 1);
            }
        });
    }
}
