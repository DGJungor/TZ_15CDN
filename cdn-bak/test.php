<?php 
//测试页
function PubFunc_GetUrlDomain($url)
{
 	//preg_match("/[^\.\/]+\.[^\.\/]+$/", $url, $matches);
	preg_match("/^(http:\/\/)?([^\/]+)/i", $url, $matches);
	
	//print_r($matches);
	
	return $matches[2];
}

$domain = PubFunc_GetUrlDomain("http://www.15cdn.com/dl/ddd.html");

echo $domain;

?>
