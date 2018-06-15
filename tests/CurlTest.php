<?php
/**
 * Created by PhpStorm.
 * curl测试
 * User: sunhuanzhi
 * Date: 2018/6/4
 * Time: 16:45
 */

require_once "../vendor/autoload.php";

use sunxiaozhi\library\curl\Curl;

$url = 'www.baidu.com';
$curl = new Curl();
$return = $curl->get($url);

var_dump($return);