<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Article';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        $grid->column('id', __('ID'));
        $grid->column('title', __('标题'));
        $grid->column('subtitle', __('副标题'));
        // $grid->column('content', __('Content'));
        $grid->column('author', __('作者'));
        $grid->column('status', __('状态'));
        $grid->column('type', __('类型'));
        $grid->column('view', __('阅读量'));
        $grid->column('like', __('点赞数'));
        $grid->column('sort', __('排序'));
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
        $show = new Show(Article::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('标题'));
        $show->field('subtitle', __('副标题'));
        $show->field('content', __('内容'));
        $show->field('author', __('作者'));
        $show->field('status', __('状态'));
        $show->field('type', __('分类'));
        $show->field('view', __('View'));
        $show->field('like', __('Like'));
        $show->field('sort', __('Sort'));
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
        $form = new Form(new Article());

        $form->text('title', __('标题'));
        $form->text('subtitle', __('副标题'));
        $form->textarea('content', __('内容'));
        $form->text('author', __('作者'));
        // $form->number('status', __('状态'));
        $form->radio('status', __('状态'))->options([
            '1' => '显示',
            '2' => '隐藏'
        ])->default(1);
        // $form->number('type', __('分类'))->default(1);
        $form->select('type', __('分类'))->options([
            '1' => '国内',
            '2' => '国外',
            "3" => "骁傻",
        ])->default(1);
        $form->number('sort', __('Sort'));

        return $form;
    }
}
