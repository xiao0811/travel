<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Base
{
    use HasFactory;

    public function setThumbnailAttribute($thumbnail)
    {
        if (is_array($thumbnail)) {
            $this->attributes['thumbnail'] = json_encode($thumbnail);
        }
    }

    public function getThumbnailAttribute($thumbnail)
    {
        return json_decode($thumbnail, true);
    }
}
