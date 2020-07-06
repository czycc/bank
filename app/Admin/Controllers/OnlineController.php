<?php

namespace App\Admin\Controllers;

use App\Models\Online;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OnlineController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Online';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Online());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('content', __('Content'));
        $grid->column('scope', __('Scope'));
        $grid->column('board', __('Board'));
        $grid->column('end', __('End'));
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
        $show = new Show(Online::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
        $show->field('scope', __('Scope'));
        $show->field('board', __('Board'));
        $show->field('end', __('End'));
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
        $form = new Form(new Online());

        $form->text('title', __('Title'));
        $form->ckeditor('content', __('Content'));
        $form->select('scope', __('Scope'))->options([
            "全体支行" => "全体支行"
        ]);
        $form->select('board', __('Board'))->options([
            "热门活动" => "热门活动"
        ]);
        $form->datetime('end', __('End'))->default(date('Y-m-d H:i:s'));
        $form->switch('enable', __('Enable'));

        return $form;
    }
}
