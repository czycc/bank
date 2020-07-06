<?php

namespace App\Admin\Controllers;

use App\Models\Task;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TaskController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '任务列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Task());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('content', __('Content'));
        $grid->column('scope', __('Scope'));
        $grid->column('category', __('Category'));
        $grid->column('end', __('End'));
        $grid->column('urgency', __('Urgency'));
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
        $show = new Show(Task::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
        $show->field('scope', __('Scope'));
        $show->field('category', __('Category'));
        $show->field('end', __('End'));
        $show->field('urgency', __('Urgency'));
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
        $form = new Form(new Task());

        $form->text('title', __('Title'));
        $form->editor('content', __('Content'));
        $form->text('scope', __('Scope'));
        $form->text('category', __('Category'));
        $form->datetime('end', __('End'))->default(date('Y-m-d H:i:s'));
        $form->select('urgency', __('Urgency'))->options([
            "特急" => "特急",
            "急" => "急",
            "无" => "无"
        ]);

        return $form;
    }
}
