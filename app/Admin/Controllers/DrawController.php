<?php

namespace App\Admin\Controllers;

use App\Models\Draw;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DrawController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '抽奖工具配置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Draw());
        $grid->model()->orderByDesc('id');

        $grid->actions(function ($actions) {
//            $actions->disableDelete();
//                $actions->disableEdit();
        });

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('title', __('Title'));
            $filter->between('end', __('End'))->datetime();
            $filter->equal('enable', __('Enable'))->radio([
                0 => '否',
                1 => '是'
            ]);
            $filter->between('created_at', __('Created at'));

        });

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('background', __('Background'))->image('', 100, 100);
//        $grid->column('info', __('Info'));
        $grid->column('rule', __('Rule'));
        $grid->column('num', __('Num'));
        $grid->column('end', __('End'));
        $grid->column('enable', __('Enable'))->using([
            0 => '否',
            1 => '是'
        ]);
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
        $show = new Show(Draw::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('background', __('Background'));
//        $show->field('info', __('Info'));
        $show->field('rule', __('Rule'));
        $show->field('num', __('Num'));
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
        $form = new Form(new Draw());

        $form->text('title', __('Title'));
        $form->image('background', __('Background'));
        $form->hasMany('items', '奖品', function (Form\NestedForm $form) {
            $form->text('reward', __("Reward"))->rules('required');
            $form->image('reward_bg', "奖品图片(必填) *");
            $form->text('odds', __("Odds"))->rules('required|between:0,100');
            $form->html('不需要单独设置谢谢参与,总中奖率低于100时,剩余为未中奖几率', '注意事项');
            $form->text('stock', __("Stock"))->rules("required|min:0");
            $form->hidden("out", __("Out"))->default(0);
        });
        $form->ckeditor('rule', __('Rule'));
        $form->number('num', __('Num'))->default(1)->rules('required|between:1,1000');
        $form->datetime('end', __('End'))->default(date('Y-m-d H:i:s'));
        $form->switch('enable', __('Enable'));

        return $form;
    }
}
