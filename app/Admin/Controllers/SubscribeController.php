<?php

namespace App\Admin\Controllers;

use App\Models\Subscribe;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SubscribeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Subscribe';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Subscribe());
        $grid->column('number', __('商品编号'));
        $grid->column('name', __('商品名称'));
        $grid->column('subtitle', __('商品副标题'));
        $grid->column('price', __('单价'));
        $grid->column('quantity', __('库存'));
        $grid->column('type', __('分类'));
        $grid->column('status', __('状态'));
        $grid->column('recommend', __('推荐'));
        $grid->column('sold', __('总售量'));
        $grid->column('integral', __('返还碳积分'));
        $grid->column('emission', __('返还碳减排'));
        $grid->column('place', __('地点'));
        $grid->column('maintenance', __('养护'));
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
        $show = new Show(Subscribe::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Subscribe());

        $form->text('number', __('商品编号'));
        $form->text('name', __('商品名称'));
        $form->text('subtitle', __('商品副标题'));
        $form->multipleImage('images', __('商品图片'));
        $form->text('price', __('单价'));
        $form->number('quantity', __('库存'));
        $form->select('type', __('分类'))->options([
            1 => "合肥定制",
            2 => "商场",
            3 => "卡券",
            4 => "办公",
            5 => "票务",
            6 => "居家",
            7 => "生活",
            8 => "智能",
        ])->default(1);
        $form->radio('status', __('状态'))->options([
            1 => "正常",
            10 => "下架",
        ])->default(1);
        $form->editor('content','内容');
        $form->number('integral', __('返还碳积分'));
        $form->text('emission', __('返还碳减排'));
        $form->text('place', __('地点'));
        $form->text('maintenance', __('养护'));
        $form->switch('recommend', __('是否推荐'));

        return $form;
    }
}
