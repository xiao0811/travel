<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goods extends Base
{
    use HasFactory;

    protected $fillable = [
        "name",
        "number",
        "price",
        "integral",
        "quantity",
        "images",
        "details",
        "type",
        "status",
        "recommend",
        "sold",
    ];


    public function setImagesAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['images'] = json_encode($images);
        }
    }

    public function getImagesAttribute($images)
    {
        return json_decode($images, true);
    }
}
