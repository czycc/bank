<?php

namespace App\Admin\Controllers;

use App\Models\InviteTaskUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InviteTaskUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '邀约任务客户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new InviteTaskUser());

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('user.name', '业务员姓名');
            $filter->like('task.title', '任务标题');
            $filter->like('phone', '客户手机号');
            $filter->between('created_at', '创建时间')->datetime();
        });

        $grid->disableActions();
        $grid->model()->orderByDesc('id');

        $grid->column('id', __('Id'));
        $grid->column('user.name', '业务员姓名');
        $grid->column('task.title', '任务名称');
        $grid->column('phone', __('Phone'));
        $grid->column('created_at', __('Created at'));
//        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(InviteTaskUser::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('invite_task_id', __('Invite task id'));
        $show->field('phone', __('Phone'));
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
        $form = new Form(new InviteTaskUser());

        $form->number('user_id', __('User id'));
        $form->number('invite_task_id', __('Invite task id'));
        $form->mobile('phone', __('Phone'));

        return $form;
    }
}
