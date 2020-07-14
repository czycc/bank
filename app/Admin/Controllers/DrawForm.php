<?php

namespace App\Admin\Controllers;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class DrawForm extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '抽奖规则设置';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        //dump($request->all());
        option(['draw_rule' => $request->draw_rule]);

        admin_success('设置成功!');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->ckeditor('draw_rule')->rules('required');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'draw_rule' => option('draw_rule', '<p>抽奖规则说明<p>细则')
        ];
    }
}
