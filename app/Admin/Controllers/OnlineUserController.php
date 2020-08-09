<?php

namespace App\Admin\Controllers;

use App\Models\OnlineUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OnlineUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '热门活动报名人员';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OnlineUser());
        $grid->model()->orderByDesc('id');
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('user.name', '业务员姓名');
            $filter->like('phone', '报名人员手机号');
            $filter->like('online.title', '活动名称');


        });
        $grid->column('id', __('Id'));
        $grid->column('user.name', '业务员姓名');
        $grid->column('online.title', '活动名称');
        $grid->column('phone', __('Phone'));
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
        $show = new Show(OnlineUser::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('online_id', __('Online id'));
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
        $form = new Form(new OnlineUser());

        $form->number('user_id', __('User id'));
        $form->number('online_id', __('Online id'));
        $form->mobile('phone', __('Phone'));

        return $form;
    }
}
