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
            $set = Set::query()->find(1);
            if ($model->type == 1) {
                $emission = $model->mileage * $set->new_e;
            } elseif ($model->type == 2) {
                $emission = $model->mileage * $set->car_e;
            }

            if (!Bubble::create($model->user_id, $emission, 13, 1)) {
                Log::info("插入错误");
            }
        });
    }
}
