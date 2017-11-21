<?php
include_once("./head.php");
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">

<script language="javascript" src="../js/calendar.js"></script>
<script type="text/javascript">	
function FikAgent_Modify(){
	var txtRealname=document.getElementById("txtRealname").value;
	var txtAddr=document.getElementById("txtAddr").value;
	var txtPhone=document.getElementById("txtPhone").value;
	var txtRelation=document.getElementById("txtRelation").value;
	var txtQQ=document.getElementById("txtQQ").value;
	
	if (txtRealname.length==0 ){ 
	  	document.getElementById("tipsRealname").innerHTML="请输入姓名";
		document.getElementById("txtRealname").focus();
	  	return false;
	}
	else{
		document.getElementById("tipsRealname").innerHTML="";
	}
	

	
	if (txtPhone.length==0 ){ 
	  	document.getElementById("tipsPhone").innerHTML="请输入电话号码";
		document.getElementById("txtPhone").focus();
	  	return false;
	}
	else{
		document.getElementById("tipsPhone").innerHTML="";
	}	
	
	if (txtQQ.length==0 ){ 
	  	document.getElementById("tipsQQ").innerHTML="请输入QQ号码";
		document.getElementById("txtQQ").focus();
	  	return false;
	}
	else{
		document.getElementById("tipsQQ").innerHTML="";
	}	
	if (txtAddr.length==0 ){ 
	  	document.getElementById("tipsAddr").innerHTML="请输入联系地址";
		document.getElementById("txtAddr").focus();
	  	return false;
	}
	else{
		document.getElementById("tipsAddr").innerHTML="";
	}	
	var postURL="./ajax.php?mod=setting&action=modifyinfo";
	var postStr="Realname="+UrlEncode(txtRealname)+"&Relation_sale=" + UrlEncode(txtRelation) + "&Addr=" + UrlEncode(txtAddr) + "&Phone=" + UrlEncode(txtPhone) + 
			    "&QQ=" + UrlEncode(txtQQ);				 
					 
	AjaxClientBasePost("setting","modifyinfo","POST",postURL,postStr);
}

function FikCdn_ClientModifyInfoResult(sResponse){
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){		
		window.location.href = "./client_info.php";	
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
<!--------------->
<div style="margin: 15px;">
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>个人信息修改</legend>
			</fieldset>
<?php
	$client_username 	= $_SESSION['fikcdn_client_username'];
	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		$client_username = mysql_real_escape_string($client_username);
		
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
			<form class="layui-form" action="">
				<input type="hidden" name="" value="" />
				<div class="layui-form-item">
					<label class="layui-form-label">姓名</label>
					<div class="layui-input-inline">
						<input id="txtRealname" type="text" size="26" maxlength="64" value="<?php echo $real_name; ?>" lay-verify="name" autocomplete="off" placeholder="请输入姓名" class="layui-input"/> <span class="input_tips_txt" id="tipsRealname" ></span>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">关联业务员</label>
					<div class="layui-input-inline">
						<input id="txtRelation" name="txtRelation" type="text" size="26" maxlength="16" value="<?php echo $relation_sale; ?>"  autocomplete="off" placeholder="请输入关联业务员" class="layui-input"/>  </span>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">联系电话</label>
					<div class="layui-input-inline">
						<input id="txtPhone" name="txtPhone" type="text" size="26" maxlength="16" value="<?php echo $phone; ?>" lay-verify="phone" autocomplete="off" placeholder="请输入联系电话" class="layui-input"/>  <span class="input_tips_txt" id="tipsPhone" name="tipsPhone" ></span> 
					</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">QQ号码</label>
					<div class="layui-input-inline">
						<input id="txtQQ" name="txtQQ" type="text" size="26" maxlength="16" value="<?php echo $qq; ?>"  lay-verify="qq_num" autocomplete="off" placeholder="请输入QQ号码" class="layui-input"/>  <span class="input_tips_txt" id="tipsQQ" name="tipsQQ" ></span>
					</div>
				</div>

				<div class="layui-form-item">
					<label class="layui-form-label">联系地址</label>
					<div class="layui-input-block" style="width: 550px;">
						<input id="txtAddr" type="text" size="64" maxlength="128" value="<?php echo $addr; ?>" lay-verify="address" placeholder="请输入联系地址" autocomplete="off" class="layui-input"/>  <span class="input_tips_txt" id="tipsAddr" name="tipsAddr" ></span>
					</div>
				</div>

				<div class="layui-form-item">
					<div class="layui-input-block">
						<input name="btn_modify"  id="btn_modify" type="button"   value="确定" style="cursor:pointer;" onClick="FikAgent_Modify();" class="layui-btn" lay-submit="" lay-filter="demo1"/> 
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
					name: function(value) {
						if(value == "") {
							return '请输入姓名！';
						}
					},
					sales: function(value) {
						if(value == "") {
							return '请输入关联业务员！';
						}
					},
					qq_num: function(value) {
						if(value == "") {
							return '请输入QQ号码！';
						}
					},
					address: function(value) {
						if(value == "") {
							return '请输入联系地址！';
						}
					},
					
				});

			});
		</script>

<!--------------->

<?php

include_once("./tail.php");
?>
