<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include_once("function.php");
if(!FuncClient_IsLogin())
{
	FuncClient_LocationLogin();
}
?>
<HEAD>
<TITLE>欢迎使用15CDN后台管理系统</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">

<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="css/global.css" media="all">
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">

</HEAD>

<body style="line-height:0px !important;">
		<div class="layui-layout layui-layout-admin" >
			<!--head START -->
			<!-- head.php START-->
			<script language="javascript" src="../js/urlencode.js"></script> 
			<script language="javascript" src="../js/fikcdn_event.js"></script>
			<script language="javascript" src="../js/client_function.js"></script>
			<script language="javascript" src="../js/ajax.js"></script>
			<script language="javascript" src="../js/cookie.js"></script>
			<script language="javascript" src="../js/formatNumber.js"></script>
			<script language="javascript" src="../js/div.js"></script>
			<!-- head.php END-->
			<?php	
			//  文件头
			//include_once('head.php');

			//head.php START
			if(!isset($_SESSION)){  
			   session_start();  
			}
			include_once('../db/db.php');
			include_once('../function/define.php');
			include_once('../function/pub_function.php');
			include_once("function.php");

			if(!FuncClient_IsLogin())
			{
				FuncClient_LocationLogin();
			}

			//head.php END

			$fikcdn_client_nick 				=$_SESSION['fikcdn_client_nick'];
			?>
			<script type="text/javascript">	
			function FikCdn_ClientLogout(){
				var postURL="ajax_login.php?mod=login&action=logout";
				var postStr="";

				AjaxClientBasePost("login","logout","POST",postURL,postStr);
			}
			</script>
			<div top:0; class="layui-header header header-demo" style="background-color: #1aa094">
				<div class="layui-main">
					
					<!-- 菜单展开/隐藏开始 -->
					<div class="admin-login-box">
						<a class="logo"  href="#">
							<!-- 添加公司Logo或文字-->
							<span style="font-size: 22px;">
								<img alt="logo" src="../images/LOGO.png" >
							</span><br />
							
						</a>
						<div class="admin-side-toggle">
							<i class="fa fa-bars" aria-hidden="true" title="点击展开/隐藏"></i>
						</div>
					</div>
					<!-- 菜单展开/隐藏结束 -->
					
					<ul class="layui-nav admin-header-item">
						
						<li class="layui-nav-item">
							<a href="javascript:;" class="admin-header-user">
								<img src="images/0.jpg" />
								<span style="color:#000;"><?php echo $fikcdn_client_nick;   ?></span>
							</a>
							<dl class="layui-nav-child">
								<!--
								<dd>
									<a href="personal_info.html" target="right"><i class="fa fa-user-circle" aria-hidden="true"></i> 个人信息</a>
								</dd>
								<dd>
									<a href="pwd_edit.html" target="right"><i class="fa fa-gear" aria-hidden="true"></i> 密码修改</a>
								</dd>
								-->
								<dd>
									<a href="#" target="_self" onClick="FikCdn_ClientLogout();"><i class="fa fa-sign-out" aria-hidden="true"></i> 退出</a>
								</dd>
							</dl>
						</li>
					</ul>
					<!--<ul class="layui-nav admin-header-item-mobile">
						<li class="layui-nav-item">
							<a href="login.html"><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a>
						</li>
					</ul>-->
				</div>
			</div>
			<!--head END -->
			<!-- menu START	-->
			<div class="layui-side layui-bg-black" id="admin-side">
				<div class="layui-side-scroll" id="admin-navbar-side" lay-filter="side"></div>
			</div>
			<!-- menu END	-->
			<div class="layui-body" style="bottom: 0;border-left: solid 2px #1AA094;" id="admin-body">
				<div class="layui-tab admin-nav-card layui-tab-brief" lay-filter="admin-tab">
					<ul class="layui-tab-title">
						<li class="layui-this">
							<i class="fa fa-dashboard" aria-hidden="true"></i>
							<cite>欢迎使用腾正安全加速</cite>
						</li>
					</ul>
					<div class="layui-tab-content" style="min-height: 150px; padding: 5px 0 0 0;">
						<div class="layui-tab-item layui-show">
							<iframe src="main.html" name="right"></iframe>
						</div>
					</div>
				</div>
			</div>
			<div class="layui-footer footer footer-demo" id="admin-footer">
				<div class="layui-main">
					<p>&nbsp;</p>
				</div>
			</div>
			<div class="site-tree-mobile layui-hide">
				<i class="layui-icon">&#xe602;</i>
			</div>
			<div class="site-mobile-shade"></div>
			
			
			<script type="text/javascript" src="plugins/layui/layui.js"></script>
			<script type="text/javascript" src="datas/nav.js"></script>
			<script type="text/javascript" src="js/dateTime.js"></script>
			<script src="js/index.js"></script>
			
		</div>
	</body>


</html>
