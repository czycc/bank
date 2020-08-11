<?php

namespace App\Admin\Controllers;

use App\Models\Scope;
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
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());
        $grid->model()->orderByDesc('id');

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('job_num', __('Job num'));
        $grid->column('unit', __('Unit'));
        $grid->column('department', __('Department'));
        $grid->column('job', __('Job'));
        $grid->column('email', __('Email'));
        $grid->column('phone', __('Phone'));
        $grid->column('avatar', __('Avatar'))->image('', 100,100);
        $grid->column('wx_avatar', __('Wx avatar'))->image('', 100,100);
//        $grid->column('password', __('Password'));
//        $grid->column('remember_token', __('Remember token'));
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('job_num', __('Job num'));
        $show->field('unit', __('Unit'));
        $show->field('department', __('Department'));
        $show->field('job', __('Job'));
        $show->field('email', __('Email'));
        $show->field('phone', __('Phone'));
        $show->field('avatar', __('Avatar'));
        $show->field('wx_avatar', __('Wx avatar'));
        $show->field('password', __('Password'));
//        $show->field('remember_token', __('Remember token'));
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

        $form->text('name', __('Name'));
        $form->text('job_num', __('Job num'));
        $form->text('unit', __('Unit'));
        $form->text('department', __('Department'));
        $form->text('job', __('Job'));
        $form->email('email', __('Email'));
        $form->mobile('phone', __('Phone'));
        $form->image('avatar', __('Avatar'));
        $form->image('wx_avatar', __('Wx avatar'));
        $form->hidden('password', __('Password'))->default('12345678');
        $form->select('scope_id', __('Scope'))->options(function () {
            $scope = Scope::all();
            $a = [];
            foreach ($scope as $item) {
                if ($item->id !== 1) {
                    $a[$item->id] = $item->name;
                }
            }
            return $a;
        })->default(2);
//        $form->text('remember_token', __('Remember token'));

        return $form;
    }
}
