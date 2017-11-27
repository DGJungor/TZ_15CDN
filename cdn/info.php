<?php
include_once("function.php");
include_once("../config/PDO_config.php");
if (!FuncClient_IsLogin()) {
    FuncClient_LocationLogin();
}


$userItems = $_SESSION['userInfo']['userItems'];


////获取本月总流量
//$sqlMonthCount = "
//";
//
////获取本月时间戳
//$beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));

//--------------------------------打印数据

//echo '<pre>';
//var_dump($_SESSION);
//echo '</pre>';
//
//echo '<pre>';
//var_dump($sth);
////echo $beginThismonth;
//echo '</pre>';
//?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    <script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
    <!--    <link rel="stylesheet" href="./plugins/layui2/css/layui.css?t=1504112998306" media="all">-->
    <link rel="stylesheet" href="./plugins/layui2/css/layui.css">


    <!--        <script src="./Public/jquery/1.11.3/jquery.js"></script>-->
    <script src="./plugins/layui2/layui.all.js"></script>
    <script src="./js/echarts.min.js"></script>


</head>
<body>

<ul class="layui-nav" lay-filter="filter">
<!--    <li class="layui-nav-item">概览</li>-->
    <!--    <li class="layui-nav-item layui-this"><a href="">产品</a></li>-->
    <!--    <li class="layui-nav-item"><a href="">大数据</a></li>-->
    <li class="layui-nav-item">
        <a href="javascript:;">全部项目</a>
        <dl class="layui-nav-child"> <!-- 二级菜单 -->
            <?php
            $i = 0;
            foreach ($userItems as $k => $v) {

                ?>
                <dd>
                    <a href="./info_c.php?id=<?php echo $v['id'] ?>&i=<?php echo $i; ?>"><?php echo $v['name'] . '_' . $v['id']; ?></a>
                </dd>
                <?php
                $i++;
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
                                <h2>接入域名 <?php echo $_SESSION['userInfo']['cdnNum']; ?>个</h2>
                            </div>
                        </div>
                        <div class="layui-col-md6">
                            <div>
                                <h2>
                                    本月总流量 <?php echo isset($_SESSION['userInfo']['monthCount']) ? $_SESSION['userInfo']['monthCount'] : '0'; ?>
                                    G</h2>
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
                            实时宽带
                            <div id="statBW">

                            </div>
                            kbs
                        </div>
                        <div class="layui-col-md4">
                            今日流量
                            <div id="statSum">

                            </div>
                        </div>
                        <div class="layui-col-md4">
                            今日请求数量
                            <div id="statRes">

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
                <h2 class="layui-colla-title">CDN流量本月趋势</h2>
                <div class="layui-colla-content layui-show">


                    <div id="main" style="width:100%; height: 400px;"></div>


                </div>
            </div>
        </div>

    </div>


</fieldset>



<script type="text/javascript">
    //指定图标的配置和数据
    var option = {
//        title: {
//            text: '流量统计'
//        },
//        tooltip: {},
//        legend: {
//            data: ['用户来源']
//        },
//        xAxis: {
//            data: [0]
//        },
//        yAxis: {},
//        series: [{
//            name: '日流量(单位:G)',
//            type: 'line',
//            data: [' ']
//        }]

        visualMap: {
            show: false,
            type: 'continuous',
            seriesIndex: 0,
            min: 0,
            max: 300
        },


        title: {
            left: 'center',
            text: ''
        },
        tooltip: {
            trigger: 'axis'
        },
        xAxis: {
            data: [0]
        },
        yAxis: {
            splitLine: {show: false}
        },
        grid: {
            bottom: '5%'
        },
        series: {
            type: 'line',
            showSymbol: false,
            data: [' ']
        }
    };
    //初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    //使用制定的配置项和数据显示图表
    myChart.setOption(option);
</script>


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




    setTimeout("fmPost()", 100)

    function fmPost() {
//        alert("j");
//        location.reload();

        $.ajax({
            type: "POST",
            url: "./ajax_info.php",
            data: {'buy_id': <?php echo $_SESSION['userInfo']['buy_id'] ?>, 'action': 'bandwidth'},
            dataType: "json",
            success: function (msg) {
//                console.log(msg.msgBW);
                var msgBW = msg.msgBW
                $("#statBW").html(msgBW);


            },
        }),

            $.ajax({
                type: "POST",
                url: "./ajax_info.php",
                data: {'buy_id': <?php echo $_SESSION['userInfo']['buy_id'] ?>, 'action': 'Count'},
                dataType: "json",
                success: function (msg) {
//                    console.log(msg);
                    var msgSum = msg.msgSum
                    var msgSumRes = msg.msgSumRes
//                console.log(msgSum)
                    $("#statSum").html(msgSum);
                    $("#statRes").html(msgSumRes);

                },
            }),


            $.ajax({
                type: "POST",
                url: "./ajax_info.php",
//                url: "./info_stat.php",
                data: {'buy_id': <?php echo $_SESSION['userInfo']['buy_id'] ?>, 'action': 'graphData'},
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    myChart.setOption({
                        xAxis: {
                            data:data.date
                        },
                        series: [{
                            // 根据名字对应到相应的系列
                            name: '日流量(G)',
                            data:data.sum
                        }]
                    });


                },
            }),


            setTimeout("fmPost()", 800)
    }







    //    setTimeout("fmPost()",100)
    //    function fmPost(){alert("j");
    //        location.reload();
    //
    //    }
</script>



</body>
</html>


<!--<div class="ibox-content">-->
<!--    <h1 class="no-margins">40 886,200</h1>-->
<!--    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i>-->
<!--    </div>-->
<!--    <small>总收入</small>-->
<!--</div>-->