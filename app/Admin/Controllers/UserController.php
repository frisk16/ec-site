<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('role_id', __('Role Id'));
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('last_name', __('Last name'));
        $grid->column('first_name', __('First name'));
        $grid->column('age', __('Age'));
        $grid->column('postal_code', __('Postal code'));
        $grid->column('area', __('Area'));
        $grid->column('phone_number', __('Phone number'));
        $grid->column('cancel_flag', __('Cancel flag'));
        $grid->column('deleted_flag', __('Deleted flag'));
        $grid->column('created_at', __('Created at'))->display(function($time) {
            return date('Y/m/d H:i:s', strtotime($time));
        })->sortable();
        $grid->column('updated_at', __('Updated at'))->display(function($time) {
            return date('Y/m/d H:i:s', strtotime($time));
        })->sortable();

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('role_id', __('Role id'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
        $show->field('last_name', __('Last name'));
        $show->field('first_name', __('First name'));
        $show->field('age', __('Age'));
        $show->field('postal_code', __('Postal code'));
        $show->field('area', __('Area'));
        $show->field('address', __('Address'));
        $show->field('phone_number', __('Phone number'));
        $show->field('cancel_flag', __('Cancel flag'));
        $show->field('deleted_flag', __('Deleted flag'));
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
        $form = new Form(new User());

        $form->number('role_id', __('Role id'))->default(1);
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->text('remember_token', __('Remember token'));
        $form->text('last_name', __('Last name'));
        $form->text('first_name', __('First name'));
        $form->number('age', __('Age'));
        $form->text('postal_code', __('Postal code'));
        $form->text('area', __('Area'));
        $form->text('address', __('Address'));
        $form->text('phone_number', __('Phone number'));
        $form->switch('cancel_flag', __('Cancel flag'));
        $form->switch('deleted_flag', __('Deleted flag'));

        return $form;
    }
}
