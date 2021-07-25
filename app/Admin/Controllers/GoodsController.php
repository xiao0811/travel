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

        // $grid->column('id', __('Id'));
        $grid->column('name', __('商品名称'));
        $grid->column('number', __('商品编号'));
        $grid->column('price', __('价格'));
        $grid->column('integral', __('积分'));
        $grid->column('quantity', __('库存'));
        // $grid->column('images', __('Images'));
        // $grid->column('details', __('Details'));
        $grid->column('type', __('分类'));
        $grid->column('status', __('状态'));
        $grid->column('recommend', __('推荐'));
        $grid->column('sold', __('总售量'));
        // $grid->column('remark', __('Remark'));
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
        $show = new Show(Goods::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('商品名称'));
        $show->field('number', __('商品编号'));
        $show->field('price', __('价格'));
        $show->field('integral', __('积分'));
        $show->field('quantity', __('商品数量'));
        $show->multipleImage('images', __('商品图片'));
        $show->field('details', __('商品详情'));
        $show->field('type', __('分类'));
        $show->field('status', __('状态'));
        $show->field('recommend', __('是否推荐'));
        $show->field('sold', __('总销量'));
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
        $form = new Form(new Goods());

        $form->text('name', __('商品名称'));
        $form->text('number', __('商品编号'));
        $form->decimal('price', __('价格'));
        $form->number('integral', __('积分'));
        $form->number('quantity', __('商品数量'));
        $form->multipleImage('images', __('商品图片'))->default("http://127.0.0.1:8000/storage/");
        $form->textarea('details', __('商品详情'));
        $form->switch('type', __('分类'))->default(1);
        $form->switch('status', __('状态'))->default(1);
        $form->switch('recommend', __('是否推荐'));
        $form->number('sold', __('总销量'));
        $form->text('remark', __('备注'));

        return $form;
    }
}
