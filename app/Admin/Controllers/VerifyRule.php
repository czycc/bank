<?php

namespace App\Admin\Controllers;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class VerifyRule extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '核销规则';

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
        option(['verify_rule' => $request->verify_rule]);

        admin_success('设置成功!');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->ckeditor('verify_rule')->rules('required');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'verify_rule' => option('verify_rule', '<p>核销规则说明<p>细则')
        ];
    }
}
