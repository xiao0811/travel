<?php

namespace App\Admin\Controllers;

use App\Models\Set;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SetController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Set';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Set());
        $grid->disableCreation();
        $grid->actions(function ($actions) {
            //关闭行操作 删除
            $actions->disableDelete();
        });
        $grid->column('new_i', __('新能源每公里积分'));
        $grid->column('new_e', __('新能源每公里减排'));
        $grid->column('car_i', __('燃油车每公里积分'));
        $grid->column('car_e', __('燃油车每公里减排'));

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
        $show = new Show(Set::findOrFail($id));

        $show->field('new_i', __('新能源每公里积分'));
        $show->field('new_e', __('新能源每公里减排'));
        $show->field('car_i', __('燃油车每公里积分'));
        $show->field('car_e', __('燃油车每公里减排'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Set());

        $form->text('new_i', __('新能源每公里积分'));
        $form->text('new_e', __('新能源每公里减排'));
        $form->text('car_i', __('燃油车每公里积分'));
        $form->text('car_e', __('燃油车每公里减排'));

        return $form;
    }
}
