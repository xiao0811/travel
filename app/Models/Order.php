<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Base
{
    use HasFactory;

    protected $fillable = [
        "address",
        "name",
        "phone",
        "remark",
        "express",
        "express_number"
    ];

    public function goods()
    {
        return $this->belongsTo('App\Models\Goods');
    }
}
