<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

require("vendor/autoload.php");

\Zf\Wechat\Wechat::checkSignature('qingbing-test'); exit;


exit;


$options = [
    'app_id' => 'wxf9661570cc5819d3',
    'secret' => '0a36801f7dc4b4b7f3d97a74bb927d0a',
];


$app = \EasyWeChat\Factory::officialAccount($options);

$server = $app->server;
$user   = $app->user;

$server->push(function ($message) use ($user) {
    $fromUser = $user->get($message['FromUserName']);

    return "{$fromUser->nickname} 您好！欢迎关注 TEST!";
});

$server->serve()->send();

