<?php

namespace App\Admin\Controllers;

use App\Models\InviteTaskUser;
use App\Models\NewTaskUser;
use App\Models\OutTaskUser;
use App\Models\User;
use App\Models\VisitTaskUser;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserTaskWeekController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '周统计';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid = new Grid(new User());

        $grid->disableActions();
//
        $grid->disablePagination();
//
        $grid->disableCreateButton();
//
        $grid->disableFilter();
//
        $grid->disableRowSelector();
//
//    $grid->disableColumnSelector();
//
//    $grid->disableTools();
//
//    $grid->disableExport();

//        $grid->actions(function (Grid\Displayers\Actions $actions) {
//            $actions->disableView();
//       $actions->disableEdit();
//        $actions->disableDelete();
//        });

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('job_num', __('Job num'));
        $grid->column('phone', __('Phone'));
        $grid->column('out_task', '拓客任务')->display(function () {
            return  OutTaskUser::where('user_id', $this->id)
                ->where('created_at', '>', Carbon::now()->subWeek()->startOfWeek())
                ->where('created_at', '<', Carbon::now()->subWeek()->endOfWeek())
                ->count();
        });
        $grid->column('visit_task', '来访任务')->display(function () {
            return  VisitTaskUser::where('user_id', $this->id)
                ->where('created_at', '>', Carbon::now()->subWeek()->startOfWeek())
                ->where('created_at', '<', Carbon::now()->subWeek()->endOfWeek())
                ->count();
        });
        $grid->column('new_task', '老带新任务')->display(function () {
            return  NewTaskUser::where('user_id', $this->id)
                ->where('created_at', '>', Carbon::now()->subWeek()->startOfWeek())
                ->where('created_at', '<', Carbon::now()->subWeek()->endOfWeek())
                ->count();
        });
        $grid->column('invite_task', '邀约任务')->display(function () {
            return  InviteTaskUser::where('user_id', $this->id)
                ->where('created_at', '>', Carbon::now()->subWeek()->startOfWeek())
                ->where('created_at', '<', Carbon::now()->subWeek()->endOfWeek())
                ->count();
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
        $show->field('remember_token', __('Remember token'));
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
        $form->text('wx_avatar', __('Wx avatar'));
        $form->password('password', __('Password'));
        $form->text('remember_token', __('Remember token'));

        return $form;
    }
}
