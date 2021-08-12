<?php

namespace App\Admin\Controllers;

use App\Models\Region;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RegionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Region';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Region());

        // $grid->column('id', __('Id'));
        $grid->column('name', __('地区'));
        $grid->column('x_axis', __('X坐标'));
        $grid->column('y_axis', __('Y坐标'));
        // $grid->column('content', __('Content'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $data = "";
            switch ($status) {
                case "1":
                    $data = "正常";
                    break;
                case "2":
                    $data = "未启用";
                    break;
            }

            return $data;
        });
        // $grid->column('type', __('Type'));
        $grid->column('remark', __('备注'));
        $grid->column('created_at', __('创建时间'));
        // $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Region::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('content', __('Content'));
        $show->field('status', __('Status'));
        $show->field('type', __('Type'));
        $show->field('remark', __('Remark'));
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
        $form = new Form(new Region());

        $form->text('name', __('地区'));
        $form->editor('content', __('Content'));
        $form->text('x_axis', __('X坐标'));
        $form->text('y_axis', __('Y坐标'));
        $form->radio('status', __('Status'))->options([
            "1" => "正常",
            "2" => "未启用"
        ]);
        // $form->switch('type', __('Type'));
        $form->text('remark', __('备注'));

        return $form;
    }
}
