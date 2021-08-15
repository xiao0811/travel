<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Activity';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Activity());

        $grid->column('title', __('活动标题'));
        $grid->column('source', __('来源'));
        $grid->column('start_time', __('开始时间'));
        $grid->column('end_time', __('结束时间'));
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
        $show = new Show(Activity::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('cover', __('Cover'));
        $show->field('source', __('Source'));
        $show->field('start_time', __('Start time'));
        $show->field('end_time', __('End time'));
        $show->field('content', __('Content'));
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
        $form = new Form(new Activity());

        $form->text('title', __('活动标题'));
        $form->multipleImage('cover', __('Cover'))->removable();
        $form->text('source', __('来源'));
        $form->date('start_time', __('开始时间'))->default(date('Y-m-d'));
        $form->date('end_time', __('结束时间'))->default(date('Y-m-d'));
        $form->editor('content', __('活动详情'));
        // $form->switch('status', __('状态'));

        return $form;
    }
}
