<?php

include_once("function.php");
include_once("../config/PDO_config.php");
if (!FuncClient_IsLogin()) {
    FuncClient_LocationLogin();
}



$client_username = $_SESSION['fikcdn_client_username'];
$userPDO = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWD);
//$sql = "SELECT count(*) FROM fikcdn_buy WHERE username='$client_username';";
//$sql = "SELECT * FROM fikcdn_buy b JOIN IN fikcdn_product p ON b.product_id=p.id WHERE  b.username='$client_username' ";
$sql = "SELECT
fikcdn_product.`name`,
fikcdn_buy.id
FROM
	fikcdn_buy,
	fikcdn_product
WHERE
fikcdn_buy.product_id = fikcdn_product.id 
AND 
fikcdn_buy.username='$client_username'
 ";
//$sql = "SELECT * FROM fikcdn_buy WHERE username='$client_username'  ";
$sth = $userPDO->query($sql);
//$aa = $sth->execute();
$userItems = $sth->fetchAll(PDO::FETCH_ASSOC);

if(empty($_GET['i']))
{
    $_SESSION['userInfo']['buy_id'] = $userItems[0]['id'];
    $_SESSION['userInfo']['name'] = $userItems[0]['name'] . '_' . $userItems[0]['id'];
    $_SESSION['userInfo']['userItems'] = $userItems;

}else{
    $_SESSION['userInfo']['buy_id'] = $userItems[$_GET['i']]['id'];
    $_SESSION['userInfo']['name'] = $userItems[$_GET['i']]['name'] . '_' . $userItems[$_GET['i']]['id'];
    $_SESSION['userInfo']['userItems'] = $userItems;
}



//foreach ($userItems as $k => $v) {
//    echo $v['name'] . '_' . $v['id'];
//
//}

if(empty($_GET['id']))
{
    $buyID = $_SESSION['userInfo']['buy_id'];

}else{
    $buyID = $_GET['id'];

}





$sqlDNSNum = "SELECT
count(*)
FROM
fikcdn_buy b
left join  fikcdn_domain d on b.id = d.buy_id
WHERE
d.buy_id = '$buyID'
";

$sthDNS = $userPDO->query($sqlDNSNum);
//$aa = $sth->execute();
$sth = $sthDNS->fetchAll(PDO::FETCH_ASSOC);
$dnsNum = $sth[0]['count(*)'];
$_SESSION['userInfo']['cdnNum'] = $sth[0]['count(*)'];


//-------------------------------------------获取本月总流量


//获取本月时间戳
$beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));

$sqlStatMonth = "
SELECT
domain_stat_month.id,
domain_stat_month.domain_id,
domain_stat_month.time,
domain_stat_month.UploadCount,
domain_stat_month.DownloadCount
FROM
domain_stat_month
WHERE
domain_stat_month.buy_id = '$buyID' AND
domain_stat_month.time = '$beginThismonth'
";
$sthStatMonth = $userPDO->query($sqlStatMonth);
//$aa = $sth->execute();
$sth = $sthStatMonth->fetchAll(PDO::FETCH_ASSOC);
foreach ($sth as $k=>$v){
    $sum+=$v['UploadCount'];
    $sum+=$v['DownloadCount'];
}
$_SESSION['userInfo']['monthCount'] = $sum;
echo $_SESSION['userInfo']['monthCount'];



//---------------------------------------------------------今日数据


//---------实时宽带






//--------------------------------打印数据

//$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
//$aa = strtotime('-5 seconds');
//
//echo $aa;
//echo $bb;
////echo $beginToday;
//echo '<pre>';
//var_dump($sth);
//var_dump($_SESSION);
//
//echo '</pre>';
//
//echo '<pre>';
//var_dump($sth);
//echo $beginThismonth;
//
//var_dump($_GET['id']);
//echo '</pre>';



Header("Location: ./info.php");


?>