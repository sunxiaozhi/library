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

var_dump($return);exit;
/* $params = array(
	'token' => md5('LuShang2017+'.'getLstUserInfo+'.'getLstUserInfo'),
	'request_object' => 'lushang',
	'server' => 'getLstUserInfo',
	'action' => 'getLstUserInfo',
	'params' => array(
		'user_id' => '1201',
		'mobile' => '18653138616'
	),
);

$json = json_encode($params);

$arr = array(
	'json' => $json,
);

//$url = 'http://192.168.103.62:8000/index.php/AppapiNew/index';
$url = 'http://lst.yinzuo100.com/index.php/AppapiNew/index';
$curl = new Curl();
$return = $curl->post($url,$arr); */

$mobile_arr = [
	'18769753333',
'15095092536',
'18615668725',
'15954483109',
'13668818707',
'13589132646',
'16065615555',
'13793192988',
'15953598988',
'15065615555',
'13793661667',
'13616405372',
'18660413090',
'15505413090',
'13953133030',
'13780817008',
'13953366665',
'14780817008',
'13615369600',
];

$zong = count($mobile_arr);
$zhuce_count = 0;

foreach($mobile_arr as $val) {
	$msg = '未注册';
	
	$data = [
		'mobile' => $val
	];
	
	$url = 'http://lst.yinzuo100.com/index.php/Share/checkUser';
	$curl = new Curl();
	$return = $curl->post($url, $data);
	
	$return_arr = json_decode($return,true);
	
	if ($return_arr['status'] == 0){
		$zhuce_count++;
		$msg = '已注册';
	}
	
	//echo $val;
	//$msg = $return_arr['status'] == 0 ? '已注册' : "未注册";
	echo $val . '&nbsp;&nbsp;&nbsp;&nbsp;' . $msg . '<br>';
}

echo '总数：' . $zong . '<br>';
echo '注册成功：' . $zhuce_count;



