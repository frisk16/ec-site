<?php

namespace App\Admin\Controllers;

use App\Models\MajorCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MajorCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'MajorCategory';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MajorCategory());

        $grid->column('id', __('Id'));
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
    //     $show = new Show(MajorCategory::findOrFail($id));

    //     $show->field('id', __('Id'));
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
        $form = new Form(new MajorCategory());

        $form->text('name', __('Name'));

        $form->tools(function($tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        return $form;
    }
}
