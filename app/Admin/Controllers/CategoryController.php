<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\MajorCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Category';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('major_category.name', '親カテゴリー');
        $grid->column('name', __('Name'));
        $grid->column('created_at', __('Created at'))->display(function($time) {
            return date('Y/m/d H:i:s', strtotime($time));
        })->sortable();
        $grid->column('updated_at', __('Updated at'))->display(function($time) {
            return date('Y/m/d H:i:s', strtotime($time));
        })->sortable();

        $grid->actions(function($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->in('major_category_id', '親カテゴリー')->multipleSelect(MajorCategory::all()->pluck('name', 'id'));
            $filter->like('name', 'Name');
        });

        return $grid;
    }

    // /**
    //  * Make a show builder.
    //  *
    //  * @param mixed $id
    //  * @return Show
    //  */
    // protected function detail($id)
    // {
    //     $show = new Show(Category::findOrFail($id));

    //     $show->field('id', __('Id'));
    //     $show->field('major_category_id', '親カテゴリー');
    //     $show->field('name', __('Name'));
    //     $show->field('created_at', __('Created at'));
    //     $show->field('updated_at', __('Updated at'));

    //     return $show;
    // }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());

        $form->select('major_category_id', '親カテゴリー')->options(MajorCategory::all()->pluck('name', 'id'));
        $form->text('name', __('Name'));

        $form->tools(function($tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        return $form;
    }
}
