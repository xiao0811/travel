<?php

namespace App\Admin\Controllers;

use App\Models\Goods;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Goods';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Goods());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('number', __('Number'));
        $grid->column('price', __('Price'));
        $grid->column('integral', __('Integral'));
        $grid->column('quantity', __('Quantity'));
        $grid->column('images', __('Images'));
        $grid->column('details', __('Details'));
        $grid->column('type', __('Type'));
        $grid->column('status', __('Status'));
        $grid->column('recommend', __('Recommend'));
        $grid->column('sold', __('Sold'));
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
        $show = new Show(Goods::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('number', __('Number'));
        $show->field('price', __('Price'));
        $show->field('integral', __('Integral'));
        $show->field('quantity', __('Quantity'));
        $show->field('images', __('Images'));
        $show->field('details', __('Details'));
        $show->field('type', __('Type'));
        $show->field('status', __('Status'));
        $show->field('recommend', __('Recommend'));
        $show->field('sold', __('Sold'));
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
        $form = new Form(new Goods());

        $form->text('name', __('Name'));
        $form->text('number', __('Number'));
        $form->decimal('price', __('Price'));
        $form->number('integral', __('Integral'));
        $form->number('quantity', __('Quantity'));
        $form->text('images', __('Images'));
        $form->textarea('details', __('Details'));
        $form->switch('type', __('Type'))->default(1);
        $form->switch('status', __('Status'))->default(1);
        $form->switch('recommend', __('Recommend'));
        $form->number('sold', __('Sold'));
        $form->text('remark', __('Remark'));

        return $form;
    }
}
