<?php
include_once("head2.php");
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">

<script language="javascript" src="../js/calendar.js"></script>

<script type="text/javascript">
var ___nProductId;
function FikCdn_BuyProductBox(product_id){
	___nProductId =	product_id;
	var txtMonth  = document.getElementById("txtMonth").value;
	var txtBackup = document.getElementById("txtBackup").value;
	if (txtMonth.length==0 || !checkIsNumber(txtMonth) ){
		var boxURL="msg.php?1.9&msg=请输入正确的月份数。";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');			
		document.getElementById("txtMonth").focus();
	  	return false;
	}
	
	var boxURL="msg.php?1.3";
	showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');
}

function FikCdn_BuyProduct(){
	var txtMonth  = document.getElementById("txtMonth").value;
	var txtBackup = document.getElementById("txtBackup").value;
	if (txtMonth.length==0 || !checkIsNumber(txtMonth) ){
		document.getElementById("txtMonth").focus();
	  	return false;
	}
		
	var postURL="./ajax_buy.php?mod=order&action=add";
	var postStr="product_id="+UrlEncode(___nProductId) + "&month=" + UrlEncode(txtMonth)+"&note="+UrlEncode(txtBackup);
			 
	AjaxClientBasePost("order","add","POST",postURL,postStr);	
}

function FikCdn_ClientAddOrderResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		var nOrderID = json["order_id"];
		//parent.closeMSGBOX();
		
		var boxURL="product_pay.php?order_id="+nOrderID;
		parent.showMSGBOX('',500,410,BT,BL,120,boxURL,'订单支付:');
		//window.location.href = "./product_pay.php?order_id="+nOrderID; 
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

function checkIsNumber(str)
{
     var re = /^[1-9]+[0-9]*]*$/;   //判断字符串是否为数字 /^[0-9]+.?[0-9]*$/     //判断正整数 /^[1-9]+[0-9]*]*$/    
     if (!re.test(str))
    {
        return false;
     }
	 return true;
}

</script>


<?php
	$product_id = isset($_GET['id'])?$_GET['id']:'';
 	$client_username 	=$_SESSION['fikcdn_client_username'];
	
 	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		$product_id = mysql_real_escape_string($product_id); 
		$client_username = mysql_real_escape_string($client_username); 
			
		$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id' ;"; 
		$result = mysql_query($sql,$db_link);
		if(!$result || mysql_num_rows($result)<=0)
		{
			exit();
		}
	
		$product_name = mysql_result($result,0,"name");
		$price 		= mysql_result($result,0,"price");
		$data_flow	= mysql_result($result,0,"data_flow");	
		$domain_num = mysql_result($result,0,"domain_num");
		$is_online 	= mysql_result($result,0,"is_online");
		$begin_time = mysql_result($result,0,"begin_time");
		$note	 	= mysql_result($result,0,"note");
		
		$sql = "SELECT * FROM fikcdn_client WHERE username='$client_username' ;"; 
		$result = mysql_query($sql,$db_link);
		if(!$result || mysql_num_rows($result)<=0)
		{
			exit();
		}
		$client_money = mysql_result($result,0,"money");
		$enable_login = mysql_result($result,0,"enable_login");
	}			
 ?>    
<!----------------->
<div style="margin: 15px;z-index:-1;">
			
			<button class="layui-btn" lay-submit="" lay-filter="demo1" onclick="window.location.href='product_list.php'">返回产品套餐</button>
			
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>购买套餐</legend>
			</fieldset>

			<form class="layui-form" action="index.html">
				<div class="layui-form-item">
					<label class="layui-form-label">套餐名称</label>
					<div style="padding-top: 10px;">
						<?php echo $product_name; ?>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">域名个数</label>
					<div style="padding-top: 10px;">
						<?php echo $domain_num; ?>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">月度总流量</label>
					<div style="padding-top: 10px;">
						<?php echo PubFunc_MBToString($data_flow); ?>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">套餐价格</label>
					<div style="padding-top: 10px;">
						<?php echo $price; ?> 元/月
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">套餐说明</label>
					<div style="padding-top: 10px;">
						<?php echo $note; ?>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">账户余额</label>
					<div style="padding-top: 10px;">
						<?php echo $client_money; ?> 元
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">购买月份数</label>
					<div class="layui-input-inline">
						<input id="txtMonth" type="number" name="month" size="5" maxlength="5" lay-verify="month" placeholder="购买月份数" autocomplete="off" class="layui-input" value='<?php echo '1'; ?>'>
					</div>
					<div sytle="float: right;">
						<div style="padding-top: 10px;">
							个月
						</div>
					</div>
				</div>
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">备注</label>
					<div class="layui-input-block" style="width: 550px;">
						<textarea id="txtBackup" name="txtBackup" maxlength="128" placeholder="请输入内容" class="layui-textarea"></textarea>
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<input name="btnBuyProduct"  type="button" id="btnBuyProduct" value="购买" onClick="FikCdn_BuyProductBox(<?php echo $product_id; ?>);" class="layui-btn" lay-submit="" lay-filter="demo1"/>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
			</form>
					
		</div>
		<div style="height: 20px;"></div>
		
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
					month: function(value) {
						if(value == "") {
							return '请输入购买月份数！';
						}
					}
				});

			});
		</script>
<!---------------------------->
<?php

include_once("./tail.php");
?>
