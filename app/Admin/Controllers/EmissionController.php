<?php

namespace App\Admin\Controllers;

use App\Models\Emission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EmissionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Emission';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Emission());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('quantity', __('Quantity'));
        $grid->column('type', __('Type'));
        $grid->column('status', __('Status'));
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
        $show = new Show(Emission::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('quantity', __('Quantity'));
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
        $form = new Form(new Emission());

        $form->number('user_id', __('User id'));
        $form->decimal('quantity', __('Quantity'));
        $form->switch('type', __('Type'))->default(1);
        $form->switch('status', __('Status'))->default(1);
        $form->text('remark', __('Remark'));

        return $form;
    }
}
