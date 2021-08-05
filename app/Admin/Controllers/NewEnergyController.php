<?php

namespace App\Admin\Controllers;

use App\Models\NewEnergy;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NewEnergyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'NewEnergy';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new NewEnergy());

        $grid->column('user_id', __('用户'));
        $grid->column('car_number', __('车牌号'));
        $grid->column('start_mileage', __('开始里程'));
        $grid->column('end_mileage', __('结束里程'));
        $grid->column('mileage', __('里程'));
        $grid->column('type', __('车辆类型'));
        $grid->column('status', __('状态'));
        $grid->column('remark', __('备注'));

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
        $show = new Show(NewEnergy::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('car_number', __('Car number'));
        $show->field('start_mileage', __('Start mileage'));
        $show->field('end_mileage', __('End mileage'));
        $show->field('mileage', __('Mileage'));
        $show->field('type', __('Type'));
        $show->field('status', __('Status'));
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
        $form = new Form(new NewEnergy());

        $form->number('user_id', __('User id'));
        $form->text('car_number', __('Car number'));
        $form->text('start_mileage', __('Start mileage'));
        $form->text('end_mileage', __('End mileage'));
        $form->decimal('mileage', __('Mileage'));
        $form->switch('type', __('Type'));
        $form->switch('status', __('Status'));
        $form->text('remark', __('Remark'));

        return $form;
    }
}
