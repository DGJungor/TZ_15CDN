<?php

include_once("function.php");
include_once("../config/PDO_config.php");
include_once('../function/pub_function.php');
if (!FuncClient_IsLogin()) {
    FuncClient_LocationLogin();
}


//var_dump($_POST['buy_id']);
$buy_id = $_POST['buy_id'];

$ajaxPDO = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWD);


switch ($_POST['action']) {
    case 'bandwidth':
        //获取5秒前的时间戳
        $time5Ago = strtotime('-5 seconds');
        $sqlBW    = "
SELECT
domain_stat_product_bandwidth.bandwidth_down,
domain_stat_product_bandwidth.id,
domain_stat_product_bandwidth.bandwidth_up,
domain_stat_product_bandwidth.time
FROM
domain_stat_product_bandwidth
WHERE
domain_stat_product_bandwidth.buy_id = '$buy_id' AND 
domain_stat_product_bandwidth.time >= '$time5Ago'
ORDER BY
domain_stat_product_bandwidth.time DESC
LIMIT 1

";
        $sthBW    = $ajaxPDO->query($sqlBW);

        $sth = $sthBW->fetchAll(PDO::FETCH_ASSOC);

        $msgBW = $sth[0]['bandwidth_down'] + $sth[0]['bandwidth_up'];

        $msg['msgBW'] = $msgBW;

        echo json_encode($msg);
        break;
    case 'Count':
        //获取今日起始时间的时间戳
        $beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        $sqlSum  = "
SELECT
domain_stat_product_bandwidth.down_increase,
domain_stat_product_bandwidth.up_increase,
domain_stat_product_bandwidth.RequestCount_increase
FROM
domain_stat_product_bandwidth
WHERE
domain_stat_product_bandwidth.buy_id = '$buy_id' AND
domain_stat_product_bandwidth.time >= '$beginToday' 
";
        $sthSum  = $ajaxPDO->query($sqlSum);
        $sthSum2 = $sthSum->fetchAll(PDO::FETCH_ASSOC);

//        var_dump($sthSum2);
//        echo PubFunc_KBToString($sthSum2[0]['down_increase']);

//        echo '----------------------';
        $sum    = 0;
        $sumRes = 0;
        foreach ($sthSum2 as $k => $v) {
            $sum    = $sum + $v['down_increase'];
            $sum    = $sum + $v['up_increase'];
            $sumRes = $sumRes + $v['RequestCount_increase'];
        }
        $sumToMB          = PubFunc_KBToString($sum);
        $msg['msgSum']    = $sumToMB;
        $msg['msgSumRes'] = $sumRes;

        echo json_encode($msg);
        break;
    case 3:
        echo "";
        break;
    default:
        echo "";
}
















