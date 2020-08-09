<?php

namespace App\Admin\Controllers;

use App\Models\InviteTaskUser;
use App\Models\NewTaskUser;
use App\Models\OutTaskUser;
use App\Models\Scope;
use App\Models\User;
use App\Models\VisitTaskUser;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ScopeWeekController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '任务范围';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Scope());
        $grid->model()->where('id', '!=', 1);
        $grid->disableActions();
        $grid->disablePagination();
        $grid->disableCreateButton();
        $grid->disableFilter();
        $grid->disableRowSelector();

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('out_task', '拓客任务')->display(function () {
            $ids = User::select(['id'])->where('scope_id', $this->id)->get();
            return  OutTaskUser::whereIn('user_id', $ids)
                ->where('created_at', '>', Carbon::now()->subWeek()->startOfWeek())
                ->where('created_at', '<', Carbon::now()->subWeek()->endOfWeek())
                ->count();
        });
        $grid->column('visit_task', '来访任务')->display(function () {
            $ids = User::select(['id'])->where('scope_id', $this->id)->get();
            return  VisitTaskUser::whereIn('user_id', $ids)
                ->where('created_at', '>', Carbon::now()->subWeek()->startOfWeek())
                ->where('created_at', '<', Carbon::now()->subWeek()->endOfWeek())
                ->count();
        });
        $grid->column('new_task', '老带新任务')->display(function () {
            $ids = User::select(['id'])->where('scope_id', $this->id)->get();
            return  NewTaskUser::whereIn('user_id', $ids)
                ->where('created_at', '>', Carbon::now()->subWeek()->startOfWeek())
                ->where('created_at', '<', Carbon::now()->subWeek()->endOfWeek())
                ->count();
        });
        $grid->column('invite_task', '邀约任务')->display(function () {
            $ids = User::select(['id'])->where('scope_id', $this->id)->get();
            return  InviteTaskUser::whereIn('user_id', $ids)
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
        $show = new Show(Scope::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Scope());

        $form->text('name', __('Name'));
        $form->textarea('description', __('Description'));

        return $form;
    }
}
