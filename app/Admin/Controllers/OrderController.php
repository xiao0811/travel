<?php

namespace App\Admin\Controllers;

use App\Models\Goods;
use App\Models\Order;
use App\Models\User;
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
        $grid->column('member_id', __('用户ID'))->display(function ($member_id) {
            return User::find($member_id)->name;
        });
        $grid->column('goods_id', __('商品名称'))->display(function ($goods_id) {
            return Goods::find($goods_id)->name;
        });
        $grid->column('number', __('商品数量'));
        $grid->column('address', __('收货人地址'));
        $grid->column('name', __('收货人名字'));
        $grid->column('phone', __('收货人手机号码'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $data = "";
            switch ($status) {
                case "1":
                    $data = "下单未付款";
                    break;
                case "2":
                    $data = "付款未发货";
                    break;
                case "3":
                    $data = "发货未签收";
                    break;
                case "4":
                    $data = "已完成";
                    break;
                case "10":
                    $data = "取消";
                    break;
                default:
                    $data = "未知状态";
            }

            return $data;
        });
        $grid->column('express', __('快递公司'));
        $grid->column('express_number', __('快递单号'));
        $grid->column('remark', __('备注'));
        $grid->column('created_at', __('下单时间'));

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
        $form->text('phone', __('收货人手机号码'));
        $form->select('status', __('状态'))->options([
            "1" => "下单未付款",
            "2" => "付款未发货",
            "3" => "发货未签收",
            "4" => "已完成",
            "10" => "取消",
        ]);
        $form->text('express', __('快递公司'));
        $form->text('express_number', __('快递单号'));
        $form->text('remark', __('备注'));

        return $form;
    }
}
