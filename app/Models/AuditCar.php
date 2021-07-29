<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditCar extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "user_id",
        "car_number",
        "car_pic",
        "status",
        "remark",
        "type"
    ];
}
