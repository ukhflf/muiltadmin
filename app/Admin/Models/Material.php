<?php

namespace App\admin\Models;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Encore\Admin\Facades\Admin;

class Material extends Model
{
    use UsesTenantConnection;

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
}
