<?php

namespace App\Admin\Controllers;

use App\Models\OrderedProduct;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderedProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'OrderedProduct';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OrderedProduct());

        $grid->column('id', __('Id'));
        $grid->column('order_id', __('Order id'));
        $grid->column('product_id', __('Product id'));
        $grid->column('total_qty', __('Total qty'));
        $grid->column('total_price', __('Total price'));
        $grid->column('cancel_flag', 'キャンセル')->editable('select', ['0' => '否', '1' => '済']);
        $grid->column('completed_flag', '完了')->editable('select', ['0' => '否', '1' => '済']);
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
        $show = new Show(OrderedProduct::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('order_id', __('Order id'));
        $show->field('product_id', __('Product id'));
        $show->field('total_qty', __('Total qty'));
        $show->field('total_price', __('Total price'));
        $show->field('cancel_flag', __('Cancel flag'));
        $show->field('completed_flag', __('Completed flag'));
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
        $form = new Form(new OrderedProduct());

        $form->number('order_id', __('Order id'));
        $form->number('product_id', __('Product id'));
        $form->number('total_qty', __('Total qty'));
        $form->number('total_price', __('Total price'));
        $form->switch('cancel_flag', __('Cancel flag'));
        $form->switch('completed_flag', __('Completed flag'));

        return $form;
    }
}
