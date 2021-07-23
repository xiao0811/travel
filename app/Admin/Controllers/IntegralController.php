<?php

namespace App\Admin\Controllers;

use App\Models\Integral;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class IntegralController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Integral';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Integral());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('用户ID'));
        $grid->column('type', __('类型'));
        $grid->column('quantity', __('数量'));
        $grid->column('order_id', __('相关订单'));
        $grid->column('interactor', __('收入/支出对象'));
        $grid->column('status', __('状态'));
        // $grid->column('created_at', __('Created at'));
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
        $show = new Show(Integral::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('用户ID'));
        $show->field('type', __('类型'));
        $show->field('quantity', __('数量'));
        $show->field('order_id', __('相关订单'));
        $show->field('interactor', __('收入/支出对象'));
        $show->field('status', __('状态'));
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
        $form = new Form(new Integral());

        $form->number('user_id', __('用户ID'));
        $form->switch('type', __('类型'))->default(1);
        $form->number('quantity', __('数量'));
        $form->number('order_id', __('相关订单'));
        $form->number('interactor', __('收入/支出对象'));
        $form->switch('status', __('状态'))->default(1);

        return $form;
    }
}
