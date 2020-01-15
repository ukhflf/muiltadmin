<?php

namespace App\Listeners;

use App\Events\ProducerCreate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use EasyWeChat\Factory;
use App\admin\Models\Account;

class WechatMessageListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProducerCreate  $event
     * @return void
     */
    public function handle(ProducerCreate $event)
    {
        //进行客服消息回复
        $message = '';//字符
        $message = htmlspecialchars_decode(urldecode($event->reply['content']));
//        $app = app('wechat.official_account');
        $config = Account::getAccountConfigByToken($event->token);
        $app = Factory::officialAccount($config);
        $app->customer_service->message($message)->to($event->openid)->send();
        Log::error('我执行了！');
        Log::error($event->reply['content']);
    }
}
