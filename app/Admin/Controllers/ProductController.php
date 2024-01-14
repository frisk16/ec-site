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

        $grid->column('id', __('Id'))->sortable();
        $grid->column('category.name', __('カテゴリー'));
        $grid->column('name', '商品名');
        $grid->column('image', __('Image'))->image();
        $grid->column('price', '値段')->sortable();
        $grid->column('carriage_flag', '送料')->editable('select', ['0' => '無', '1' => '有']);
        $grid->column('recommend_flag', 'おすすめ')->editable('select', ['0' => '無', '1' => '有']);
        $grid->column('public_flag', '公開')->editable('select', ['0' => 'NG', '1' => 'OK']);
        $grid->column('created_at', __('Created at'))->display(function($time) {
            return date('Y/m/d H:i:s', strtotime($time));
        })->sortable();
        $grid->column('updated_at', __('Updated at'))->display(function($time) {
            return date('Y/m/d H:i:s', strtotime($time));
        })->sortable();

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->in('category_id', 'カテゴリー')->multipleSelect(Category::all()->pluck('name', 'id'));
            $filter->like('name', '商品名');
            $filter->between('price', '値段')->integer();
            $filter->equal('carriage_flag', '送料')->radio(['' => '全て', '0' => '無', '1' => '有']);
            $filter->equal('recommend_flag', 'おすすめ')->radio(['' => '全て', '0' => '無', '1' => '有']);
            $filter->equal('public_flag', '公開')->radio(['' => '全て', '0' => 'NG', '1' => 'OK']);
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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category_id', __('Category id'));
        $show->field('name', __('Name'));
        $show->field('image', __('Image'));
        $show->field('price', __('Price'));
        $show->field('description', '商品内容');
        $show->field('carriage_flag', '送料');
        $show->field('recommend_flag', 'おすすめ');
        $show->field('public_flag', '公開');
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
        $form->image('image', '画像 (縦320px)')->uniqueName();
        $form->number('price', __('Price'));
        $form->textarea('description', '商品内容');
        $form->switch('carriage_flag', '送料');
        $form->switch('recommend_flag', 'おすすめ');
        $form->switch('public_flag', '公開')->default(1);

        return $form;
    }
}
