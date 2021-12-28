<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

require("vendor/autoload.php");


try {
    \Zf\Wechat\Wechat::getInstance()->run();
}
catch (\Exception $e) {
    \Zf\Helper\FileHelper::putContent("runtime-index", print_r($e, true));
}
