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
$buyID          = $_SESSION['userInfo']['buy_id'];
//$buyID          = 175;
//echo $buyID;

$statPDO = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWD);

$statSql = "
SELECT
domain_stat_product_day.buy_id,
domain_stat_product_day.time,
domain_stat_product_day.RequestCount,
domain_stat_product_day.UploadCount,
domain_stat_product_day.DownloadCount
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

//echo '<pre>';
//var_dump($statSth);
//echo '</pre>';


$i = 0;
foreach ($statSth as $k => $v) {

    $data['date'][$i] = date("m-d", $v['time']);
    $sum              = $v['DownloadCount'] + $v['UploadCount'];
    $data['sum'][$i]  = $sum;
    $i++;

}


echo json_encode($data);





//echo '&nbsp'.$sum.'&nbsp';


//$data['stat']['x'];
//
//echo '<pre>';
//var_dump($statSth);
//echo '</pre>';