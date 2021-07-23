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
        $grid->column('order_number', __('订单编号'));
        $grid->column('member_id', __('用户ID'));
        $grid->column('goods_id', __('商品ID'));
        $grid->column('number', __('商品数量'));
        $grid->column('address', __('收货人地址'));
        $grid->column('name', __('收货人名字'));
        $grid->column('phone', __('收货人手机号码'));
        $grid->column('status', __('状态'));
        $grid->column('express', __('快递公司'));
        $grid->column('express_number', __('快递单号'));
        $grid->column('remark', __('备注'));
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
        $show->field('order_number', __('订单编号'));
        $show->field('member_id', __('用户ID'));
        $show->field('goods_id', __('商品ID'));
        $show->field('number', __('商品数量'));
        $show->field('address', __('收货人地址'));
        $show->field('name', __('收货人名字'));
        $show->field('phone', __('收货人手机号码'));
        $show->field('status', __('状态'));
        $show->field('express', __('快递公司'));
        $show->field('express_number', __('快递单号'));
        $show->field('remark', __('备注'));
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

        $form->text('order_number', __('订单编号'));
        $form->number('member_id', __('用户ID'));
        $form->number('goods_id', __('商品ID'));
        $form->number('number', __('商品数量'))->default(1);
        $form->text('address', __('收货人地址'));
        $form->text('name', __('收货人名字'));
        $form->mobile('phone', __('收货人手机号码'));
        $form->switch('status', __('状态'))->default(1);
        $form->text('express', __('快递公司'));
        $form->text('express_number', __('快递单号'));
        $form->text('remark', __('备注'));

        return $form;
    }
}
