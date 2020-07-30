<?php

namespace App\Admin\Controllers;

use App\Models\VisitTask;
use App\Models\VisitTaskUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VisitTaskUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '来访任务客户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new VisitTaskUser());

        $grid->disableActions();
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('user.name', '业务员姓名');
            $filter->like('task.title', '任务标题');
            $filter->like('phone', '客户手机号');
            $filter->between('created_at', '创建时间')->datetime();
        });

        $grid->column('id', __('Id'));
        $grid->column('user.name', '业务员姓名');
        $grid->column('task.title', '任务名称');
        $grid->column('phone', __('Phone'));
        $grid->column('username', __('Username'));
        $grid->column('comment', __('Comment'));
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
        $show = new Show(VisitTaskUser::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('visit_task_id', __('Visit task id'));
        $show->field('phone', __('Phone'));
        $show->field('username', __('Username'));
        $show->field('comment', __('Comment'));
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
        $form = new Form(new VisitTaskUser());

        $form->number('user_id', __('User id'));
        $form->number('visit_task_id', __('Visit task id'));
        $form->mobile('phone', __('Phone'));
        $form->text('username', __('Username'));
        $form->text('comment', __('Comment'));

        return $form;
    }
}
