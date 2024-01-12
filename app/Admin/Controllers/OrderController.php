<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('order_code', __('Order code'));
        $grid->column('total_price', __('Total price'));
        $grid->column('created_at', __('Created at'))->display(function($time) {
            return date('Y/m/d H:i:s', strtotime($time));
        });
        $grid->column('updated_at', __('Updated at'))->display(function($time) {
            return date('Y/m/d H:i:s', strtotime($time));
        });

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
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('order_code', __('Order code'));
        $show->field('des_name', __('Des name'));
        $show->field('des_postal_code', __('Des postal code'));
        $show->field('des_address', __('Des address'));
        $show->field('des_phone_number', __('Des phone number'));
        $show->field('carriage', __('Carriage'));
        $show->field('total_qty', __('Total qty'));
        $show->field('total_price', __('Total price'));
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
        $form = new Form(new Order());

        $form->number('user_id', __('User id'));
        $form->text('order_code', __('Order code'));
        $form->text('des_name', __('Des name'));
        $form->text('des_postal_code', __('Des postal code'));
        $form->text('des_address', __('Des address'));
        $form->text('des_phone_number', __('Des phone number'));
        $form->number('carriage', __('Carriage'));
        $form->number('total_qty', __('Total qty'));
        $form->number('total_price', __('Total price'));

        return $form;
    }
}
