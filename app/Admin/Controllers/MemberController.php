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
        $grid->column('password', __('Password'));
        $grid->column('remember_token', __('Remember token'));
        $grid->column('username', __('Username'));
        $grid->column('wechat', __('Wechat'));
        $grid->column('real_name', __('Real name'));
        $grid->column('integral', __('Integral'));
        $grid->column('id_card', __('Id card'));
        $grid->column('phone', __('Phone'));
        $grid->column('avatar', __('Avatar'));
        $grid->column('status', __('Status'));
        $grid->column('type', __('Type'));
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('email', __('Email'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
        $show->field('username', __('Username'));
        $show->field('wechat', __('Wechat'));
        $show->field('real_name', __('Real name'));
        $show->field('integral', __('Integral'));
        $show->field('id_card', __('Id card'));
        $show->field('phone', __('Phone'));
        $show->field('avatar', __('Avatar'));
        $show->field('status', __('Status'));
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
        $form = new Form(new User());

        $form->email('email', __('Email'));
        $form->password('password', __('Password'));
        $form->text('remember_token', __('Remember token'));
        $form->text('username', __('Username'));
        $form->text('wechat', __('Wechat'));
        $form->text('real_name', __('Real name'));
        $form->text('integral', __('Integral'));
        $form->text('id_card', __('Id card'));
        $form->mobile('phone', __('Phone'));
        $form->image('avatar', __('Avatar'));
        $form->switch('status', __('Status'))->default(1);
        $form->switch('type', __('Type'))->default(1);

        return $form;
    }
}
