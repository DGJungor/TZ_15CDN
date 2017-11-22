<?php
include_once("function.php");
include_once("../config/PDO_config.php");
if (!FuncClient_IsLogin()) {
    FuncClient_LocationLogin();
}
echo '<pre>';
var_dump($_SESSION);
echo '</pre>';
//die();
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

$_SESSION['userInfo']['id'] = $userItems[0]['id'];
$_SESSION['userInfo']['name'] = $userItems[0]['name'].'_'.$userItems[0]['id'];

foreach ($userItems as $k => $v) {
    echo $v['name'].'_'.$v['id'];

}

$buyID = $_SESSION['userInfo']['id'];
$buyID = 21;


$sqlDNSNum = "SELECT
count(*)
FROM
fikcdn_buy ,
fikcdn_domain
WHERE
fikcdn_domain.buy_id = '$buyID'
";

$sthDNS = $userPDO->query($sqlDNSNum);
//$aa = $sth->execute();
$sth = $sthDNS->fetchAll(PDO::FETCH_ASSOC);
$dnsNum = $sth[0]['count(*)'];
echo '<pre>';
var_dump($sth);
echo $sth[0]['count(*)'];
echo '</pre>';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


<!--    <script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>-->
    <!--    <link rel="stylesheet" href="./plugins/layui2/css/layui.css?t=1504112998306" media="all">-->
    <link rel="stylesheet" href="./plugins/layui2/css/layui.css">


    <!--    <script src="./Public/jquery/1.11.3/jquery.js"></script>-->
    <script src="./plugins/layui2/layui.all.js"></script>


</head>
<body>

<ul class="layui-nav" lay-filter="filter">
    <li class="layui-nav-item">概览</li>
    <!--    <li class="layui-nav-item layui-this"><a href="">产品</a></li>-->
    <!--    <li class="layui-nav-item"><a href="">大数据</a></li>-->
    <li class="layui-nav-item">
        <a href="javascript:;">全部项目</a>
        <dl class="layui-nav-child"> <!-- 二级菜单 -->
            <?php
            foreach ($userItems as $k => $v) {
                ?>
                <dd><a href="./info_c.php?c=<?php echo $v['id'] ?>"><?php echo $v['name'].'_'.$v['id']; ?></a></dd>
            <?php
            }
            ?>


        </dl>
    </li>
    <!--    <li class="layui-nav-item"><a href="">社区</a></li>-->
</ul>


<!--<div id="aaa"></div>-->

<fieldset class="layui-elem-field" style="margin-top: 60px;">
    <legend id="aaa"><?php echo $_SESSION['userInfo']['name'] ?></legend>
    <div class="layui-field-box">

        <div class="layui-collapse">
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">我的服务</h2>
                <div class="layui-colla-content layui-show">
                    <div class="layui-row">
                        <div class="layui-col-md6">
                            <div>
                                <h2>接入域名  <?php echo $sth[0]['count(*)'];  ?>个</h2>
                            </div>
                        </div>
                        <div class="layui-col-md6">
                            <div>
                                <h2>本月总流量</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="layui-field-box">

        <div class="layui-collapse">
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">今日数据</h2>
                <div class="layui-colla-content layui-show">

                    <div class="layui-row">

                        <div class="layui-col-md4">
                            你的内容 9/12
                        </div>
                        <div class="layui-col-md4">
                            你的内容 9/12
                        </div>
                        <div class="layui-col-md4">
                            你的内容 9/12
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>


    <div class="layui-field-box">

        <div class="layui-collapse">
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">CDN流量本月趋势</h2>
                <div class="layui-colla-content layui-show">内容区域</div>
            </div>
        </div>

    </div>


</fieldset>


<script src="./plugins/layui2/layui.all.js"></script>
<script>
    //注意：折叠面板 依赖 element 模块，否则无法进行功能性操作
    layui.use(['element', 'layer'], function () {
        var element = layui.element
            , layer = layui.layer;


        element.on('nav(filter)', function (elem) {
            console.log(elem)
            console.log(elem.context.innerText); //得到当前点击的DOM对象
            var fTitle = elem.context.innerText
//            layer.msg('asdfa');
            document.getElementById('aaa').innerHTML = fTitle;

        });

        //…
    });


</script>

</body>
</html>


<div class="ibox-content">
    <h1 class="no-margins">40 886,200</h1>
    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i>
    </div>
    <small>总收入</small>
</div>