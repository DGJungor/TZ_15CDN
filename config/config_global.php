<?php

//配置数组
$_config = array();

// ----------------------------  CONFIG DB  ----------------------------- //
$_config['db']['1']['dbhost'] = '127.0.0.1:8816';
$_config['db']['1']['dbuser'] = 'root';
$_config['db']['1']['dbpw'] = '';
$_config['db']['1']['dbcharset'] = 'utf8';
$_config['db']['1']['pconnect'] = '0';
$_config['db']['1']['dbname'] = 'fikcdn';
$_config['db']['1']['tablepre'] = 'fikcdn_';


$FikCdnCookiePaht	= "/";

$StatData_KeepDay = 7;
$FikConfig_IsUserCheckCode	= true;
$FikConfig_TaskIsLocalRun = true;

$FikConfig_KeeperLogin = false;
$FikConfig_IsCDNDemo = false;

// 是否开放用户注册功能
$FikConfig_AllowRegister = true;


//添加以下内容
//cloudxns config
$xns['api']='da0af62d14d9fe3bcdff1977dfd1b740';   //cloudxns api
$xns['key']='5eaa14456dc345c1';   //cloudxns key
$xns['domainid']='303551';   //cloudxns  域名的ID
$xns['domainname']='fcdun.com';  //域名
function generate_code( $length = 8 ) {    //这个是生成随机字符的
	$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
	$code = '';
	for ( $i = 0; $i < $length; $i++ )
	{
		$code .= $chars[ mt_rand(0, strlen($chars) - 1) ];
	}
	return $code;
}
?>
