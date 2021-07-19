<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->column('id', __('Id'));
        $grid->column('order_number', __('Order number'));
        $grid->column('member_id', __('Member id'));
        $grid->column('goods_id', __('Goods id'));
        $grid->column('number', __('Number'));
        $grid->column('address', __('Address'));
        $grid->column('name', __('Name'));
        $grid->column('phone', __('Phone'));
        $grid->column('status', __('Status'));
        $grid->column('express', __('Express'));
        $grid->column('express_number', __('Express number'));
        $grid->column('remark', __('Remark'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('order_number', __('Order number'));
        $show->field('member_id', __('Member id'));
        $show->field('goods_id', __('Goods id'));
        $show->field('number', __('Number'));
        $show->field('address', __('Address'));
        $show->field('name', __('Name'));
        $show->field('phone', __('Phone'));
        $show->field('status', __('Status'));
        $show->field('express', __('Express'));
        $show->field('express_number', __('Express number'));
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
        $form = new Form(new Order());

        $form->text('order_number', __('Order number'));
        $form->number('member_id', __('Member id'));
        $form->number('goods_id', __('Goods id'));
        $form->number('number', __('Number'))->default(1);
        $form->text('address', __('Address'));
        $form->text('name', __('Name'));
        $form->mobile('phone', __('Phone'));
        $form->switch('status', __('Status'))->default(1);
        $form->text('express', __('Express'));
        $form->text('express_number', __('Express number'));
        $form->text('remark', __('Remark'));

        return $form;
    }
}
