<?php

namespace App\Admin\Controllers;

use App\Models\Redemption;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DuihuanController extends AdminController
{
    protected $title = '兑换码';

    public function piliang(Content $content)
    {
        // return view("admin.piliang");
        return $content
            ->header('批量生成兑换码')
            // ->description('description')
            ->body(view("admin.piliang", [
                'name' => '初始化数据'
            ])->render());
    }

    
    public function save(Request $request)
    {
        for ($i = 0; $i < $request->post("number"); $i++) {
            $code = new Redemption();
            $code->code = Str::random(8);
            $code->integral = $request->post("integral");
            $code->status = 1;
            $code->valid_period = $request->post("valid_period");
            $code->save();
        }

        return redirect(asset("/admin/redemptions"));
    }
}