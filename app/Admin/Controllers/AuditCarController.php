<?php

namespace App\Admin\Controllers;

use App\Models\AuditCar;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AuditCarController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AuditCar';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AuditCar());

        $grid->column('user_id', __('用户'));
        // $grid->column('user_id', __('用户'))->display(function ($userId) {
        //     return User::find($userId)->username;
        // });
        $grid->column('car_number', __('车牌号码'));
        $grid->column('car_pic', __('车辆照片'));
        $grid->column('type', __('车辆类型'));
        $grid->column('status', __('状态'));
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
        $show = new Show(AuditCar::findOrFail($id));

        $show->field('id', __('Id'))->display(function ($userId) {
            return User::find($userId)->username;
        });
        $show->field('user_id', __('User id'));
        $show->field('car_number', __('Car number'));
        $show->field('car_pic', __('Car pic'));
        $show->field('type', __('Type'));
        $show->field('status', __('Status'));
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
        $form = new Form(new AuditCar());

        $form->number('user_id', __('用户ID'));
        $form->text('car_number', __('车牌号'));
        $form->image('car_pic', __('Car pic'));
        $form->select('type', __('类型'))->options([
            1 => "电动车",
            2 => "燃油车",
        ]);;
        $form->select('status', __('状态'))->options([
            1 => "审核中",
            10 => "审核拒绝",
            20 => "审核撤销",
            30 => "审核通过"
        ]);
        $form->text('remark', __('Remark'));

        return $form;
    }
}
