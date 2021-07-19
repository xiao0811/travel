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
        $grid->column('ask', __('Ask'));
        $grid->column('options1', __('Options1'));
        $grid->column('options2', __('Options2'));
        $grid->column('options3', __('Options3'));
        $grid->column('prompt', __('Prompt'));
        $grid->column('answer', __('Answer'));
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
        $show = new Show(Question::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('ask', __('Ask'));
        $show->field('options1', __('Options1'));
        $show->field('options2', __('Options2'));
        $show->field('options3', __('Options3'));
        $show->field('prompt', __('Prompt'));
        $show->field('answer', __('Answer'));
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
        $form = new Form(new Question());

        $form->text('ask', __('Ask'));
        $form->text('options1', __('Options1'));
        $form->text('options2', __('Options2'));
        $form->text('options3', __('Options3'));
        $form->text('prompt', __('Prompt'));
        $form->switch('answer', __('Answer'));
        $form->switch('status', __('Status'))->default(1);
        $form->switch('type', __('Type'))->default(1);

        return $form;
    }
}
