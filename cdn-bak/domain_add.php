<?php
include_once("./head2.php");
?>
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
		document.getElementById("txtDomain").value="";
		
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
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0" class="normal">
  <tr>
    <td width="140" height="25" class="objTitle" title="" ><span class="input_red_tips">*</span>域名：</td>
    <td width="320">
		<input id="txtDomain" type="text" size="36" class="inputText" style="width:320px;height:16px" maxlength="128"  /> <span class="input_tips_txt" id="tipsDomain" name="tipsDomain" ></span>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  <tr>
	<td width="140" height="25" class="objTitle" title="相关示例，可参看【相关使用帮助】" >域名SSL选项：</td>
	<td width="320">
	  <input name="SSLOpt" type="radio" class="radio" id="SSLOpt_Http" value="0" checked="checked" onchange="ChangeSSLOpt(0)" />HTTP &nbsp;&nbsp;
      <input name="SSLOpt" type="radio" class="radio" id="SSLOpt_Https" value="1" onchange="ChangeSSLOpt(1)" />HTTPS &nbsp;&nbsp;
      <input name="SSLOpt" type="radio" class="radio" id="SSLOpt_HttpAndHttps" value="2" onchange="ChangeSSLOpt(2)" />HTTP+HTTPS
	</td>
  </tr>
  
 <tr id="SSLAllParams" style="display:none">
    <td colspan="2">
		<table width="550" border="0" align="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="142" height="72" class="objTitle" title="相关示例，可参看【相关使用帮助】" valign="top" >*SSL证书文件内容：<br /><span style="font-style:italic;font-size:10px">SSL Certificate File&nbsp;<br />Content&nbsp;</span></td>
			<td width="325" height="72" valign="top">
			<textarea name="SSLCrtContent" class="inputText" id="SSLCrtContent" style="margin-top:5px;width:317px;height:60px;font-size:11px;border:1px solid #94C7E7;color:#00BFAA;;overflow:auto;"></textarea>
			</td>
		  </tr>
		  <tr>
			<td width="142" height="72" class="objTitle" title="相关示例，可参看【相关使用帮助】" valign="top" >*SSL私钥文件内容：<br /><span style="font-style:italic;font-size:10px">SSL Private Key File&nbsp;<br />Content&nbsp;</span></td>
			<td width="325" height="72" valign="top">
			<textarea name="SSLKeyContent" class="inputText" id="SSLKeyContent" style="margin-top:5px;width:317px;height:60px;font-size:11px;border:1px solid #94C7E7;color:#00BFAA;overflow:auto;"></textarea>
			</td>
		  </tr>
		  <tr>
			<td width="142" height="25" class="objTitle" title="相关示例，可参看【相关使用帮助】" valign="middle" >SSL附加配置参数：</td>
			<td width="325" height="25" valign="middle">
			<input name="SSLExtraParams" type="text" class="inputText" id="SSLExtraParams" style="width:321px;height:18px" value="SessionSize=5000&Password=" title="相关示例，可参看【相关使用帮助】" />
			</td>
		  </tr>
		</table>
	</td>
  </tr>
      
  <tr>
    <td height="25" class="objTitle"  title="如果有多个电信源站，可用“;”间隔，如：211.155.23.66;234.34.55.123" ><span class="input_red_tips">*</span>源站电信 IP：</td>
    <td>
		<input id="txtSrcIP" type="text" class="inputText" style="width:320px;height:16px" size="36" maxlength="64"  title="如果有多个电信源站，可用“;”间隔，如：211.155.23.66;234.34.55.123" /> <span class="input_tips_txt" id="tipsSrcIP" name="tipsSrcIP" ></span>  
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  <tr>
    <td height="25" class="objTitle" title="如果有多个联通源站，可用“;”间隔，如：211.155.23.66;234.34.55.123"  >源站联通 IP：</td>
    <td>
		<input id="txtUnicomIP" type="text" class="inputText" style="width:320px;height:16px" size="36" maxlength="64"  title="如果有多个联通源站，可用“;”间隔，如：211.155.23.66;234.34.55.123"  /><span class="input_tips_txt4" id="tipsUnicomIP" ></span>
	</td>
  </tr>
  <tr>
	<td width="140" height="25" class="objTitle" title="相关示例，可参看【相关使用帮助】" >源站SSL选项：</td>
	<td width="320">
	  <input name="UpsSSLOpt" type="radio" class="radio" id="SSLOpt_Http" value="0" />HTTP &nbsp;&nbsp;
      <input name="UpsSSLOpt" type="radio" class="radio" id="SSLOpt_Https" value="1" />HTTPS &nbsp;&nbsp;
      <input name="UpsSSLOpt" type="radio" class="radio" id="SSLOpt_HttpAndHttps" value="2"  checked="checked" />HTTP+HTTPS(默认)
	</td>
  </tr>
    
 <tr>
    <td height="6" colspan="2"></td>
  </tr>
  <tr>
    <td height="25" class="objTitle" title="" >源站配置方式：</td>
    <td>
	  <input name="selUpstreatType" type="radio" class="radio" id="selUpstreatType" value="0" checked="checked" title="根据节点服务器线路类型匹配相同线路的源站添加到源站列表中。"/><label title="根据节点服务器线路类型匹配相同线路的源站添加到源站列表中。">自动匹配线路</label>&nbsp;&nbsp;
      <input name="selUpstreatType" type="radio" class="radio" id="selUpstreatType" value="1" title="电信和联通源站IP全部添加到节点服务器的源站列表中。"/><label title="电信和联通源站IP全部添加到节点服务器的源站列表中。">双源站配置</label>&nbsp;&nbsp;
	</td>
  </tr>
    
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  <tr>
    <td height="25" class="objTitle" title="仅作为记录域名的 ICP 备案号，方便管理。" ><span class="input_red_tips">*</span>域名 ICP 备案号：</td>
    <td>
		<input id="txtICP" type="text" class="inputText" style="width:320px;height:16px" size="36" maxlength="64" title="仅作为记录域名的 ICP 备案号，方便管理。" /> <span class="input_tips_txt" id="tipsICP" ></span>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  <tr>
    <td height="25" class="objTitle" title="" >已出售产品套餐：</td>
    <td>
		<select id="productSelect" style="width:321px;height:24px;border:1px solid #94c6e1;">
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
						echo '<option value="'.$this_buy_id.'" selected="selected">'.$product_name.'（已使用'.$rows.'个&nbsp&nbsp&nbsp剩余'.$useable.'个）</option>';
					}
					else
					{
						echo '<option value="'.$this_buy_id.'">'.$product_name.'（已使用'.$rows.'个域名&nbsp&nbsp&nbsp剩余'.$useable.'个）</option>';				
					}			
				}

			}
		}while(0);
		
		mysql_close($db_link);
	}			
 ?>
				</select> <span class="input_tips_txt" id="tipsProductSelect" ></span>
	</td>
  </tr>
  <tr>
    <td height="6" colspan="2"></td>
  </tr>
  <tr>
    <td height="25" class="objTitle" title="" >备注：</td>
    <td>
		<textarea id="txtBackup" name="txtBackup" style="width:316px;height:46px;font-size:14px;border:1px solid #94C7E7;overflow:auto;" ></textarea>
	</td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2">
	    <center><input name="btnAddDomain"  type="submit" style="width:95px;height:28px" id="btnAddDomain" value="保存" style="cursor:pointer;" onclick="FikCdn_AddDomain();" /></center></td>
  </tr>
</table>
<table width="550" border="0">
	<tr>
	<td><p style="padding-left:25px;">同步说明：<br />
	1. 域名添加成功后，需要管理员审核通过后才生效,请与管理确认后再切换流量；<br />
	</p></td>
	</tr>
</table>

<?php

include_once("./tail.php");
?>
