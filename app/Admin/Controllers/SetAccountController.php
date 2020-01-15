<?php

namespace App\Admin\Controllers;

use App\admin\Models\Account;
use App\admin\Models\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;


class SetAccountController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '公众号帐户设置';

    public function index(Content $content)
    {
        $accountInfo = Account::find(1);
        if(empty($accountInfo)){
            return $content
                ->header('公众号帐户设置')
                ->description('公众号帐户设置')
                ->body($this->form(0));
        }else{
            return $content
                ->header('公众号帐户设置')
                ->description('公众号帐户设置')
                ->body($this->form(1)->edit(1));
        }
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($sign = 0)
    {
        $uid = Admin::user()->id; //当前管理员id
        $form = new Form(new Account());
        if($sign==0){
            $form->setAction('set-account');
        }else{
            $form->setAction('set-account/1');
        }
//        $form->display('id', __('ID'))->default($id);
        $form->hidden('id','id')->default(1);
        $form->hidden('user_id','用户id')->default($uid);
        $form->text('name','公众号名称')->default('')->rules('required');
        $form->text('app_id','app_id')->default('')->rules('required');
        $form->text('app_secret','app_secret')->default('')->rules('required');
        $form->text('aes_key','aes_key')->default('')->rules('required');
//        $form->text('merchant_id','merchant_id')->default('');
//        $form->text('merchant_key','支付密码')->default('');
//        $form->text('cert_path','商户证书路径')->default('');
//        $form->text('key_path','密钥证书路径')->default('');
        $form->textarea('remark','备注')->default('');
        return $form;
    }

}
