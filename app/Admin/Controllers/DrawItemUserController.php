<?php

namespace App\Admin\Controllers;

use App\Models\DrawItemUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DrawItemUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '中奖人信息';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DrawItemUser());
        $grid->model()->orderByDesc('id');
        $grid->disableActions();
        $grid->disableCreateButton();
        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('title', __('Title'));
            $filter->like('user.name', '业务员姓名');
            $filter->like('draw_item.reward', '奖品名称');
            $filter->like('draw.title', '抽奖活动名称');
            $filter->like('phone', '手机号');
            $filter->equal('verify', '是否核销')->using([
                0 => '否',
                1 => '是'
            ]);
            $filter->like('verify_user.name', '核销人');
            $filter->between('created_at', __('Created at'));

        });
        $grid->column('id', __('Id'));
        $grid->column('user.name', __('Name'));
        $grid->column('draw_item.reward', '奖品名称');
        $grid->column('draw.title', '抽奖活动名称');
        $grid->column('phone', __('Phone'));
        $grid->column('verify', '是否核销')->using([
            0 => '否',
            1 => '是'
        ]);
        $grid->column('verify_user.name', '核销人');
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
        $show = new Show(DrawItemUser::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('draw_item_id', __('Draw item id'));
        $show->field('draw_id', __('Draw id'));
        $show->field('phone', __('Phone'));
        $show->field('verify', __('Verify'));
        $show->field('verify_user_id', __('Verify user id'));
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
        $form = new Form(new DrawItemUser());

        $form->number('user_id', __('User id'));
        $form->number('draw_item_id', __('Draw item id'));
        $form->number('draw_id', __('Draw id'));
        $form->mobile('phone', __('Phone'));
        $form->number('verify', __('Verify'));
        $form->number('verify_user_id', __('Verify user id'));

        return $form;
    }
}
