<?php

namespace App\Admin\Controllers;

use App\Models\InviteTask;
use App\Models\Scope;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InviteTaskController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'InviteTask';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new InviteTask());
        $grid->model()->orderByDesc('id');

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
//        $grid->column('content', __('Content'));
//        $grid->column('scope', __('Scope'));
        $grid->column('start', __('Start'));
        $grid->column('end', __('End'));
        $grid->column('urgency', __('Urgency'))->using([
            0 => '普通',
            1 => '急',
            2 => '特急'
        ]);
        $grid->column('enable', __('Enable'))->using([
            0 => '关闭',
            1 => '开启'
        ]);
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
        $show = new Show(InviteTask::findOrFail($id));

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
        $form = new Form(new InviteTask());

        $form->text('title', __('Title'))->rules('required');
        $form->ckeditor('content', __('Content'))->rules('required');
        $form->select('scope_id', __('Scope'))->options(function () {
            $scope = Scope::all();
            $a = [];
            foreach ($scope as $item) {
                $a[$item->id] = $item->name;
            }
            return $a;
        })->default(1);
        $form->datetime('start', __('Start'))->default(date('Y-m-d H:i:s'));
        $form->datetime('end', __('End'))->default(date('Y-m-d H:i:s'));
        $form->select('urgency', __('Urgency'))->options([
            0 => '普通',
            1 => '急',
            2 => '特急'
        ])->default(0);
        $form->switch('enable', __('Enable'));

        return $form;
    }
}
