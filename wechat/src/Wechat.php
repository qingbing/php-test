<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Wechat;

use Zf\Helper\Abstracts\Singleton;

class Wechat extends Singleton
{
    /**
     * @var string 首次配置时填写的token字符串
     */
    public    $configToken = 'qingbing-test';
    public    $appId       = 'wxf9661570cc5819d3';
    public    $appSecret   = '0a36801f7dc4b4b7f3d97a74bb927d0a';
    protected $app;

    protected function init()
    {
        $this->app = \EasyWeChat\Factory::officialAccount([
            'app_id' => $this->appId,
            'secret' => $this->appSecret,
        ]);
    }

    public function run()
    {
        if (isset($_GET['echostr'])) {
            $this->checkSignature();
            exit;
        }
        $this->app->server->push(function ($message) {
            \Zf\Helper\FileHelper::putContent("runtime/message.txt", print_r($message, true));
            switch ($message['MsgType']) {
                case 'event':
                    \Zf\Helper\FileHelper::putContent("runtime/event.txt", print_r($message, true));
                    break;
                case 'text':
                    \Zf\Helper\FileHelper::putContent("runtime/text.txt", print_r($message, true));
                    break;
            }
        });
        $response = $this->app->server->serve();
        $response->send();
    }

    /**
     * 一次性使用归属验证
     *
     * @param $token
     * @return bool
     */
    protected function checkSignature()
    {
        $tmpArr = array($this->configToken, $_GET["timestamp"], $_GET["nonce"]);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        \Zf\Helper\FileHelper::putContent("runtime/echostr.txt", print_r($_GET['echostr'], true));
        if ($tmpStr == $_GET["signature"]) {
            echo $_GET['echostr'];
        } else {
            return false;
        }
    }
}