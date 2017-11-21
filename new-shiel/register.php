<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>用户注册-C盾</title>
<meta name="keywords" content="要我、无限节点" />
<meta name="description" content="高防CDN，腾正科技倾力打造的新一代互联网内容分发网络。基于腾正多年的IDC经验与加速技术，拥有国内首创的流量调度技术、弱网加速技术和传统CDN无法比拟的无限节点。腰斩CDN服务价格，免费提供节点。高防CDN提供游戏下载、移动应用、视频行业、智能硬件、在线直播五大专业解决方案。" />
  
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="css/register.css" />

<script language="javascript" src="/js/urlencode.js"></script> 
<script language="javascript" src="/js/fikcdn_event.js"></script>
<script language="javascript" src="/js/client_function.js"></script>
<script language="javascript" src="/js/ajax.js"></script>
<script language="javascript" src="/js/cookie.js"></script>  
<script language="javascript" src="/js/md5.js"></script>
<script type="text/javascript">	  
function ChangeCheckCode(){
	var sHtml;
	var myDate=new Date();
	sHtml = '<img src="../function/checkcode.php?time='+myDate.getTime()+'" alt="验证码" onClick="javescript:ChangeCheckCode();" class="codeImg" style="cursor: pointer;"title="点击验证码刷新"/>';
	document.getElementById("span_check_code").innerHTML=sHtml;
	
	//document.getElementById("span_check_code").innerHTML='<img src="../function/checkcode.php" alt="验证码" height="20" width="50" />';
}
function OnRegisterUser(){
	var txtUsername	 =document.getElementById("txtUsername").value;
	var txtPasswd    =document.getElementById("txtPasswd").value;
	var txtRealname  =document.getElementById("txtRealname").value;
	var txtCompanyName  =document.getElementById("txtCompanyName").value;
	var txtRelation	 =document.getElementById("txtRelation").value;
	var txtPhone	 =document.getElementById("txtPhone").value;
	var txtQQ   	 =document.getElementById("txtQQ").value;
	var txtAddr 	 =document.getElementById("txtAddr").value;
	var txtCheckCode =document.getElementById("txtCheckCode").value;
	
	if (txtUsername.length<2 ){ 
	  	document.getElementById("tipsUsername").innerHTML="登录用户名长度至少为2";
		document.getElementById("txtUsername").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsUsername").innerHTML="";
	}

	if (txtPasswd.length<6 ){ 
	  	document.getElementById("tipsPasswd").innerHTML="密码必须大于等于6位";
		document.getElementById("txtPasswd").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsPasswd").innerHTML="";
	}	
	
	if (txtRealname.length==0 ){ 
	  	document.getElementById("tipsRealname").innerHTML="请输入用户姓名";
		document.getElementById("txtRealname").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsRealname").innerHTML="";
	}	
		
	
	if (txtPhone.length==0 ){ 
	  	document.getElementById("tipsPhone").innerHTML="请输入联系电话或手机";
		document.getElementById("txtPhone").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsPhone").innerHTML="";
	}
	
	if (txtQQ.length==0 ){ 
	  	document.getElementById("tipsQQ").innerHTML="请输入QQ号";
		document.getElementById("txtQQ").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsQQ").innerHTML="";
	}
	
	if (txtCheckCode.length==0 ){ 
	  	document.getElementById("tipsCheckCode").innerHTML="请输入验证码";
		document.getElementById("txtCheckCode").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsCheckCode").innerHTML="";
	}
	
	var postURL="./api.php?mod=user&action=register";
	var postStr="username="+UrlEncode(txtUsername)+ "&password=" + UrlEncode(hex_md5(txtPasswd)) + "&realname=" + UrlEncode(txtRealname)
			         + "&compname=" + UrlEncode(txtCompanyName) + "&relation_sale=" + UrlEncode(txtRelation)+ "&phone=" + UrlEncode(txtPhone) + "&qq=" + UrlEncode(txtQQ) +  "&addr=" + UrlEncode(txtAddr)+"&checkcode="+txtCheckCode;				 
				 
	AjaxClientBasePost("user","register","POST",postURL,postStr);
}

function FikCdn_ClientUserRegisterResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		alert("注册用户登录帐号成功。");
		location.href = "./login.php"; 
	}	
	else{
		var nErrorNo = json["ErrorNo"];
		var strErr = json["ErrorMsg"];	
	
		if(nErrorNo==30004){
			document.getElementById("tipsCheckCode").innerHTML="验证码错误";
			document.getElementById("txtCheckCode").focus();
			return false;
		}
		else if(nErrorNo==20014){
			document.getElementById("tipsUsername").innerHTML="用户帐号已经存在";
			document.getElementById("txtUsername").focus();
		}
		else
		{
			alert(strErr);
		}
	}		
}

</script>  
</head>
<body class="beg-login-bg">
<!------------------------>
<div class="beg-login-box">
			<header>
				<h1>用户注册</h1>
			</header>
			<div class="beg-login-main">
				<form name="form1" action="" class="layui-form" method="post" > <!-- 注册提交方法 -->
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">用户名</label>
						<input style="width:180px;" id="txtUsername" name="txtUsername" type="text" lay-verify="userName" autocomplete="off" placeholder="请输入用户名" class="layui-input" maxlength="64"  /><span class="input_tips_txt" id="tipsUsername" ></span>
					</div>
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">密　码</label>
						<input style="width:180px;" id="txtPasswd" name="txtPasswd" type="password" lay-verify="password" autocomplete="off" placeholder="请输入密码" class="layui-input" maxlength="32"  /><span class="input_tips_txt" id="tipsPasswd" ></span>
					</div>
					<!--<div class="layui-form-item">
						<input id="password2" type="password" name="password2" lay-verify="password2" autocomplete="off" placeholder="请输入确认密码" class="layui-input"
						 onchange="checkPwd()">
					</div>-->
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">联系人</label>
						<input style="width:180px;" id="txtRealname" name="txtRealname" type="text" lay-verify="contacter" autocomplete="off" placeholder="请输入联系人" class="layui-input" maxlength="64"  /><span class="input_tips_txt" id="tipsRealname" ></span>
					</div>
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">公　司</label>
						<input style="width:180px;" id="txtCompanyName" name="txtCompanyName" type="text" lay-verify="company" autocomplete="off" placeholder="请输入公司名称" class="layui-input" maxlength="128"  /><span class="input_tips_txt" id="tipsCompanyName" ></span>
					</div>
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">电　话</label>
						<input style="width:180px;" id="txtPhone" name="txtPhone" type="text" lay-verify="phone" autocomplete="off" placeholder="请输入联系电话" class="layui-input" maxlength="32"  /><span class="input_tips_txt" id="tipsPhone" ></span>
					</div>
					
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">业务员</label>
						<select style="width:180px;"　id="txtRelation" lay-style="width:180px;">
							 	<option value="">请选择</option>
								<?php

								include_once('../db/db.php');
								 
								 $db_link = FikCDNDB_Connect();
								 $sql="SELECT username FROM `fikcdn_admin` WHERE admin_grade=3";
								 $result = mysql_query($sql,$db_link);
								  while ( $row  =  mysql_fetch_assoc ( $result )) {
								        echo '<option>'.$row [ "username" ].'</option>';

								         
								    }

								?>
			 
						</select>
						<style>
						.layui-unselect {
							width:180px;
							float:left;
						}
						</style>
					</div>
					
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">Q　  Q</label>
						<input style="width:180px;　id="txtQQ" name="txtQQ" type="text" lay-verify="number" autocomplete="off" placeholder="请输入QQ号码" class="layui-input" maxlength="20"  /><span class="input_tips_txt" id="tipsQQ" ></span>
					</div>
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">地　址</label>
						<input style="width:180px;"id="txtAddr" name="txtAddr" type="text" autocomplete="off" placeholder="请输入联系地址" class="layui-input" maxlength="128"  /><span class="input_tips_txt" id="tipsAddr" ></span>
					</div>
					<div class="layui-form-item">
						<label style="float:left;font-size:18px;margin-right:20px;padding-top:5px;">验证码</label>
						<input style="width:100px;"id="txtCheckCode" name="txtCheckCode" type="text"  maxlength="6"  lay-verify="code" autocomplete="off" placeholder="验证码" class="layui-input codeInput"/>
						<span id="span_check_code" style="clear:both;padding-left:45px;"><img src="../function/checkcode.php" onClick="javescript:ChangeCheckCode();" alt="验证码" class="codeImg" style='cursor: pointer;'title="点击验证码刷新" /></span><span class="input_tips_txt" id="tipsCheckCode" ></span>
					
					</div>
					
					
					<div class="layui-form-item">
						<div class="beg-pull-left beg-login-remember">
							<label><a href="login.php" style="color: white">已有账号</a></label>&nbsp;&nbsp;&nbsp;&nbsp;
							<!--<label><a href="forget.html" style="color: white">忘记密码？</a></label>-->
						</div>
						<div class="beg-pull-right">
							<input name="btn_register"   type="button"  value="注册"  onClick="OnRegisterUser();" class="layui-btn layui-btn-primary" lay-submit lay-filter="login"/>

						</div>
						<div class="beg-clear"></div>
					</div>
				</form>
			</div>
		</div>
		<script type="text/javascript" src="plugins/layui/layui.js"></script>
	<script src="https://statics.dnspod.cn/yantai/js/libs/seajs/1.2.0/sea.js"></script>
<script src="https://statics.dnspod.cn/yantai/js/config.js?v=201307040122"></script>
<script>seajs.use('https://statics.dnspod.cn/yantai/js/login.js?v=201307040122');</script>	
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
						} else if(value.length < 6 || value.length > 20) {
							return '密码必须6-20位!';
						}
					},
					password2: function(value) {
						if(value == "") {
							return '请输入确认密码！';
						} else if(value.length < 6 || value.length > 20) {
							return '密码必须6-20位!';
						}
					},
          
          contacter: function(value) {
          		if(value == "") {
								return '请输入联系人！';
							}
          },
          company: function(value) {
          		if(value == "") {
								return '请输入公司名称！';
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
		
		<script>
			
				function checkForm() {
					var nPwd = form1.password.value;
					var sPwd = form1.password2.value;
					
					if(nPwd != sPwd) {
						alert("二次密码不相同!");
						form1.password2.focus();
						return false;
					}	
				}
			
				function checkPwd() {
					var nPwd = form1.password.value;
					var sPwd = form1.password2.value;
					
					if(nPwd != sPwd) {
						alert("二次密码不相同！");
						form1.password2.focus();
						return false;
					}	
					
				}
		</script>
<!------------------------->


</body>
</html>
