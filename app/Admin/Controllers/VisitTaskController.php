<?php

namespace App\Admin\Controllers;

use App\Models\Scope;
use App\Models\VisitTask;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VisitTaskController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '拓客任务';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new VisitTask());
        $grid->model()->orderByDesc('id');
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('title', __('Title'));
            $filter->like('task.title', '任务标题');
            $filter->like('phone', '客户手机号');
            $filter->between('end', __('End'))->datetime();
            $filter->between('start', __('Start'))->datetime();

        });

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
        $show = new Show(VisitTask::findOrFail($id));

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
        $form = new Form(new VisitTask());

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
