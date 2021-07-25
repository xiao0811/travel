<?php

namespace App\Admin\Controllers;

use App\Models\Question;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class QuestionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Question';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Question());

        $grid->column('id', __('Id'));
        $grid->column('ask', __('问题'));
        $grid->column('options1', __('选项1'));
        $grid->column('options2', __('选项2'));
        $grid->column('options3', __('选项3'));
        $grid->column('prompt', __('提示'));
        $grid->column('answer', __('答案'));
        $grid->column('status', __('状态'));
        $grid->column('type', __('类型'));
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
        $show = new Show(Question::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('ask', __('问题'));
        $show->field('options1', __('选项1'));
        $show->field('options2', __('选项2'));
        $show->field('options3', __('选项3'));
        $show->field('prompt', __('提示'));
        $show->field('answer', __('答案'));
        $show->field('status', __('状态'));
        $show->field('type', __('类型'));
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
        $form = new Form(new Question());

        $form->text('ask', __('问题'));
        $form->text('options1', __('选项1'));
        $form->text('options2', __('选项2'));
        $form->text('options3', __('选项3'));
        $form->text('prompt', __('提示'));
        $form->radio('answer', __('答案'))->options([1 => "1", 2 => "2", 3 => "3"])->default(1);;
        $form->switch('status', __('状态'))->default(1);
        $form->select('type', __('类型'))->options([
            1 => "小知识1",
            2 => "小知识2",
            3 => "小知识3",
        ])->default(1);

        return $form;
    }
}
