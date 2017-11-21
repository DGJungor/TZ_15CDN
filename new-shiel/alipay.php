<?php

include_once("./head.php");
include_once('../db/db.php');
include_once("function.php");

?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="css/global.css" media="all">
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="css/table.css" />
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />

<script language="javascript" src="../js/calendar.js"></script>

<script type="text/javascript">
function ChangePayCheckCode(){
	var sHtml;
	var myDate=new Date();
	
	sHtml = '<img src="./function/pay_checkcode.php?time='+myDate.getTime()+'" alt="验证码" height="20" width="50" />';
	document.getElementById("span_pay_check_code").innerHTML=sHtml;
}

function onChangeAuthType(){
	var nAuthType = document.getElementById("authTypeSelect").value;
	
	var objSpanAuthPrice = document.getElementById("span_auth_price");
         
	if(nAuthType==12)
	{	    
		objSpanAuthPrice.innerHTML = "799元/年";
	}
	else if(nAuthType==6)
	{	    
		objSpanAuthPrice.innerHTML = "399元/半年";
	}
	else if(nAuthType==3)
	{	    
		objSpanAuthPrice.innerHTML = "199元/三个月";
	}	
	else if(nAuthType==1)
	{	    
		objSpanAuthPrice.innerHTML = "78元/月";
	}	
	else
	{
		alert("选择错误!");
	}	
}

function FikAgent_PayOrder(order_id){
	var new_url = "alipayapi.php?order_id="+order_id;
	window.open(new_url);
}

</script>


<div class="admin-main">
				
			<fieldset class="layui-elem-field">
				<legend>在线支付</legend>
  
<?php
	$order_id 	= isset($_GET['order_id'])?$_GET['order_id']:'';
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
			
			//查询订单		
		}
			
		$sql = "SELECT * FROM fikcdn_recharge WHERE order_id='$order_id' AND username='$client_username'";
		$result = mysql_query($sql,$db_link);
		if($result && mysql_num_rows($result)>0)
		{
			$id  			= mysql_result($result,$i,"id");	
			$order_id   	= mysql_result($result,$i,"order_id");
			$status   		= mysql_result($result,$i,"status");
			$username   	= mysql_result($result,$i,"username");
			$chgmoney 		= mysql_result($result,$i,"money");	
			$time  		 	= mysql_result($result,$i,"time");	
			$transactor   	= mysql_result($result,$i,"transactor");	
			$bank_name   	= mysql_result($result,$i,"bank_name");	
			$serial_no   	= mysql_result($result,$i,"serial_no");
			$balance	   	= mysql_result($result,$i,"balance");
			$note   	    = mysql_result($result,$i,"note");
		}
			
		mysql_close($db_link);
	}
?>
  <div class="layui-field-box">
					<table class="site-table table-hover" align=center>
						<tbody>
							<tr>
								<td style="width: 120px; text-align: right;">订单号</td>
								<td style="text-align: left;"><span id="span_auth_price" name="span_auth_price"><?php echo $order_id; ?></span></td>
							</tr>
							<tr>
								<td style="width: 120px; text-align: right;">本次充值金额</td>
								<td style="text-align: left;"><span id="span_auth_price" name="span_auth_price" class="input_tips_txt2"><?php echo $chgmoney; ?> 元</span></td>
							</tr>
							<tr>
								<td style="width: 120px; text-align: right;">当前账户余额</td>
								<td style="text-align: left;"><?php echo $money;  ?> 元</span></td>
							</tr>
							<tr>
								<td style="width: 120px; text-align: right;">付款方式</td>
								<td style="text-align: left;">
									<div class="" style="">
										<input type="radio" checked="checked" name="fikker_pay" id="fikker_pay" title="支付宝"/>支付宝
									</div>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="text-align: left;">
									<input name="sub_order"  id="sub_order" type="button" class="layui-btn" lay-submit="" lay-filter="demo1"  value="立即在线支付" onClick="FikAgent_PayOrder(<?php echo '\''.$order_id.'\'';?>);" />
								</td>
							</tr>
						</tbody>
					</table>

				</div>
			</fieldset>
			
			
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
						}
					},
					code: function(value) {
						if(value == "") {
						}
					}
				});

			});
		</script>
<!----------------------->



<?php

include_once("./tail.php");
?>
