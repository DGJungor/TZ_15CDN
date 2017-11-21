<?php
include_once("./head.php");
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="css/global.css" media="all">
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="css/table.css" />
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />

<script language="javascript" src="../js/calendar.js"></script>
<script type="text/javascript">	
function FikCdn_Modify(){
	window.location.href = "./client_info_modify.php"; 
}
</script>
<!----------------------->
<div class="admin-main">
				
			<fieldset class="layui-elem-field">
				<legend>个人信息</legend>
				<?php
	$client_username 	= $_SESSION['fikcdn_client_username'];
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
			$relation_sale 			=mysql_result($result,0,"relation_sale");	
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
				<div class="layui-field-box">
					<table class="site-table table-hover" align=center>
						<tbody>
							<tr>
								<td style="width: 120px; text-align: right;">登录名</td>
								<td style="text-align: left;"><?php echo $client_username;  ?></td>
							</tr>
							<tr>
								<td style="width: 120px; text-align: right;">姓名</td>
								<td style="text-align: left;"><?php echo $real_name;  ?></td>
							</tr>
							<tr>
								<td style="width: 120px; text-align: right;">关联业务员</td>
								<td style="text-align: left;"><?php echo $relation_sale;  ?></td>
							</tr>
							<tr>
								<td style="width: 120px; text-align: right;">联系地址</td>
								<td style="text-align: left;"><?php echo $addr;  ?></td>
							</tr>
							<tr>
								<td style="width: 120px; text-align: right;">联系电话</td>
								<td style="text-align: left;"><?php echo $phone;  ?></td>
							</tr>
							<tr>
								<td style="width: 120px; text-align: right;">QQ号码</td>
								<td style="text-align: left;"><?php echo $qq;  ?></td>
							</tr>
							<tr>
								<td style="width: 120px; text-align: right;">账户余额</td>
								<td style="text-align: left;"><?php echo $money;  ?> 元</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="text-align: left;">
									<input name="btn_modify"  id="btn_modify" type="button" class="layui-btn"   value="修改" style="cursor:pointer;" onClick="FikCdn_Modify();" /> 
								</td>
							</tr>
						</tbody>
					</table>

				</div>
			</fieldset>
			
			
		</div>
		<script type="text/javascript" src="plugins/layui/layui.js"></script>
<!------------------------->

<?php

include_once("./tail.php");
?>
