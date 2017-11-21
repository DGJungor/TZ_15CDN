<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">

<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>登陆到 15CDN 管理系统</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="15CDN 后台管理系统" />
<meta name="keywords" content="15CDN 后台管理系统" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #1D3647;
}
-->
.navtopbox{ width:100%; background-color:#333333;font-size:14px;height: 28px;}
.navtop{position: absolute;right: 22%; }
.navtop ul li{float:left;height:28px;line-height:28px;padding-right:15px;text-align:center;}
.navbox{ width:100%;background-color:#000;position:absolute
 ;background-color:rgba(0,0,0,0.4);  }
 .nav{width:1024px; height:80px; margin:0 auto;}
 .nav .navlogo{ padding-top:10px;float:left;display:inline-block;}
 .nav .navinfo{ display:inline-block;height:80px;margin-left:150px;vertical-align:middle;]}
.navinfo  ul li{ display:inline-block;font-size:16px;position:relative;vertical-align:middle; }
.navinfo  ul li a{color:#fff;display:inline-block;font-size:18px;line-height:80px;outline:0 none;padding:0 15px;transition:background-color 0.2s ease 0s;}
.navinfo  ul li a:hover { height: 77px; border-bottom: 3px solid #4074e1;}
#footer{ height:370px; clear:both;}
#footer p{ margin:0;}
#footer{ color:#FFF; font-family:"Microsoft YaHei"; font-size:14px;}
/* #footer img{ display:block;} */
#footer a{text-decoration: none;color: #fff;}

.footboxb{  background-color:#30323a;height: 290px;}
.footboxjuzhong{margin:0 auto; width: 1155px; }
.footboxx{
	float: left; 
	margin-top: 30px;
	margin-left: 0px;
}
.footboxx dt{ color:#5881eb; font-size:18px; font-weight:bold; padding-bottom:10px;}
.footboxx dl{ float:left; padding-left:25px; padding-right:25px;}
.footboxx dd{ padding-top:5px; padding-bottom:5px;margin: 0;}
.logo{float:left;padding-top:160px; }
.footboxright{
	float: left;
	margin-top: 30px;
	margin-left: 80px;
}
.column span,.column2 span,.column3 span{ font-weight:bold; font-size:18px;}
.column p,.column2 p,.column3 p{
	padding-top: 5px;
	padding-bottom: 5px;
}
.column img{ float:left;}
.column span{ color:#5881eb;}
.column .column_content1{ margin-left:30px; }
.column2 img{ float:left;}
.column2 span{ color:#5881eb;}
.column_content2{ margin-left:30px; }
.column3 img{
	float: left;
	padding-top: 5px;
}
.column3 span{ color:#efbd04;}
.column_content3{ margin-left:30px; }
.column_content3 p{ float:left; }
.column_content3 img{ margin:5px;} 
</style>
<link href="../css/login.css" rel="stylesheet" type="text/css">
</HEAD>

<body>
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
	  	document.getElementById("tipsUsername").innerHTML="请输入登录用户名";
		document.getElementById("txtUsername").focus();
	  	return false;
	}
	
	if (password.length==0 ){ 
	  	document.getElementById("tipsPasswd").innerHTML="请输入登录密码";
		document.getElementById("txtPassword").focus();
	  	return false;
	}	
	
	if (txtCheckCode.length==0 ){ 
	  	document.getElementById("tipsCheckCode").innerHTML="请输入验证码";
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
	
	sHtml = '<img src="../function/checkcode.php?time='+myDate.getTime()+'" alt="验证码" style="vertical-align:text-bottom;display:inline-block;" height="20" width="50" />';
	document.getElementById("span_check_code").innerHTML=sHtml;
	
	//document.getElementById("span_check_code").innerHTML='<img src="../function/checkcode.php" alt="验证码" height="20" width="50" />';
}

</script>

<?php
	include_once('../config/config_global.php');
	
	// $client_username 	=$_COOKIE['fikcdn_client_username'];
?>
  <!-- -head start -->
<div class="navtopbox">
      <div class="navtop">
      <ul>
					<li><a href="http://www.15cdn.com/cdn/login.php" style="color: #fff;text-decoration: none;">用户登录</a></li>
					<li><a href="http://www.15cdn.com/cdn/register.php" style="color: #fff;text-decoration: none;">免费注册</a></li>
      </ul>
  </div>
</div>
    <div class="navbox">
    
    	<div class="nav">
    		<div class="navlogo">
		        <img src="/images/LOGO23 (2).png">
    		</div>
    		<div class="navinfo">
		        <ul>
		        	<li><a href="/index.html">首页</a></li>
		        	<li> <a href="/product.html">产品中心</a></li>
		        	<li><a href="/solution.html">解决方案</a></li>
		        	<li><a href="/aboutus.html">关于我们</a></li>
		        	<li><a href="http://www.15cdn.com/cdn/main.php">控制台</a></li>
                    <li><a href="http://www.tzidc.com" target="_blank">IDC业务</a></li>
		        </ul>
    		</div>
        </div>
    </div>
    <br><br>
<!-- -head end -->
<table width="100%" height="166" border="0" cellpadding="0" cellspacing="0">
  <tr> <td height="4"></td></tr>
  <tr>
    <td height="42" valign="top"><table width="100%" height="41" border="0" cellpadding="0" cellspacing="0" class="login_top_bg">
      <tr>
        <td width="1%" height="21">&nbsp;</td>
        <td height="42">&nbsp;</td>
        <td width="17%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" height="532" border="0" cellpadding="0" cellspacing="0" class="login_bg">
      <tr>
        <td width="49%" align="right"><table width="91%" height="522" border="0" cellpadding="0" cellspacing="0" class="login_bg2">
            <tr>
              <td height="138" valign="top"><table width="89%" height="427" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="110">&nbsp;</td>
                </tr>
                <tr>
                  <td height="40" align="right" valign="top"><!--<img src="../images/login/logo.gif" width="208" height="36">--></td>
                </tr>
                <tr>
                  <td height="130" align="right" valign="top">
				    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="35%">&nbsp;</td>
                      <td height="35" colspan="2" class="left_txt"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td height="35" colspan="2" class="left_txt"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td height="35" colspan="2" class="left_txt"></td>
                    </tr>
                    <tr align="left">
                      <td></td>
                      <td width="30%"></td>
                      <td width="35%"></td>
                    </tr>
                  </table></td>
                </tr>
				<tr><td height="30"></td></tr>
              </table></td>
            </tr>
            
        </table></td>
        <td width="1%" >&nbsp;</td>
        <td width="50%" valign="bottom"><table width="100%" height="59" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="4%">&nbsp;</td>
              <td width="96%" height="38"><span class="login_txt_bt">登录到 15CDN 后台管理系统</span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="21"><table cellSpacing="0" cellPadding="0" width="100%" border="0" id="table211" height="328">
                  <tr>
                    <td height="190" colspan="2" align="middle">
                        <table cellSpacing="0" cellPadding="0" width="100%" border="0" height="190" id="table212">
                          <tr>
                            <td width="75" height="40" class="top_hui_text" align="right"><span class="login_txt">用户帐号：</span></td>
                            <td class="top_hui_text" align="left">
							<input id="txtUsername" name="txtUsername" type="text" size="26" maxlength="64" value="<?php /*echo $client_username;*/ ?>" />  
							</td>
							<td align="left"><span class="login_tips_txt" id="tipsUsername" name="tipsUsername" ></span></td>
                          </tr>
                          <tr>
                            <td height="40" class="top_hui_text" align="right"><span class="login_txt">登录密码：</span></td>
                            <td class="top_hui_text" align="left">
							<input  id="txtPassword" name="txtPassword" type="password" size="26" maxlength="64" /> 
							</td>
                              <td align="left"> <span class="login_tips_txt" id="tipsPasswd" name="tipsPasswd"></span></td>
							 
                          </tr>
                           <tr>
                            <td height="40" class="top_hui_text" align="right"><span class="login_txt">&nbsp;&nbsp;&nbsp;验证码：</span></td>
                            <td align="left" class="check_code">
							<input  id="txtCheckCode" name="txtCheckCode" type="text" size="5" maxlength="6" />
							<span id="span_check_code" style="clear:both;"><img src="../function/checkcode.php" alt="验证码" height="20" width="50" /></span>
							<a href="#" onClick="javescript:ChangeCheckCode();" > 更换验证码</a>
							</td>
                            <td align="left"> <span class="login_tips_txt" id="tipsCheckCode" name="tipsCheckCode"></span></td>
							 
                          </tr>
                          <tr>
                            <td height="60" ></td>
                            <td width="20%" align="left" ><input name="btn_login" type="submit" class="btn_login" id="btn_login" value="登 陆" onClick="login();" style="cursor:pointer;" /><?php if($FikConfig_AllowRegister) echo '&nbsp;&nbsp;<span class="Register"><a href="register.php" >注册帐号</a></span>'; ?></td>
							<td>  </td>
                          </tr>
						  <tr>
						  	<td height="30" colspan="2" align="center"><span class="login_tips_txt" id="tipsLoginResult"></span></td><td></td>
						  </tr>		
						  <tr>
						  	<td width="70" colspan="3"></td>
						  </tr>
                        </table>
                        <br>
                    </td>
                  </tr>
                  <tr>
                    <td width="433" height="138" align="right" valign="bottom"><img src="../images/login/login-wel.gif" style="vertical-align:text-bottom;display:inline-block;" width="242" height="138"></td>
                    <td width="57" align="right" valign="bottom">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table>
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="login-buttom-bg">
      <tr>
        <td align="center"><span class="login-buttom-txt">Copyright &copy; 2014-2016 www.15cdn.com</span></td>
      </tr>
    </table></td>
  </tr>
</table>

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