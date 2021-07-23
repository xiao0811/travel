<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MemberController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('email', __('Email'));
        // $grid->column('password', __('Password'));
        // $grid->column('remember_token', __('Remember token'));
        $grid->column('username', __('用户名'));
        // $grid->column('wechat', __('Wechat'));
        $grid->column('real_name', __('真实姓名'));
        $grid->column('integral', __('积分'));
        $grid->column('id_card', __('Id card'));
        $grid->column('phone', __('手机号码'));
        $grid->column('avatar', __('头像'));
        $grid->column('status', __('状态'));
        // $grid->column('type', __('Type'));
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        // $show->field('email', __('Email'));
        // $show->field('password', __('Password'));
        // $show->field('remember_token', __('Remember token'));
        $show->field('username', __('用户名'));
        // $show->field('wechat', __('Wechat'));
        $show->field('real_name', __('真实姓名'));
        $show->field('integral', __('积分'));
        $show->field('id_card', __('Id card'));
        $show->field('phone', __('手机号码'));
        $show->field('avatar', __('头像'));
        $show->field('status', __('状态'));
        // $show->field('type', __('Type'));
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
        $form = new Form(new User());

        // $form->email('email', __('Email'));
        // $form->password('password', __('Password'));
        // $form->text('remember_token', __('Remember token'));
        $form->text('username', __('用户名'));
        // $form->text('wechat', __('Wechat'));
        $form->text('real_name', __('真实姓名'));
        $form->text('integral', __('积分'));
        $form->text('id_card', __('Id card'));
        $form->mobile('phone', __('手机号码'));
        $form->image('avatar', __('头像'));
        $form->switch('status', __('状态'))->default(1);
        // $form->switch('type', __('Type'))->default(1);

        return $form;
    }
}
