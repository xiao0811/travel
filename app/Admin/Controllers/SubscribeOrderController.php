<?php

namespace App\Admin\Controllers;

use App\Models\Subscribe;
use App\Models\SubscribeOrder;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SubscribeOrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'SubscribeOrder';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SubscribeOrder());

        $grid->column('subscribe_id', __('商品'))->display(function ($userId) {
            return Subscribe::find($userId)->name;
        });
        $grid->column('quantity', __('数量'));
        $grid->column('amount', __('总金额'));
        $grid->column('name', __('个人/团体名字'));
        $grid->column('type', __('个人/团体'))->display(function ($type) {
            $data = "";
            switch ($type) {
                case "1":
                    $data = "个人";
                    break;
                case "2":
                    $data = "团体";
                    break;

                default:
                    $data = "未知状态";
            }

            return $data;
        });
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
        $grid->column('certificate', __('证书编号'));
        $grid->column('remark', __('备注'));

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
        $show = new Show(SubscribeOrder::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('用户ID'))->display(function ($userId) {
            return User::find($userId)->name;
        });
        $show->field('subscribe_id', __('商品ID'));
        $show->field('quantity', __('数量'));
        $show->field('amount', __('总金额'));
        $show->field('name', __('个人/团体名字'));
        $show->field('type', __('类型'));
        $show->field('certificate', __('证书'));
        $show->field('remark', __('Remark'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new SubscribeOrder());

        // $form->number('user_id', __('User id'));
        // $form->number('subscribe_id', __('Subscribe id'));
        // $form->number('quantity', __('Quantity'));
        // $form->decimal('amount', __('Amount'));
        // $form->text('name', __('Name'));
        // $form->switch('type', __('Type'));
        // $form->text('certificate', __('Certificate'));
        // $form->text('remark', __('Remark'));

        return $form;
    }
}
