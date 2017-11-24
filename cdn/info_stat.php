<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/24
 * Time: 16:26
 */


include_once("function.php");
include_once("../config/PDO_config.php");
include_once('../function/pub_function.php');
if (!FuncClient_IsLogin()) {
    FuncClient_LocationLogin();
}


//获取本月开始时间戳
$beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));

$buyID = $_SESSION['userInfo']['buy_id'];


$statPDO = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWD);

$statSql = "
SELECT
domain_stat_product_day.DownloadCount,
domain_stat_product_day.UploadCount,
domain_stat_product_day.time,
domain_stat_product_day.id
FROM
domain_stat_product_day
WHERE
domain_stat_product_day.buy_id = '$buyID' AND
domain_stat_product_day.time >= '$beginThismonth'
ORDER BY
domain_stat_product_day.time ASC

";
$statSth = $statPDO->query($statSql);
$statSth = $statSth->fetchAll(PDO::FETCH_ASSOC);

foreach ($statSth as $k=>$v) {
//    echo $v['time'];
    echo  date("Y-m-d",$v['time']);

}


//$data['stat']['x'];

echo '<pre>';
var_dump($statSth);
echo '</pre>';