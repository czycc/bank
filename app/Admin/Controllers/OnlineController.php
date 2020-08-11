<?php

namespace App\Admin\Controllers;

use App\Models\Online;
use App\Models\OnlineCategory;
use App\Models\Scope;
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
    protected $title = '线上内容';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Online());
        $grid->model()->orderByDesc('id');
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('title', __('Title'));
            $filter->like('scope.name', __('Scope'));
            $filter->like('category.name', __('Board'));


        });
        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
//        $grid->column('content', __('Content'));
        $grid->column('scope.name', __('Scope'));
        $grid->column('category.name', __('Board'));
        $grid->column('end', __('End'))->sortable();
        $grid->column('enable', __('Enable'))->using([
            0 => '否',
            1 => '是'
        ]);
        $grid->column('visit', '总点击量')->display(function () {
            return visits($this)->count();
        });
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
        $show->field('scope_id', __('Scope'));
        $show->field('category_id', __('Board'));
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
        $form->image('banner', 'banner图');
        $form->select('scope_id', __('Scope'))->options(function () {
            $scope = Scope::all();
            $option = [];
            foreach ($scope as $item) {
                $option[$item->id] = $item->name;
            }
            return $option;
        });
        $form->select('category_id', __('Board'))->options(function () {
                $cates = OnlineCategory::all();
                $option = [];
                foreach ($cates as $item) {
                    $option[$item->id] = $item->name;
                }
                return $option;
            });
        $form->datetime('end', __('End'))->default(date('Y-m-d H:i:s'));
        $form->switch('enable', __('Enable'));

        return $form;
    }
}
