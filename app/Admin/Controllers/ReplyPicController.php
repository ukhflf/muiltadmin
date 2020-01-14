<?php

namespace App\Admin\Controllers;

use App\admin\Models\Material;
use App\admin\Models\Reply;
use App\admin\Models\Scan;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ReplyPicController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '图文消息回复';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Reply());
        $grid->model()->where('reply_type',1)->orderBy('id','desc');
        $grid->column('id', __('ID'))->sortable();
//        $grid->column('name','规则名称');
        $grid->column('trigger_keywords','回复关键字')->display(function ($value){
            $tags = explode(',',$value);
            $tagsStr = '';
            if(!empty($tags)){
                foreach ($tags as $tag){
                    $tagsStr .= "<span class='badge bg-green'>$tag</span>&nbsp;&nbsp;&nbsp;&nbsp;";
                }
            }
            return $tagsStr;
        });
        $grid->column('trigger_type','回复类型')->display(function ($value){
            switch ($value) {
                case 'subscribe':
                    return "<span class='badge bg-blue'>关注回复</span>";
                    break;
                case 'default':
                    return "<span class='badge bg-yellow'>默认回复</span>";
                    break;
                case 'keywords':
                    return "<span class='badge bg-red'>关键字回复</span>";
                    break;
                default:
                    return "<span class='badge bg-red'>关键字回复</span>";
                    break;
            }
        });
        $grid->column('material.title','回复内容');
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Reply());
        $form->text('name','规则名称')->rules('required');
        $form->tags('trigger_keywords','回复关键词')->rules('required');
        $form->radio('trigger_type','回复类型')->options(['subscribe'=>'关注回复','default'=>'默认回复','keywords'=>'图文消息回复'])->rules('required');
//        $form->textarea('content','回复内容')->rules('required');
        $form->select('material_id','回复素材')->options(Material::where('type','article')->pluck('title','id'))->rules('required');
        return $form;
    }
}
