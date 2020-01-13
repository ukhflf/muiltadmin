<?php

namespace App\admin\Models;

use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Menu extends Model
{
    use UsesTenantConnection;

    protected $casts = [
        'Menu' => 'json', // 声明json类型
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $menus = $model->menus;
            $menusJson = json_decode($menus);
            $menusButton =$menusJson->menu;
            $model->menus = json_encode($menusButton);
            $accountId = 0;
            $uid = Admin::user()->id;
            $account = Account::where('user_id',$uid)->first();
            $accountId = $account->id;
            $model->account_id = $accountId;
        });
    }



}
