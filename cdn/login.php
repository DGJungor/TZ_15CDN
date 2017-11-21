<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">

<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>登陆到管理系统</TITLE>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="css/login.css" />
</HEAD>

<body class="beg-login-bg">
<script language="javascript" src="../js/urlencode.js"></script> 
<script language="javascript" src="../js/ajax.js"></script>
<script language="javascript" src="../js/cookie.js"></script>
<script language="javascript" src="../js/client_function.js"></script>
<script language="javascript" src="../js/md5.js"></script>
<script type="text/javascript">	
function login(){
	var username=document.getElementById("txtUsername").value;
	var password=document.getElementById("txtPassword").value;
	var txtCheckCode=document.getElementById("txtCheckCode").value; 
	document.getElementById("tipsLoginResult").innerHTML ="";
	if (username.length==0 ){ 
	  	//document.getElementById("tipsUsername").innerHTML="请输入登录用户名";
		document.getElementById("txtUsername").focus();
	  	return false;
	}
	
	if (password.length==0 ){ 
	  	//document.getElementById("tipsPasswd").innerHTML="请输入登录密码";
		document.getElementById("txtPassword").focus();
	  	return false;
	}	
	
	if (txtCheckCode.length==0 ){ 
	  	//document.getElementById("tipsCheckCode").innerHTML="请输入验证码";
		document.getElementById("txtCheckCode").focus();
	  	return false;
	}	
	
	var postURL="ajax_login.php?mod=login&action=logging";
	var postStr="username="+ UrlEncode(username) + "&password=" + UrlEncode(hex_md5(password))+"&code="+txtCheckCode;

	AjaxClientBasePost("login","logging","POST",postURL,postStr);
}

function ChangeCheckCode(){
	var sHtml;
	var myDate=new Date();
	sHtml = '<img src="../function/checkcode.php?time='+myDate.getTime()+'" alt="验证码" class="codeImg" onclick="javescript:ChangeCheckCode();" />';
	document.getElementById("span_check_code").innerHTML=sHtml;
	
	//document.getElementById("span_check_code").innerHTML='<img src="../function/checkcode.php" alt="验证码" height="20" width="50" />';
}

</script>

<?php
$ip = $_SERVER['REMOTE_ADDR'];
//echo $ip;
	include_once('../config/config_global.php');
	
	$client_username 	=$_COOKIE['fikcdn_client_username'];
?>
		<div class="beg-login-box">
			<header>
				<h1>用户登录</h1>
			</header>
			<div class="beg-login-main">
				<form action="" class="layui-form" method="post"> <!-- 登录提交方法 -->
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">用户名</label>
						<input style="width:180px;" id="txtUsername" name="txtUsername" type="text" lay-verify="userName" autocomplete="off" placeholder="用户名" class="layui-input" size="26" maxlength="64" value="<?php echo $client_username; ?>" >
					</div>
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">密　码</label>
						<input style="width:180px;" id="txtPassword" name="txtPassword" type="password" lay-verify="password" autocomplete="off" placeholder="密码" class="layui-input" size="26" maxlength="64">
                        <!--<span class="login_tips_txt" id="tipsPasswd" name="tipsPasswd"></span>-->
					</div>
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">验证码</label>
						<input style="width:100px;" id="txtCheckCode" name="txtCheckCode" type="text" size="5" maxlength="6" lay-verify="code" autocomplete="off" placeholder="验证码" class="layui-input codeInput"/>
						<span id="span_check_code" style="clear:both;padding-left:45px;"><img src="../function/checkcode.php" alt="验证码" class="codeImg" onclick="javescript:ChangeCheckCode();"/></span>
                        <!--<span class="login_tips_txt" id="tipsCheckCode" name="tipsCheckCode"></span>-->
						<span class="login_tips_txt" id="tipsLoginResult" style="float: left;color: red"></span>
					</div>
					
					<div class="layui-form-item">
						<div class="beg-pull-left beg-login-remember">
							<label><a href="register.php" style="color: white">用户注册</a></label>&nbsp;&nbsp;&nbsp;&nbsp;
							<!--<label><a href="forget.html" style="color: white">忘记密码？</a></label>-->
						</div>
							<div class="beg-pull-right">
							<input name="btn_login" type="button" lay-submit lay-filter="login" class="layui-btn layui-btn-primary" id="btn_login" value="登 陆" onClick="login();" style="cursor:pointer;" />

							
						</div>
						<div class="beg-clear"></div>
					</div>
				</form>
			</div>
		</div>
		<script type="text/javascript" src="plugins/layui/layui.js"></script>
		
		<script>
			layui.use(['form', 'layedit', 'laydate'], function() {
				var form = layui.form(),
					layer = layui.layer,
					layedit = layui.layedit,
					laydate = layui.laydate;

				
				//自定义验证规则
				form.verify({
					userName: function(value) {
						if(value == "") {
							return '请输入用户名！';
						}
					},				
					password: function(value) {
						if(value == "") {
							return '请输入密码！';
						}
					},
					code: function(value) {
						if(value == "") {
							return '请输入验证码！';
						}
					}
					
				});

			});

		</script>

						
<script type="text/javascript">

document.getElementById('txtUsername').onkeyup = function(e){
	var e = e || window.event;
	if(e.keyCode == 13){
		login(); 
	}	
	else{
		var username=document.getElementById("txtUsername").value;
		if (username.length>0 ){ 
			document.getElementById("tipsUsername").innerHTML="";
		}
	}
};

document.getElementById('txtPassword').onkeyup = function(e){
	var e = e || window.event;
	if(e.keyCode == 13){
		login();
	}	
	else{	
		var password=document.getElementById("txtPassword").value;
		if (password.length>0 ){ 
			document.getElementById("tipsPasswd").innerHTML="";
		}
	}
};

document.getElementById('txtCheckCode').onkeyup = function(e){
	var e = e || window.event;
	if(e.keyCode == 13){
		login();
	}	
	else{	
		var password=document.getElementById("txtCheckCode").value;
		if (password.length>0 ){ 
			document.getElementById("tipsCheckCode").innerHTML="";
		}
	}
};

</script>

</body>
</html>