<?php

namespace App\Http\Controllers;

use App\admin\Models\Account;
use App\admin\Models\AdminUser;
use App\admin\Models\Menu;
use App\admin\Models\Reply;
use App\Events\ProducerCreate;
use Encore\Admin\Facades\Admin;
use EasyWeChat\Factory;

class WechatController extends Controller
{
    /**
     * 微信公众号设置消息发送回调接口
     * @descritpion ''
     * @author zdk 317583717@qq.com
     * @return mixed
     */
    public function serve($token){
//      $app = app('wechat.official_account');//@todo 处理根据帐户取得配置信息，再处理成扫码获取用户的信息
//      $config = config('wechat.official_account.default');

      $config = Account::getAccountConfigByToken();
      $app = Factory::officialAccount($config);
      $app->server->push(function ($message) {
          switch ($message['MsgType']) {
              case 'event':
//                  return '收到事件消息';
                  return '';
                  break;
              case 'text':
                  $content = $message['content'];
                  $openid = $message['FromUserName'];
                    //处理文字回复
                    //其它事件处理成空返回
//                  return '收到文字消息';
                  $result = Reply::sendCustomerServiceMessageToUser($content,$openid);
                  return '';
                  break;
              case 'image':
//                  return '收到图片消息';
                  return '';
                  break;
              case 'voice':
//                  return '收到语音消息';
                  return '';
                  break;
              case 'video':
//                  return '收到视频消息';
                  return '';
                  break;
              case 'location':
//                  return '收到坐标消息';
                  return '';
                  break;
              case 'link':
//                  return '收到链接消息';
                  return '';
                  break;
              case 'file':
//                  return '收到文件消息';
                  return '';
              // ... 其它消息
              default:
//                  return '收到其它消息';
                  return '';
                  break;
          }
      });
      $response = $app->server->serve();
      return $response;
    }

    /**
     * 获取菜单
     */
    public function getMenu(){
        $app = app('wechat.official_account');
        $list = $app->menu->list();
        dd($list);
    }

    /**
     * 创建菜单
     */
    public function createMenu(){
        $app = app('wechat.official_account');
        $uid = Admin::user()->id;
        $account = Account::where('user_id',$uid)->first();
        $accountId = $account->id;
        $menu = Menu::where('account_id',$accountId)->first();
        $datas = json_decode($menu->menus,true);
        $buttons = $datas['button'];
//        dd($account->menus);
//         $menuJson = '[{"name": "跳转链接", "sub_button": [{"key": "send", "name": "事件推送", "type": "click"}]}, {"key": "scan", "name": "事件推送", "sub_button": [{"url": "http://www.baidu.com", "name": "跳转链接", "type": "view"}]}]';
//         $buttons = json_decode($menuJson,TRUE );
         $data = $app->menu->create($buttons);
         dd($data);
    }

    /**
     * 测试消息回复队列
     */
    public function testSend(){
        $content = '红包';
        $openid = 'oeEzZwMIYHK1dU4BYQFvQw71jVlE';
//        $reply = Reply::whereRaw("FIND_IN_SET('".$content."',trigger_keywords)")->orderBy('id','desc')->first();
//        $event = new ProducerCreate($reply,$openid); //事件
//        event(ProducerCreate::class,$event); //手动触发事件,并且监听器是一个队列处理，在监听器中有handle,直接在handle中进行业务逻辑的处理
        $result = Reply::sendCustomerServiceMessageToUser($content,$openid);
        dd($result);
    }



}
