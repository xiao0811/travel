<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
