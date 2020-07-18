<?php

namespace App\Admin\Controllers;

use App\Models\OutTask;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OutTaskController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'OutTask';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OutTask());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('content', __('Content'));
        $grid->column('scope', __('Scope'));
        $grid->column('start', __('Start'));
        $grid->column('end', __('End'));
        $grid->column('urgency', __('Urgency'));
        $grid->column('enable', __('Enable'));
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
        $show = new Show(OutTask::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
        $show->field('scope', __('Scope'));
        $show->field('start', __('Start'));
        $show->field('end', __('End'));
        $show->field('urgency', __('Urgency'));
        $show->field('enable', __('Enable'));
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
        $form = new Form(new OutTask());

        $form->text('title', __('Title'));
        $form->textarea('content', __('Content'));
        $form->text('scope', __('Scope'));
        $form->datetime('start', __('Start'))->default(date('Y-m-d H:i:s'));
        $form->datetime('end', __('End'))->default(date('Y-m-d H:i:s'));
        $form->text('urgency', __('Urgency'));
        $form->switch('enable', __('Enable'));

        return $form;
    }
}