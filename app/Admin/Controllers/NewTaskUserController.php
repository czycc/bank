<?php

namespace App\Admin\Controllers;

use App\Models\NewTaskUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NewTaskUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'NewTaskUser';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new NewTaskUser());

        $grid->disableActions();


        $grid->column('id', __('Id'));
        $grid->column('user.name', __('name'));
        $grid->column('task.title', '任务名称');
        $grid->column('old_phone', __('Old phone'));
        $grid->column('old_username', __('Old username'));
        $grid->column('new_phone', __('New phone'));
        $grid->column('new_username', __('New username'));
        $grid->column('comment', __('Comment'));
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
        $show = new Show(NewTaskUser::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('new_task_id', __('New task id'));
        $show->field('old_phone', __('Old phone'));
        $show->field('old_username', __('Old username'));
        $show->field('new_phone', __('New phone'));
        $show->field('new_username', __('New username'));
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
        $form = new Form(new NewTaskUser());

        $form->number('user_id', __('User id'));
        $form->number('new_task_id', __('New task id'));
        $form->text('old_phone', __('Old phone'));
        $form->text('old_username', __('Old username'));
        $form->text('new_phone', __('New phone'));
        $form->text('new_username', __('New username'));
        $form->text('comment', __('Comment'));

        return $form;
    }
}
