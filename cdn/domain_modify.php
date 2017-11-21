<?php
include_once("./head2.php");
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="css/table.css" />

<script type="text/javascript">
function FikCdn_ModifyDomain(domain_id){
	var SSLCrtContent	=document.getElementById("SSLCrtContent").value;
	var SSLKeyContent	=document.getElementById("SSLKeyContent").value;
	var SSLExtraParams	=document.getElementById("SSLExtraParams").value;
	var txtSrcIP     	=document.getElementById("txtSrcIP").value;
	var txtUnicomIP   	=document.getElementById("txtUnicomIP").value;
	var txtBackup    	=document.getElementById("txtBackup").value;
	var productSelect	=document.getElementById("productSelect").value;
	var txtICP     		=document.getElementById("txtICP").value;
	//var txtDNSName    =document.getElementById("txtDNSName").value;
	
	var SSLOpt = 0;
	var objRadio = document.getElementsByName("SSLOpt");
	for(var i=0;i<objRadio.length;i++){
		if(objRadio[i].checked){  
			SSLOpt = objRadio[i].value;
		}   
	}
	
	var UpsSSLOpt = 0;
 	objRadio = document.getElementsByName("UpsSSLOpt");
	for(var i=0;i<objRadio.length;i++){
		if(objRadio[i].checked){  
			UpsSSLOpt = objRadio[i].value;
		}   
	}	
		
	var selUpstreatType = 0;
	var objRadio = document.getElementsByName("selUpstreatType");
	for(var i=0;i<objRadio.length;i++){
		if(objRadio[i].checked){  
			selUpstreatType = objRadio[i].value;
		}   
	}
		
	var txtDNSName = "";
		
	if (txtSrcIP.length==0 && txtUnicomIP.length==0){ 
		var boxURL="msg.php?1.9&msg=电信源站 IP 和联通源站 IP 至少填一个。";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');	
		document.getElementById("txtSrcIP").focus();
	  	return false;
	}
	
	var postURL="./ajax_domain.php?mod=domain&action=modify";
	var postStr="domain_id="+UrlEncode(domain_id) + "&SSLOpt=" + SSLOpt + "&SSLCrtContent=" + UrlEncode(SSLCrtContent) + "&SSLKeyContent=" + UrlEncode(SSLKeyContent) + "&SSLExtraParams=" + UrlEncode(SSLExtraParams) + 
			"&srcip=" + UrlEncode(txtSrcIP) + "&unicom_ip="+UrlEncode(txtUnicomIP)+ "&UpsSSLOpt=" + UpsSSLOpt + "&upstream_add_type=" +selUpstreatType+
			"&icp=" + UrlEncode(txtICP) +"&dns_name=" + UrlEncode(txtDNSName) + "&buy_id=" + productSelect+"&backup=" + UrlEncode(txtBackup);
					 
	AjaxClientBasePost("domain","modify","POST",postURL,postStr);	
}

function FikCdn_ClientModifyDomainResult(sResponse){
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		var nDomainID = json["id"];
		//parent.window.location.reload();
		window.location.href='domain_list.php';
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

function ChangeSSLOpt(opt){
	switch(opt)
	{
		case 0:
		{
			var SSLAllParams = document.getElementById("SSLAllParams");
			SSLAllParams.style.display="none";
			break;
		}
		default:
		{
			var SSLAllParams = document.getElementById("SSLAllParams");
			SSLAllParams.style.display="table-row";
			break;
		}
	}
}

</script>
<?php
	$domain_id = isset($_GET['id'])?$_GET['id']:'';
	$client_username 	=$_SESSION['fikcdn_client_username'];

 	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		$domain_id 	= mysql_real_escape_string($domain_id); 
		// $admin_username 	= mysql_real_escape_string($admin_username); 		
		
		$sql = "SELECT * FROM fikcdn_domain WHERE id='$domain_id' ;"; 
		$result = mysql_query($sql,$db_link);
		if(!$result || mysql_num_rows($result)<=0)
		{
			exit();
		}
	
		$hostname 	= mysql_result($result,0,"hostname");
		$username 	= mysql_result($result,0,"username");
		$buy_id		= mysql_result($result,0,"buy_id");
		$group_id   = mysql_result($result,0,"group_id");
		$add_time 	= mysql_result($result,0,"add_time");
		$status 	= mysql_result($result,0,"status");
		$upstream 	= mysql_result($result,0,"upstream");
		$unicom_ip 	= mysql_result($result,0,"unicom_ip");
		$use_transit_node 	= mysql_result($result,0,"use_transit_node");		
		$icp 				= mysql_result($result,0,"icp");
		$DNSName 			= mysql_result($result,0,"DNSName");		
		$note	 			= mysql_result($result,0,"note");
		$upstream_add_all	= mysql_result($result,0,"upstream_add_all");
		$SSLOpt 	    	= mysql_result($result,0,"SSLOpt");	
		$SSLCrtContent		= mysql_result($result,0,"SSLCrtContent");			
		$SSLKeyContent		= mysql_result($result,0,"SSLKeyContent");
		$SSLExtraParams		= mysql_result($result,0,"SSLExtraParams");								
		$UpsSSLOpt	    	= mysql_result($result,0,"UpsSSLOpt");		
	}			
 ?>    
 <div style="margin: 15px;">
			
			<button class="layui-btn" lay-submit="" lay-filter="demo1" onclick="window.location.href='domain_list.php'">返回域名列表</button>
			
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>添加域名</legend>
			</fieldset>

			<form class="layui-form" action="">

				<div class="layui-form-item">
					<label class="layui-form-label">域名</label>
					<div class="layui-input-inline">
						<label><?php echo $hostname; ?></label><span class="input_tips_txt" id="tipsDomain" ></span>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">域名SSL项</label>
					<div class="layui-input-block">
						<input name="SSLOpt" type="radio" id="SSLOpt_Http" value="0" title="HTTP"	<?php if($SSLOpt==0) echo 'checked="checked"'; ?>onchange="ChangeSSLOpt(0)" lay-filter="HTTP">
						<input name="SSLOpt" type="radio" id="SSLOpt_Https" value="1" title="HTTPS" <?php if($SSLOpt==1) echo 'checked="checked"'; ?>onchange="ChangeSSLOpt(1)" lay-filter="HTTPS">
						<input name="SSLOpt" type="radio" id="SSLOpt_HttpAndHttps" value="2" title="HTTP+HTTPS" <?php if($SSLOpt==2) echo 'checked="checked"'; ?> onchange="ChangeSSLOpt(2)" lay-filter="HTTP+HTTPS">
					</div>
				</div>

				<div id="SSLAllParams" <?php if($SSLOpt==0) echo 'style="display:none"' ?>>

					<div class="layui-form-item layui-form-text">
						<label class="layui-form-label">*SSL证书文件内容<br /><span style="font-style:italic;font-size:10px">SSL Certificate File&nbsp;<br />Content&nbsp;</span></label>
						<div class="layui-input-block" style="width: 550px;">
							<textarea name="SSLCrtContent" id="SSLCrtContent" placeholder="" class="layui-textarea"></textarea>
						</div>
					</div>
					<div class="layui-form-item layui-form-text">
						<label class="layui-form-label">*SSL私钥文件内容<br /><span style="font-style:italic;font-size:10px">SSL Private Key File&nbsp;<br />Content&nbsp;</span></label>
						<div class="layui-input-block" style="width: 550px;">
							<textarea name="SSLKeyContent" id="SSLKeyContent" placeholder="" class="layui-textarea"></textarea></textarea>
						</div>
					</div>
					<div class="layui-form-item layui-form-text">
						<label class="layui-form-label">*SSL附加配置参数</label>
						<div class="layui-input-block" style="width: 550px;">
							<input name="SSLExtraParams" type="text"  id="SSLExtraParams" value="SessionSize=5000&Password=" class="layui-input" autocomplete="off"/>
						</div>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">源站电信IP</label>
					<div class="layui-input-inline">
						<input id="txtSrcIP" type="tel" name="tip" size="36" maxlength="64" lay-verify="tip" placeholder="请输入源站电信IP" autocomplete="off" class="layui-input" value='<?php echo $upstream; ?>' >
						<span class="input_tips_txt" id="tipsSrcIP" name="tipsSrcIP" ></span>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">源站联通IP</label>
					<div class="layui-input-inline">
						<input id="txtUnicomIP" type="text" name="uip" size="36" maxlength="64" lay-verify="uip" placeholder="请输入源站联通IP" autocomplete="off" class="layui-input" value='<?php echo $unicom_ip; ?>' >
						<span class="input_tips_txt4" id="tipsUnicomIP" ></span>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">源站SSL项</label>
					<div class="layui-input-block">
						<input name="UpsSSLOpt" type="radio" id="SSLOpt_Http" value="0" <?php if($UpsSSLOpt==0) echo 'checked="checked"'; ?> title="HTTP"/>
						<input name="UpsSSLOpt" type="radio" id="SSLOpt_Https" value="1" <?php if($UpsSSLOpt==1) echo 'checked="checked"'; ?> title="HTTPS"/>
						<input name="UpsSSLOpt" type="radio" id="SSLOpt_HttpAndHttps" value="2" <?php if($UpsSSLOpt==2) echo 'checked="checked"'; ?> title="HTTP+HTTPS(默认)"/>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">源站配置项</label>
					<div class="layui-input-block">
						<input type="radio" name="selUpstreatType" id="selUpstreatType" value="0" title="自动匹配线路" <?php if($upstream_add_all==0) echo 'checked="checked"'; ?> checked="checked">
						<input type="radio" name="selUpstreatType" id="selUpstreatType" value="1" title="双源站配置" <?php if($upstream_add_all==1) echo 'checked="checked"'; ?> >
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">域名ICP备案号</label>
					<div class="layui-input-block" style="width: 550px;">
						<input id="txtICP" type="text" name="record" size="36" maxlength="64" lay-verify="record" placeholder="请输入域名ICP备案号" autocomplete="off" class="layui-input" value="<?php echo $icp; ?>">
						<span class="input_tips_txt" id="tipsICP" ></span>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">产品套餐</label>
					<div class="layui-input-inline">
						<select id="productSelect" name="sale">
						 <?php	
							if($db_link)
							{
								//查询产品所属服务器组
								$sql = "SELECT * FROM fikcdn_buy WHERE id='$buy_id'";
								$result = mysql_query($sql,$db_link);
								if($result && mysql_num_rows($result)>0)
								{
									$product_id	= mysql_result($result,0,"product_id");
									
									$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
									$result2 = mysql_query($sql,$db_link);
									if($result2 && mysql_num_rows($result2)>0)
									{
										$product_name  			= mysql_result($result2,0,"name");
										echo '<option value="'.$product_id.'" selected="selected" >'.$product_name.'_'.$buy_id.'</option>';						
									}
								}
								
								mysql_close($db_link);
							}			
						 ?>
					</select>

					</div>
				</div>
							
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">备注</label>
					<div class="layui-input-block" style="width: 550px;">
						<textarea id="txtBackup" name="txtBackup" placeholder="" class="layui-textarea"><?php echo $note; ?></textarea>
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<input name="btnAddDomain"  type="button" class="layui-btn" lay-submit="" lay-filter="demo1" id="btnAddDomain" value="保存" onClick="FikCdn_ModifyDomain(<?php echo $domain_id; ?>);" />
						
					</div>
				</div>
			</form>		
			
			<div class="layui-form-item">
				同步说明：<br />
				 1. 修改域名信息成功后，系统通过后台任务方式同步到所有节点服务器；
			</div>
			
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
					tip: function(value) {
						
					},
					uip: function(value) {
						
					},
					record: function(value) {
						
					},
					url: function(value){
						
					},
				});
				form.on('radio(HTTP)', function(data){
					var SSLAllParams = document.getElementById("SSLAllParams");
					SSLAllParams.style.display="none";
				});
				form.on('radio(HTTPS)', function(data){
					var SSLAllParams = document.getElementById("SSLAllParams");
					SSLAllParams.style.display="block";
				});
				form.on('radio(HTTP+HTTPS)', function(data){
					var SSLAllParams = document.getElementById("SSLAllParams");
					SSLAllParams.style.display="block";
				});
			});
		</script>
<?php

include_once("./tail.php");
?>
