<?php

namespace App\Admin\Controllers;

use App\admin\Models\Administrator;
use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Hyn\Tenancy\Database\Connection;

class AuthController extends BaseAuthController
{
    /**
     * Show the login page.
     *
     * @return \Illuminate\Contracts\View\Factory|Redirect|\Illuminate\View\View
     */
    public function getLogin()
    {
//        $user = Administrator::find(1);
//        dd($user);
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
        }

        return view($this->loginView);
    }
}
