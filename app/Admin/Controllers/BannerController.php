<?php

namespace App\Admin\Controllers;

use App\Models\Banner;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BannerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Banner';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Banner());

        // $grid->column('id', __('ID'));
        $grid->column('url', __('图片'));
        $grid->column('type', __('类型'));
        // $grid->column('content', __('Content'));
        $grid->column('sort', __('排序'));
        $grid->column('status', __('状态'));

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
        $show = new Show(Banner::findOrFail($id));

        $show->field('url', __('图片'));
        $show->field('type', __('类型'));
        $show->field('sort', __('排序'));
        $show->field('status', __('状态'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Banner());

        $form->multipleImage('url', __('图片'));
        $form->select('type', __('类型'))->options([
            '1' => '首页',
            '2' => '商城'
        ])->default(1);
        $form->number('sort', __('排序'))->default(1);
        $form->radio('status', __('状态'))->options([
            '1' => '显示',
            '2' => '隐藏'
        ])->default(1);

        return $form;
    }
}
