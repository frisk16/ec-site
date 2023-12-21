<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->column('id', __('Id'));
        $grid->column('category.name', __('カテゴリー'));
        $grid->column('name', __('Name'));
        $grid->column('image', __('Image'))->image();
        $grid->column('price', __('Price'));
        $grid->column('carriage_flag', __('Carriage flag'));
        $grid->column('recommend_flag', __('Recommend flag'));
        $grid->column('public_flag', __('Public flag'));
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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category_id', __('Category id'));
        $show->field('name', __('Name'));
        $show->field('image', __('Image'));
        $show->field('price', __('Price'));
        $show->field('description', __('Description'));
        $show->field('carriage_flag', __('Carriage flag'));
        $show->field('recommend_flag', __('Recommend flag'));
        $show->field('public_flag', __('Public flag'));
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
        $form = new Form(new Product());

        $form->select('category_id', 'カテゴリー')->options(Category::all()->pluck('name', 'id'));
        $form->text('name', __('Name'));
        $form->image('image', __('Image'))->uniqueName();
        $form->number('price', __('Price'));
        $form->textarea('description', __('Description'));
        $form->switch('carriage_flag', __('Carriage flag'));
        $form->switch('recommend_flag', __('Recommend flag'));
        $form->switch('public_flag', __('Public flag'))->default(1);

        return $form;
    }
}
