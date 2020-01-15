<?php

namespace App\admin\Models;

use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Account extends Model
{
    use UsesTenantConnection;

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $accountInfo = Account::find(1);
            $data = [];
            if(empty($accountInfo)){
                $token = Account::genrateToken();
                $model->token = $token;
                $model->id = 1;
            }
        });
    }

    /**
     * 生成公众号token
     * @return string
     */
    public static function genrateToken(){
        $token = 'token';
        $now = date('Y-m-d H:i:s');
        $token.= $now;
        $random = rand(1,999999999);
        $token.=$random;
        return md5($token);
    }

    /**
     * 根据当前管理员信息取得当前帐户的公众号配置
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function getAccountConfigByToken($token){
        $account = self::where('token',$token)->orderBy('id','desc')->first();
        if(empty($account)){
            $config = config('wechat.official_account.default');
        }else{
            $config['app_id'] = $account['app_id'];
            $config['secret'] = $account['app_secret'];
            $config['token'] = $account['token'];
            $config['aes_key'] = $account['aes_key'];
        }
        return $config;
    }


}
