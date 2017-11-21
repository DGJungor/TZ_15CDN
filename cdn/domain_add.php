<?php
include_once("./head2.php");
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="css/table.css" />


<script type="text/javascript">
function FikCdn_AddDomain(){
	var txtDomain	 	=document.getElementById("txtDomain").value;
	var SSLCrtContent	=document.getElementById("SSLCrtContent").value;
	var SSLKeyContent	=document.getElementById("SSLKeyContent").value;
	var SSLExtraParams	=document.getElementById("SSLExtraParams").value;	
	var productSelect	=document.getElementById("productSelect").value;
	var txtSrcIP     	=document.getElementById("txtSrcIP").value;
	var txtICP     		=document.getElementById("txtICP").value;
	var txtUnicomIP   	=document.getElementById("txtUnicomIP").value;
	//var txtDNSName    =document.getElementById("txtDNSName").value;
	var txtBackup    	=document.getElementById("txtBackup").value;
	
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

	if (txtDomain.length==0 ){
		var boxURL="msg.php?1.9&msg=请输入要加速的域名";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');
		document.getElementById("txtDomain").focus();
	  	return false;
	}
	if (txtICP.length==0 ){
		var boxURL="msg.php?1.9&msg=请输入域名 ICP 备案号";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');
		document.getElementById("txtICP").focus();
	  	return false;
	}
	if (productSelect.length==0 ){ 
		var boxURL="msg.php?1.9&msg=请先购买一个产品套餐再添加域名。";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');
		return;
	}
 
  
var re =  /^([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])$/;  
if(!re.test(txtSrcIP)){  
    var boxURL="msg.php?1.9&msg=电信源站IP地址格式不正确。";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');	
		document.getElementById("txtSrcIP").focus();
	  	return false;
} 
	if (txtSrcIP.length==0 && txtUnicomIP.length==0){ 
		var boxURL="msg.php?1.9&msg=电信源站 IP 和联通源站 IP 至少填一个。";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');	
		document.getElementById("txtSrcIP").focus();
	  	return false;
	}	
	
	var postURL="./ajax_domain.php?mod=domain&action=add";
	var postStr="buy_id="+UrlEncode(productSelect) + "&domain=" + UrlEncode(txtDomain) + "&SSLOpt=" + SSLOpt + "&SSLCrtContent=" + UrlEncode(SSLCrtContent) + "&SSLKeyContent=" + UrlEncode(SSLKeyContent) + "&SSLExtraParams=" + UrlEncode(SSLExtraParams) + 
	"&srcip=" + UrlEncode(txtSrcIP) + "&unicom_ip="+UrlEncode(txtUnicomIP)+ "&UpsSSLOpt=" + UpsSSLOpt + "&upstream_add_type=" +selUpstreatType+
			"&icp=" + UrlEncode(txtICP) +"&dns_name=" + UrlEncode(txtDNSName) +"&backup=" + UrlEncode(txtBackup);		
	AjaxClientBasePost("domain","add","POST",postURL,postStr);
}

function FikCdn_ClientAddDomainResult(sResponse){
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		var nDomainId = json["id"];
		var sDomain = json["domain"];
		var SSLOpt = json["SSLOpt"];
		var UpsSSLOpt = json["UpsSSLOpt"];		
		var sUpstream = json["upstream"];
		var sUnicomIp = json["unicom_ip"];
		var sProductName = json["product_name"];
		var sStatus = json["status"];
		var sNote = json["note"];
		
		if(sUpstream.length>0 && sUnicomIp.length>0)
		{
			sUpstream += '/';
			sUpstream += sUnicomIp;
		}
		else if(sUnicomIp.length>0)
		{
			sUpstream = sUnicomIp;
		}
				
		var sNewItem = '<tr bgcolor="#FFFFFF" align="center" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">';
		sNewItem   	+=	'<td title="'+sNote+'" align="left">'+sDomain+'</td>';
		if(SSLOpt==0){
			sNewItem   	+= '<td align="center">HTTP</td>';
		}
		else if(SSLOpt==1){
			sNewItem   	+= '<td align="center">HTTPS</td>';
		}
		else if(SSLOpt==2){
			sNewItem   	+= '<td align="center">HTTP+HTTPS</td>';
		}		
		
		sNewItem   	+=	'<td align="left">'+sUpstream+'</td>';
		
		if(UpsSSLOpt==0){
			sNewItem   	+= '<td align="center">HTTP</td>';
		}
		else if(UpsSSLOpt==1){
			sNewItem   	+= '<td align="center">HTTPS</td>';
		}
		else if(UpsSSLOpt==2){
			sNewItem   	+= '<td align="center">HTTP+HTTPS</td>';
		}
				
		sNewItem   	+=	'<td>'+sProductName+'</td>';		
		sNewItem   	+= '<td>'+sStatus+'</td>';				
		sNewItem   	+= '<td align="right">0 MB</td>';		
		sNewItem   	+= '<td align="right">0</td>';				
		//sNewItem   	+= '<td>'+sNote+'</td>';
						
		sNewItem	+= '<td>  <a href="stat_domain_bandwidth.php?domain_id='+nDomainId+'" onclick="javescript:FikCdn_SelectDomainStat();" title="查看此域名流量统计信息">流量统计</a>&nbsp;';
		sNewItem    += '<a href="javascript:void(0);" onclick="javescript:FikCdn_ModifyDomainBox('+nDomainId+');" title="修改域名信息">修改</a>&nbsp;';
		sNewItem    += '&nbsp;<a href="javascript:void(0);" onclick="javescript:FikCdn_DelDomainBox('+nDomainId+');" title="删除节点信息">删除</a> </td>';
		sNewItem    += '</tr></table>';
								
		var boxURL="msg.php?1.8&msg=添加域名成功。";
		showMSGBOX('',300,100,BT,BL,120,boxURL,'操作提示:');
		document.getElementById("txtDomain").value="添加成功";
		window.location.href='domain_list.php';
	
		
		

		
		var nowHTML=parent.document.getElementById("div_search_result").innerHTML;
		var showHTML = nowHTML.split("</table>")[0];
			
		nowHTML = showHTML + sNewItem;		
		parent.document.getElementById("div_search_result").innerHTML=nowHTML;		
		
				
		//document.getElementById("txtSrcIP").value="";
		//document.getElementById("txtICP").value="";
		//document.getElementById("txtUnicomIP").value="";
		//document.getElementById("txtDNSName").value="";
		//document.getElementById("txtBackup").value="";		
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
	alert(opt);
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
			SSLAllParams.style.display="block";
			break;
		}
	}
}

</script>


		<div style="margin: 15px;">
			
			<button class="layui-btn" lay-submit="" lay-filter="demo1" onclick="window.location.href='domain_list.php'">返回域名列表</button>
			
			
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>添加域名</legend>
			</fieldset>

			<form class="layui-form" action="">
				<div class="layui-form-item">
					<label class="layui-form-label">源站电信IP</label>
					<div class="layui-input-inline">
						<input id="txtSrcIP" type="tel" name="tip" size="36" maxlength="64" lay-verify="tip" placeholder="请输入源站电信IP" autocomplete="off" class="layui-input">
						<span class="input_tips_txt" id="tipsSrcIP" name="tipsSrcIP" ></span> 
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">源站联通IP</label>
					<div class="layui-input-inline">
						<input id="txtUnicomIP" type="text" name="uip" size="36" maxlength="64" lay-verify="uip" placeholder="请输入源站联通IP" autocomplete="off" class="layui-input">
						<span class="input_tips_txt4" id="tipsUnicomIP" ></span>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">源站SSL项</label>
					<div class="layui-input-block">
						<input name="UpsSSLOpt" type="radio" id="SSLOpt_Http" value="0" title="HTTP"/>
						<input name="UpsSSLOpt" type="radio" id="SSLOpt_Https" value="1" title="HTTPS"/>
						<input name="UpsSSLOpt" type="radio" id="SSLOpt_HttpAndHttps" value="2" title="HTTP+HTTPS(默认)" checked=""/>
					</div>
				</div>
				<div class="layui-form-item">
						<label class="layui-form-label">域名链接</label>
						<div class="layui-input-block" style="width: 550px;">
							<input id="txtDomain" type="text" size="36"  maxlength="128" name="url" lay-verify="url" placeholder="请输入域名链接" autocomplete="off" class="layui-input">
							<span class="input_tips_txt" id="tipsDomain" name="tipsDomain" ></span>
						</div>
					</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">域名SSL项</label>
					<div class="layui-input-block">
						<input name="SSLOpt" type="radio" id="SSLOpt_Http" value="0" title="HTTP" checked="checked" onchange="ChangeSSLOpt(0)" lay-filter="HTTP">
						<input name="SSLOpt" type="radio" id="SSLOpt_Https" value="1" title="HTTPS" onchange="ChangeSSLOpt(1)" lay-filter="HTTPS">
						<input name="SSLOpt" type="radio" id="SSLOpt_HttpAndHttps" value="2" title="HTTP+HTTPS"  onchange="ChangeSSLOpt(2)" lay-filter="HTTP+HTTPS">
					</div>
				</div>

				<div id="SSLAllParams" style="display:none;">
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
					<label class="layui-form-label">源站配置项</label>
					<div class="layui-input-block">
						<input type="radio" name="selUpstreatType" id="selUpstreatType" value="0" title="自动匹配线路" checked="">
						<input type="radio" name="selUpstreatType" id="selUpstreatType" value="1" title="双源站配置">
					</div>
				</div>				
				<div class="layui-form-item">
					<label class="layui-form-label">域名ICP备案号</label>
					<div class="layui-input-block" style="width: 550px;">
						<input id="txtICP" type="text" name="record" size="36" maxlength="64" lay-verify="record" placeholder="请输入域名ICP备案号" autocomplete="off" class="layui-input">
						<span class="input_tips_txt" id="tipsICP" ></span>
					</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">产品套餐</label>
					<div class="layui-input-inline">
						<select id="productSelect" name="sale">
						 <?php
							date_default_timezone_set('PRC');
							$client_username 	=$_SESSION['fikcdn_client_username'];
							
							$db_link = FikCDNDB_Connect();
							if($db_link)
							{
								do
								{
									$sql = "SELECT * FROM fikcdn_buy WHERE username='$client_username';";
									$result = mysql_query($sql,$db_link);
									if(!$result)
									{
										break;
									}
									
									$row_count=mysql_num_rows($result);
									if(!$row_count)
									{
										break;
									}
									
									for($i=0;$i<$row_count;$i++)
									{
										$this_buy_id  		= mysql_result($result,$i,"id");	
										$product_id  	= mysql_result($result,$i,"product_id");	
										$this_username	= mysql_result($result,$i,"username");
										$domain_num	= mysql_result($result,$i,"domain_num");
										$end_time	= mysql_result($result,$i,"end_time");
										$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
										$result2 = mysql_query($sql,$db_link);
										$sql3="SELECT * FROM fikcdn_domain WHERE buy_id='$this_buy_id'";
										$result3= mysql_query($sql3,$db_link);
										$rows=mysql_num_rows($result3);
										$useable=$domain_num-$rows;
										if($result2 && mysql_num_rows($result2)>0 && $end_time>time())
										{
											$product_name  			= mysql_result($result2,0,"name");	
											
											if($this_buy_id)
											{
												echo '<option value="'.$this_buy_id.'" selected="selected">'.$product_name.'_'.$this_buy_id.'（已使用'.$rows.'个&nbsp&nbsp&nbsp剩余'.$useable.'个）</option>';
											}
											else
											{
												echo '<option value="'.$this_buy_id.'">'.$product_name.'_'.$this_buy_id.'（已使用'.$rows.'个域名&nbsp&nbsp&nbsp剩余'.$useable.'个）</option>';				
											}			
										}

									}
								}while(0);
								
								mysql_close($db_link);
							}			
						 ?>
					</select> <span class="input_tips_txt" id="tipsProductSelect" ></span>

					</div>
				</div>
							
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">备注</label>
					<div class="layui-input-block" style="width: 550px;">
						<textarea id="txtBackup" name="txtBackup" placeholder="" class="layui-textarea"></textarea>
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						
						<input name="btnAddDomain"  type="button" class="layui-btn" lay-submit="" lay-filter="demo1" id="btnAddDomain" value="保存" onclick="FikCdn_AddDomain();" />
						
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
			</form>		
			
			<div class="layui-form-item">
				同步说明：<br />
				1. 域名添加成功后，需要管理员审核通过后才生效,请与管理确认后再切换流量；
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
