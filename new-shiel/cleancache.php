<?php
include_once("./head.php");
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
<script language="javascript" src="../js/calendar.js"></script>

<script type="text/javascript">
function FikCdn_CleanCache(){
	var productSelect =document.getElementById("productSelect").value; 
	var txtUrl1    =document.getElementById("txtUrl1").value;
	var txtUrl2    =document.getElementById("txtUrl2").value;
	var txtUrl3    =document.getElementById("txtUrl3").value;	
		
	if(productSelect.length==0)
	{
		document.getElementById("tipsProductSelect").innerHTML="您无购买产品套餐，不能更新缓存文件";	
		return false;
	}
	else
	{
		document.getElementById("tipsProductSelect").innerHTML="";
	}
		
	if (txtUrl1.length==0 && txtUrl2.length==0 && txtUrl3.length==0 ){ 
		document.getElementById("tipsUrl1").innerHTML="请输入要更新的缓存文件 URL 地址";
		document.getElementById("txtUrl1").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsUrl1").innerHTML="";
	}
	
	var postURL="./ajax_domain.php?mod=domain&action=cleancache";
	var postStr="buy_id=" + productSelect + "&url1=" + UrlEncode(txtUrl1) + "&url2=" + UrlEncode(txtUrl2)+ "&url3=" + UrlEncode(txtUrl3);
					 
	AjaxClientBasePost("domain","cleancache","POST",postURL,postStr);	
}

function FikCdn_ClientClearCacheDomainResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){		
		var boxURL="msg.php?1.9&msg=缓存更新任务已经提交到后台任务队列中，后台任务执行程序会在一分钟内开始逐个更新各个节点服务器缓存。";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');
					
		document.getElementById("txtUrl1").value="";
		document.getElementById("txtUrl2").value="";
		document.getElementById("txtUrl3").value="";
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

function FikCdn_CleanDirCache(){
	var domainSelect =document.getElementById("domainSelect").value; 
	var txtDirUrl    =document.getElementById("txtDirUrl").value;

	if(domainSelect.length==0)
	{
		document.getElementById("tipsDomainSelect").innerHTML="无域名，不能更新目录缓存";	
		return false;
	}
	else
	{
		document.getElementById("tipsDomainSelect").innerHTML="";
	}
		
	if (txtDirUrl.length==0){ 
		document.getElementById("tipsDirUrl").innerHTML="请输入需更新的缓存目录 URL 链接地址";
		document.getElementById("txtDirUrl").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsDirUrl").innerHTML="";
	}
	
	var postURL="./ajax_domain.php?mod=domain&action=cleandircache";
	var postStr="domain_id=" + domainSelect + "&url=" + UrlEncode(txtDirUrl);
					 
	AjaxClientBasePost("domain","cleandircache","POST",postURL,postStr);	
}

function FikCdn_ClientCleanDirCacheResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){		
		var boxURL="msg.php?1.9&msg=缓存更新任务已经提交到后台任务队列中，后台任务执行程序会在一分钟内开始逐个更新各个服务器缓存。";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');		
		document.getElementById("txtDirUrl").value="";
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
<!------------->
		<div style="margin: 15px;">
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>网站目录缓存更新：</legend>
			</fieldset>

			<form class="layui-form" action="">
				<div class="layui-form-item">
					<label class="layui-form-label">清理域名</label>
					<div class="layui-input-inline">
						<select id="domainSelect" lay-verify="domain" >
							  <?php	
							  $client_username 	= $_SESSION['fikcdn_client_username'];
								$db_link = FikCDNDB_Connect();
								if($db_link)
								{
									$sql = "SELECT * FROM fikcdn_domain WHERE username='$client_username';"; 
									$result = mysql_query($sql,$db_link);
									if($result)
									{
										$row_count=mysql_num_rows($result);
										for($i=0;$i<$row_count;$i++)
										{
											$domain_id	= mysql_result($result,$i,"id");
											$hostname	= mysql_result($result,$i,"hostname");	
											echo '<option value="'.$domain_id.'">'.$hostname."</option>";									
										}
									}
								
									mysql_close($db_link);
								}			
							 ?>
				</select> <span class="input_tips_txt" id="tipsDomainSelect" ></span>

					</div>
				</div>

				<div class="layui-form-item">
					<label class="layui-form-label">目录地址</label>
					<div class="layui-input-block">
						<input id="txtDirUrl" type="text" size="85" maxlength="1024"  lay-verify="title" autocomplete="off" placeholder="请输入URL目录地址" class="layui-input"/> <span class="input_tips_txt" id="tipsDirUrl" ></span>
					</div>
				</div>

				<div class="layui-form-item">
					<div class="layui-input-block">
						<input id="Btn_CleanDirCache" type="button" class="layui-btn" lay-submit="" lay-filter="demo1"  value="提交" onClick="FikCdn_CleanDirCache();"/>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
			</form>
			
			<div class="layui-form-item">
					目录更新说明：<br />
					1、目录文件缓存更新可以做全站更新或者更新某个目录下的所有文件，例如：<br />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a、全站更新所有已缓存的文件 URL 目录地址用：* <br />
					    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b、更新目录下所有已缓存的文件 URL 目录地址用：css/* <br />
					2、缓存更新任务提交到后台任务队列后，系统后台会在几分钟内提交到各个节点服务器上一一执行；
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
					title: function(value) {
						if(value.length < 5) {
							
						}
					},
					domain: function(value) {
						if(value == "") {
						}
					}
				});

			});
		</script>

<!------------->



<?php

include_once("./tail.php");
?>
