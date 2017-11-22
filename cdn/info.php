<?php
include_once("function.php");
if (!FuncClient_IsLogin()) {
    FuncClient_LocationLogin();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    <!--    <link rel="stylesheet" href="./plugins/layui2/css/layui.css?t=1504112998306" media="all">-->
    <link rel="stylesheet" href="./plugins/layui2/css/layui.css">


    <!--    <script src="./Public/jquery/1.11.3/jquery.js"></script>-->
    <script src="./plugins/layui2/layui.all.js"></script>
</head>
<body>

<ul class="layui-nav" lay-filter="">
    <!--    <li class="layui-nav-item">概览</li>-->
    <!--    <li class="layui-nav-item layui-this"><a href="">产品</a></li>-->
    <!--    <li class="layui-nav-item"><a href="">大数据</a></li>-->
    <li class="layui-nav-item">
        <a href="javascript:;">全部项目</a>
        <dl class="layui-nav-child"> <!-- 二级菜单 -->
            <dd><a href="">项目一</a></dd>
            <dd><a href="">项目二</a></dd>
            <dd><a href="">项目三</a></dd>
        </dl>
    </li>
    <!--    <li class="layui-nav-item"><a href="">社区</a></li>-->
</ul>

<fieldset class="layui-elem-field">
    <legend>字段集区块 - 默认风格</legend>
    <div class="layui-field-box">

        <div class="layui-collapse">
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">杜甫</h2>
                <div class="layui-colla-content layui-show">内容区域</div>
            </div>
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">李清照</h2>
                <div class="layui-colla-content layui-show">内容区域</div>
            </div>
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">鲁迅</h2>
                <div class="layui-colla-content layui-show">内容区域</div>
            </div>
        </div>

    </div>
</fieldset>


<script src="./plugins/layui2/layui.all.js"></script>
<script>
    //注意：折叠面板 依赖 element 模块，否则无法进行功能性操作
    layui.use('element', function () {
        var element = layui.element;

        //…
    });
</script>

</body>
</html>