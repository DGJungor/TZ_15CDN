<?php
include_once("./head.php");
include_once('../db/db.php');
include_once("function.php");
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">

<script language="javascript" src="./js/calendar.js"></script>

<script type="text/javascript">
function ChangePayCheckCode(){
	var sHtml;
	var myDate=new Date();
	sHtml = '<img src="../function/pay_checkcode.php?time='+myDate.getTime()+'" alt="验证码" width="100px" height="38px" />';
	document.getElementById("span_pay_check_code").innerHTML=sHtml;
}

function FikCDN_SubOrder(){
	var nMoney = document.getElementById("txtMoney").value;
	var txtNote = document.getElementById("txtBackup").value; 
	var txtCheckNum = document.getElementById("txtCheckNum").value; 

	if (nMoney.length==0 || isNaN(nMoney) || nMoney==0 ){ 
	  	document.getElementById("tipsMoney").innerHTML="请输入充值金额";
		document.getElementById("tipsMoney").focus();
	  	return false;
	}
	else{
		document.getElementById("tipsMoney").innerHTML="";
	}
	
	if(txtCheckNum.length==0 ){ 
	  	document.getElementById("tipsCheckNum").innerHTML="请输入验证码";
		document.getElementById("txtCheckNum").focus();
	  	return false;
	}
	else{
		document.getElementById("tipsCheckNum").innerHTML="";
	}	

	var postURL="./ajax_buy.php?mod=order&action=submit";
	var postStr="Money=" + UrlEncode(nMoney) + "&Note=" + UrlEncode(txtNote) + 
			     "&CheckNum=" + UrlEncode(txtCheckNum);				 
					 
	AjaxClientBasePost("order","submit","POST",postURL,postStr);
}

function FikCDN_SubmitOrderResult(sResponse){
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		var order_id = json["order_id"];
		location.href = "alipay.php?order_id="+order_id;
	}else{
		var nErrorNo = json["ErrorNo"];
		var strErr = json["ErrorMsg"];	
		
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}else{
			alert(strErr);
		}
	}
}

</script>

<!----------------------->
<div style="margin: 15px;">
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>在线充值</legend>
			</fieldset>
<?php
	$client_username	=$_SESSION['fikcdn_client_username'];
	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		$sql = "SELECT * FROM fikcdn_client WHERE username='$client_username'";
		$result = mysql_query($sql,$db_link);
		if($result && mysql_num_rows($result)>0)
		{		
			$id  			=mysql_result($result,0,"id");
			$real_name		=mysql_result($result,0,"realname");	
			$phone 			=mysql_result($result,0,"phone");	
			$qq 			=mysql_result($result,0,"qq");
			$addr 			=mysql_result($result,0,"addr");
			$note			=mysql_result($result,0,"note");
			$money			=mysql_result($result,0,"money");
			$enable_login	=mysql_result($result,0,"enable_login");
			$last_login_ip	=mysql_result($result,0,"last_login_ip");
			$last_login_time=mysql_result($result,0,"last_login_time");
			$login_count	=mysql_result($result,0,"login_count");	
		}
			
		mysql_close($db_link);
	}
?>	
			<form class="layui-form" action="">
				<div class="layui-form-item">
					<label class="layui-form-label">充值金额</label>
					<div class="layui-input-inline">
						<input id="txtMoney" type="number" size="3" maxlength="32"  value="" lay-verify="amount" placeholder="请输入金额" autocomplete="off" class="layui-input"/>   
					</div>
					<div sytle="float: right;">
						<div style="padding-top: 10px;">
							<span id="tipsMoney" >元</span>	
						</div>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">当前余额</label>
					<div style="padding-top: 10px;">
						<span ><?php echo $money;  ?> 元</span>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">付款方式</label>
					<div class="" style="">
						<input type="radio" checked="checked" name="fikker_pay" id="fikker_pay" title="支付宝"/>
					</div>
				</div>
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">备注</label>
					<div class="layui-input-block" style="width: 400px;">
						<textarea id="txtBackup" name="txtBackup" maxlength="108" cols="48" rows="3" placeholder="请输入内容" class="layui-textarea"></textarea>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">验证码</label>
					<div class="layui-input-inline" style="width: 170px;">
						<input id="txtCheckNum" name="txtCheckNum" type="text"  lay-verify="code" placeholder=" &nbsp;&nbsp;验证码" autocomplete="off" style="height: 37px; width:80x; border:1px solid #e6e6e6;" >
					</div>
					<div sytle="float: right;">
						<div style="padding-top: 0px;">
							<span id="span_pay_check_code"><img src="../function/pay_checkcode.php" width="100px" height="38px" /></span>&nbsp;&nbsp;<a href="javascript:void(0)" onClick="javescript:ChangePayCheckCode();">更换验证码</a>
						</div>
					</div>
					<span class="input_tips_txt" id="tipsCheckNum" ></span>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<input name="sub_order"  id="sub_order" type="button" onClick="FikCDN_SubOrder();"class="layui-btn" lay-submit="" lay-filter="demo1" value="提交"/>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
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

				//创建一个编辑器
				var editIndex = layedit.build('LAY_demo_editor');
				//自定义验证规则
				form.verify({
					amount: function(value) {
						if(value == "") {
							return '请输入金额！';
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
<!------------------------->

<?php

include_once("./tail.php");
?>
