<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Role;
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

        $grid->column('id', __('Id'))->sortable();
        $grid->column('role.name', '分類');
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'))->display(function($time) {
            return date('Y/m/d H:i:s', strtotime($time));
        });
        $grid->column('氏名')->display(function() {
            return $this->last_name.' '.$this->first_name;
        });
        $grid->column('age', '年齢')->sortable();
        $grid->column('postal_code', '郵便番号');
        $grid->column('area', '都道府県');
        $grid->column('phone_number', '電話番号');
        $grid->column('cancel_flag', '有料解約')->editable('select', ['0' => '無し', '1' => '解約']);
        $grid->column('deleted_flag', '状態')->editable('select', ['0' => '有効', '1' => '無効']);
        $grid->column('created_at', __('Created at'))->display(function($time) {
            return date('Y/m/d H:i:s', strtotime($time));
        })->sortable();
        $grid->column('updated_at', __('Updated at'))->display(function($time) {
            return date('Y/m/d H:i:s', strtotime($time));
        })->sortable();

        $grid->disableCreateButton();
        $grid->actions(function($actions) {
            $actions->disableDelete();
        });

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->equal('role_id', '会員分類')->radio(['' => '全て', '1' => '無料', '2' => '有料']);
            $filter->like('email', 'Email');
            $filter->where(function($query) {
                $query->where('last_name', 'LIKE', "%{$this->input}%")
                    ->orWhere('first_name', 'LIKE', "%{$this->input}%");
            }, '氏名');
            $filter->between('age', '年齢')->integer();
            $filter->like('postal_code', '郵便番号')->integer();
            $filter->in('area', '都道府県')->multipleSelect(User::all()->pluck('area', 'area'));
            $filter->like('phone_number', '電話番号')->integer();
            $filter->equal('cancel_flag', '有料解約')->select(['0' => '無し', '1' => '解約']);
            $filter->equal('deleted_flag', '状態')->select(['0' => '有効', '1' => '無効']);
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

        $show->panel()->tools(function($tools) {
            $tools->disableDelete();
        });

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

        $form->radio('role_id', '会員分類')->options(['1' => '無料', '2' => '有料']);
        $form->email('email', __('Email'));
        $form->password('password', __('Password'));
        $form->text('last_name', __('Last name'));
        $form->text('first_name', __('First name'));
        $form->number('age', __('Age'));
        $form->text('postal_code', __('Postal code'));
        $form->text('area', __('Area'));
        $form->text('address', __('Address'));
        $form->text('phone_number', __('Phone number'));
        $form->switch('cancel_flag', __('Cancel flag'));
        $form->switch('deleted_flag', __('Deleted flag'));

        $form->tools(function($tools) {
            $tools->disableDelete();
        });

        $form->saving(function(Form $form) {
            if($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            } else {
                $form->password = $form->model()->password;
            }
        });

        return $form;
    }
}
