<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Base
{
    use HasFactory;

    public function setCoverAttribute($cover)
    {
        if (is_array($cover)) {
            $this->attributes['cover'] = json_encode($cover);
        }
    }

    public function getCoverAttribute($cover)
    {
        return json_decode($cover, true);
    }
}
