<?php

namespace App\admin\Models;

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


}
