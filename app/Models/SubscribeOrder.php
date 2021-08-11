<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscribeOrder extends Base
{
    use HasFactory;

    public function subscribe()
    {
        return $this->belongsTo('App\Models\Subscribe');
    }
}
