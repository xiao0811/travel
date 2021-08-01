<?php

namespace App\Admin\Controllers;

use App\Models\Video;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VideoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Video';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Video());

        $grid->column('id', __('ID'));
        $grid->column('title', __('标题'));
        // $grid->column('thumbnail', __('缩略图'));
        $grid->column('url', __('视频链接'));
        $grid->column('source', __('来源'));
        $grid->column('sort', __('排序'));
        $grid->column('type', __('分类'));
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
        $show = new Show(Video::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('标题'));
        // $show->field('thumbnail', __('缩略图'));
        $show->field('content', __('内容'));
        $show->field('url', __('视频链接'));
        $show->field('source', __('来源'));
        $show->field('sort', __('排序'));
        $show->field('type', __('分类'));
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
        $form = new Form(new Video());

        $form->text('title', __('标题'));
        $form->text('url', __('视频链接'));
        // $form->textarea('content', __('内容'));
        $form->editor('content','内容');
        // $form->multipleImage('thumbnail', __('文章缩略图'));
        $form->text('source', __('来源'));
        // $form->number('status', __('状态'));
        $form->radio('status', __('状态'))->options([
            '1' => '显示',
            '2' => '隐藏'
        ])->default(1);
        // $form->number('type', __('分类'))->default(1);
        $form->select('type', __('分类'))->options([
            '1' => '合肥资讯',
            '2' => '安徽资讯',
            "3" => "国内资讯",
        ])->default(1);
        $form->number('sort', __('Sort'))->default(1);

        return $form;
    }
}
