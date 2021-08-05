<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bubble extends Base
{
    use HasFactory;

    /*
    type 
    (1)碳积分有：1: 签到、2: 分享、3: 出行(合并步行和骑行)、4: 认购、5:教育(合并答题和线下活动兑换)
    (2）碳减排有：11: 步行减排、12:骑行减排、13: 车减排(合并新能源出行减排和燃油车停驶减排)、14:认购减排
    */
    static public function create($user, $quantity = 1, $type = 1, $classification = 1)
    {
        $bubble = new Bubble();
        $bubble->user_id = $user;
        $bubble->quantity = $quantity;
        $bubble->type = $type;
        $bubble->status = 1;
        $bubble->classification = $classification;

        return $bubble->save();
    }
}
