<?php

namespace App\admin\Models;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use App\admin\Models\Account;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Log;
use App\Events\ProducerCreate;

class Reply extends Model
{
    use UsesTenantConnection;
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        static::saving(function($model){
            $uid = Admin::user()->id;
            $account = Account::where('user_id',$uid)->first();
            $accountId = $account->id;
            $model->account_id = $accountId;
        });
    }

    /**
     * 关联素材
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function material(){
        return $this->hasOne(Material::class,'id','material_id');
    }

    /**
     * @param $content 关键字内容
     * @param $openid 回复用户openid
     * @return bool
     */
    public static  function sendCustomerServiceMessageToUser($content,$openid){
        try{
            $reply = Reply::whereRaw("FIND_IN_SET('".$content."',trigger_keywords)")->orderBy('id','desc')->first();
            $event = new ProducerCreate($reply,$openid); //事件
            event(ProducerCreate::class,$event); //手动触发事件,并且监听器是一个队列处理，在监听器中有handle,直接在handle中进行业务逻辑的处理
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }

}
