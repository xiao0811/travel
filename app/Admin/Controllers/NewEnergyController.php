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
        $grid->column('car_id', __('车辆ID'));
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
        $show->field('car_id', __('车辆ID'));
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
        $form->text('car_id', __('车辆ID'));
        $form->image('start_mileage', __('开始'));
        $form->image('end_mileage', __('介绍'));
        $form->decimal('mileage', __('里程 / 时间'));
        $form->select('type', __('类型'))->options([
            "1"  => "电动车",
            "2" => "燃油车",
        ]);
        $form->select('status', __('状态'))->options([
            "1"  => "审核中",
            "10" => "审核拒绝",
            "20" => "审核撤销",
            "30" => "审核通过"
        ]);
        $form->text('remark', __('Remark'));

        return $form;
    }
}
