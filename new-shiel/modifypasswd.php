<?php
include_once("./head.php");
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="css/passwordStrong.css">
<script type="text/javascript" src="js/vaildPwdStrong.js"></script>

<script src="../js/md5.js"></script>
<script type="text/javascript">	
function FikCdn_ModifyPasswd()
{
	var txtOldPasswd      =document.getElementById("txtOldPasswd").value;
	var txtNewPasswd      =document.getElementById("txtNewPasswd").value;
	var txtAffirmPasswd   =document.getElementById("txtAffirmPasswd").value;
	
	if (txtOldPasswd.length==0 ){ 
	  	document.getElementById("tipsOld").innerHTML="请输入现密码";
		document.getElementById("txtOldPasswd").focus();
	  	return false;
	}
	else{
		document.getElementById("tipsOld").innerHTML="";
	}
	
	if (txtNewPasswd.length==0 ){ 
	  	document.getElementById("tipsNew").innerHTML="请输入新密码";
		document.getElementById("txtNewPasswd").focus();
	  	return false;
	}
	else if(txtNewPasswd.length <6){
		document.getElementById("tipsNew").innerHTML="密码最少6位";
		document.getElementById("txtNewPasswd").focus();
	  	return false;
	}	
	else{
		document.getElementById("tipsNew").innerHTML="";
	}
	
	if (txtAffirmPasswd.length==0 ){ 
	  	document.getElementById("tipsAffirm").innerHTML="请输入确认密码";
		document.getElementById("txtAffirmPasswd").focus();
	  	return false;
	}
	else{
		document.getElementById("tipsAffirm").innerHTML="";
	}	
	
	if(txtAffirmPasswd!=txtNewPasswd){
		document.getElementById("tipsNew").innerHTML="新密码和确认密码不一致，请重新输入";
		document.getElementById("txtNewPasswd").focus();
		document.getElementById("tipsAffirm").innerHTML="";
	  	return false;
	}
		
	var postURL="./ajax.php?mod=setting&action=modifypasswd";
	var postStr="oldpasswd="+ hex_md5(txtOldPasswd) + "&newpasswd=" + hex_md5(txtNewPasswd);		 
					 
	AjaxClientBasePost("setting","modifypasswd","POST",postURL,postStr);	
}

function FikCdn_ResetPasswd()
{
	document.getElementById("txtOldPasswd").value = "";
	document.getElementById("txtNewPasswd").value = "";
	document.getElementById("txtAffirmPasswd").value = "";
	
	document.getElementById("txtOldPasswd").focus();
}

function FikCdn_ClientModifyPasswdResult(sResponse){
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		var boxURL="msg.php?1.9&msg=修改登录密码成功。";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');			
		document.getElementById("txtOldPasswd").value="";
		document.getElementById("txtNewPasswd").value="";
		document.getElementById("txtAffirmPasswd").value="";
	}else{
		var nErrorNo = json["ErrorNo"];
		var strErr = json["ErrorMsg"];	
	
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}else{
			var boxURL="msg.php?1.9&msg="+strErr;
			showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');
		}
	}	
}

</script>

<!---------------->
<div style="margin: 15px;">
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>密码修改</legend>
			</fieldset>

			<form name="form1" class="layui-form" action="" onSubmit="return checkForm();" method="post">
				<input type="hidden" name="userName" value="">
				<div class="layui-form-item">
					<label class="layui-form-label">原密码</label>
					<div class="layui-input-inline">
						<input id="txtOldPasswd" name="txtOldPasswd" type="password" size="30" maxlength="32" lay-verify="oldPwd" placeholder="请输入原密码" autocomplete="off" class="layui-input"/> <span class="input_tips_txt" id="tipsOld" name="tipsOld" ></span>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">新密码</label>
					<div class="layui-input-inline">
						<input type="password" id="txtNewPasswd" name="txtNewPasswd" size="30" maxlength="32" lay-verify="password" placeholder="请输入6-20位新密码" autocomplete="off" class="layui-input"
						onKeyUp="pwStrength(this.value)" onBlur="pwStrength(this.value)" onChange="passwordscheck('ps')"><span class="input_tips_txt" id="tipsNew" name="tipsNew" ></span>
					</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">密码强度</label>
					<div class="layui-input-inline">
						<div class="formControls col-5" style="padding-top: 5px; margin-left: -20px;">
							<div class="ywz_zhucexiaobo">
								<div class="ywz_zhuce_xiaoxiaobao">
									<div class="ywz_zhuce_huixian" id='strength_L'></div>
									<div class="ywz_zhuce_huixian" id='strength_M'></div>
									<div class="ywz_zhuce_huixian" id='strength_H'></div>
								</div>
							</div>
						</div>
					</div>
					<div class="layui-form-mid layui-word-aux">
						<font style="font-size: 8px;">&nbsp;密码安全性较：&nbsp;&nbsp;<b><span
											id=ps></span></b></font>
					</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">确认新密码</label>
					<div class="layui-input-inline">
						<input type="password" id="txtAffirmPasswd" name="txtAffirmPasswd"  size="30" maxlength="32"lay-verify="password2" placeholder="请输入6-20位确认密码" autocomplete="off" class="layui-input"
						onchange="checkPwd();"><span class="input_tips_txt" id="tipsAffirm" name="tipsAffirm" ></span>
					</div>
					<div class="layui-form-mid layui-word-aux" id="sp"></div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<input name="btnModify" id="btnModify" type="button"  value="修改" class="layui-btn" lay-submit="" lay-filter="demo1" onClick="FikCdn_ModifyPasswd();" /> 
						<input name="btnReset"  id="btnReset" type="button"  value="重置" style="cursor:pointer;" onClick="FikCdn_ResetPasswd();" class="layui-btn layui-btn-primary"/> 
					</div>
				</div>
			</form>
			
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
					oldPwd: function(value) {
						if(value == "") {
							return '请输入旧密码！';
						}
					},
					password: function(value) {
						if(value == "") {
							return '请输入新密码！';
						} else if(value.length < 6 || value.length > 20) {
							return '密码必须6-20位!';
						}
					},
					password2: function(value) {
						if(value == "") {
							return '请输入确认新密码！';
						} else if(value.length < 6 || value.length > 20) {
							return '密码必须6-20位!';
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
						document.getElementById("sp").innerHTML = "<font style='color: red;'>二次密码不相同</font>";
						form1.password2.focus();
						return false;
					}	
				}
			</script>

<!-------------------->

<?php

include_once("./tail.php");
?>
