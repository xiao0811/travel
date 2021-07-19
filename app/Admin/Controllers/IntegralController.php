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
        $grid->column('user_id', __('User id'));
        $grid->column('type', __('Type'));
        $grid->column('quantity', __('Quantity'));
        $grid->column('order_id', __('Order id'));
        $grid->column('interactor', __('Interactor'));
        $grid->column('status', __('Status'));
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
        $show = new Show(Integral::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('type', __('Type'));
        $show->field('quantity', __('Quantity'));
        $show->field('order_id', __('Order id'));
        $show->field('interactor', __('Interactor'));
        $show->field('status', __('Status'));
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

        $form->number('user_id', __('User id'));
        $form->switch('type', __('Type'))->default(1);
        $form->number('quantity', __('Quantity'));
        $form->number('order_id', __('Order id'));
        $form->number('interactor', __('Interactor'));
        $form->switch('status', __('Status'))->default(1);

        return $form;
    }
}
