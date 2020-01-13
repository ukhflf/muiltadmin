<?php

namespace App\Admin\Controllers;

use App\admin\Models\Account;
use App\admin\Models\Menu;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class SetMenuController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '公众号菜单设置';

    public function index(Content $content)
    {
        $menuInfo = Menu::find(1);
        if(empty($menuInfo)){
            return $content
                ->header('公众号菜单设置')
                ->description('公众号菜单设置')
                ->body($this->form(0));
        }else{
            return $content
                ->header('公众号菜单设置')
                ->description('公众号菜单设置')
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
        $form = new Form(new Menu());
        if($sign==0){
            $form->setAction('set-menu');
        }else{
            $form->setAction('set-menu/1');
        }
//        $form->display('id', __('ID'))->default($id);
        $form->hidden('id','id')->default(1);
        $form->wxmenu('menus');
        return $form;
    }
}
