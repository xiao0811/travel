<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\ShowArtwork;
use App\Models\Redemption;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RedemptionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '兑换码';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Redemption());

        $grid->column('id', __('Id'));
        $grid->column('code', __('Code'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $data = [
                1 => "正常",
                2 => "已使用",
                3 => "取消",
            ];
            return $data[$status];
        });
        $grid->column('valid_period', __('有效期'));
        // $grid->column('type', __('类型'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

        $grid->tools(function ($tools) {
            // $url = "/admin/artimage";
            // $icon = "fa-backward";
            // $text = "Back";
            // $tools->append(new ShowArtwork($url, $icon, $text));

            $url = "/admin/redemption/create";
            $icon = "fa-eye";
            $text = "批量生成";
            $tools->append(new ShowArtwork($url, $icon, $text));
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Redemption::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('code', __('Code'));
        $show->field('status', __('Status'));
        $show->field('valid_period', __('Valid period'));
        $show->field('type', __('Type'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Redemption());

        $form->text('code', __('Code'));
        $form->select('status', __('Status'))->options([
            1 => "正常",
            2 => "已使用",
            3 => "取消",
        ]);
        $form->date('valid_period', __('Valid period'))->default(date('Y-m-d'));
        // $form->select('type', __('类型'));

        return $form;
    }
}
