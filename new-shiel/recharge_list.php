<?php
include_once("./head.php");

$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="css/global.css" media="all">
<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="css/table.css" />
<link rel="stylesheet" href="css/page.css" />
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />

<script type="text/javascript">
function selectPage(obj){
	var timeval		 =document.getElementById("timeSelect").value;
	var pagesSelect  =document.getElementById("pagesSelect").value;
	window.location.href="recharge_list.php?page="+pagesSelect+"&action=jump"+"&timeval="+timeval;
}

function fikagent_search(){
	var txtKeyword   =document.getElementById("txtKeyword").value;
	var searchSelect =document.getElementById("searchSelect").value;
	var timeSelect	 =document.getElementById("timeSelect").value;

	if(txtKeyword.length==0 ){
		return;
	}	
	
	var getURL="./ajax_search.php?mod=search&action=recharge"+"&type="+UrlEncode(searchSelect) +"&keyword="+UrlEncode(txtKeyword)+"&timeval="+UrlEncode(timeSelect);
	
	AjaxBasePost("search","recharge","GET",getURL);			
}

function selectTimeval(){
	var txtTimeval		 =document.getElementById("timeSelect").value;
	window.location.href="recharge_list.php?page=1"+"&action=jump"+"&timeval="+txtTimeval;
}


var ___nOrderId;
function FikCDN_DelRechgOrderBox(order_id)
{
	___nOrderId = order_id;
	var boxURL="msg.php?1.7";
	showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');	
}

function FikCDN_DelRechgOrder()
{
	var postURL="./ajax_buy.php?mod=order&action=rechdel";
	var postStr="order_id="+UrlEncode(___nOrderId);
	AjaxClientBasePost("order","rechdel","POST",postURL,postStr);
	
}

function FikCDN_DelOrderResult(sResponse){
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		var order_id = json["order_id"];
		location.reload();
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
<!--------------------->
<div class="admin-main">
			<div>
				
				<div style="float: right;">
					<form action="">
					<div class="layui-form-item">
					<label class="layui-form-label"></label>
					<div class="layui-input-inline">
						 &nbsp;
					</div>
					<label class="layui-form-label">日期查询</label>
					<div class="layui-input-inline">
						 <select id="timeSelect" style="height: 37px; width: 190px; border:1px solid #e6e6e6; text-align:center" onChange="selectTimeval()">
							<option value="0" <?php if($timeval==0 || strlen($timeval)<=0 ) echo 'selected="selected"';   ?> >所有记录</option>
							<option value="7" <?php if($timeval==7 ) echo 'selected="selected"';   ?> >最近一星期</option>	
							<option value="30" <?php if($timeval==30 ) echo 'selected="selected"';   ?> >最近一个月</option>	
							<option value="90" <?php if($timeval==90 ) echo 'selected="selected"';   ?> >最近三个月</option>
							<option value="180" <?php if($timeval==180) echo 'selected="selected"';   ?> >最近六个月</option>		
							<option value="365" <?php if($timeval==365 ) echo 'selected="selected"';   ?> >最近一年</option>						
						</select>
					</div>
					<!--<button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>&nbsp;&nbsp;-->
				</div>
				</form>	
				</div>	
			</div>
				
			<fieldset class="layui-elem-field" style="width:100%;">
				<legend>充值记录</legend>
				<div class="layui-field-box">
					<table class="site-table table-hover">
						<thead>
							<tr>
								<th>订单号</th>
								<th >充值日期</th>
								<th >充值金额</th>
								<th >充值前余额</th>
								<th >订单状态</th>
								<th >支付宝交易号</th>
								<th>备注</th>
								<th >操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
	
	$nPage 		= isset($_GET['page'])?$_GET['page']:'';
	$action 	= isset($_GET['action'])?$_GET['action']:'';
	
	$client_username 	= $_SESSION['fikcdn_client_username'];
	
	if(!is_numeric($nPage))
	{
		$nPage=1;
	}
	
	if($nPage<=0)
	{
		$nPage = 1;
	}		
	
	if($action!="frist" && $action !="pagedown" && $action !="pageup" && $action !="tail" && $action !="jump")
	{
		$action="frist";
	}
		
	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		do
		{		
			$total_host 	= 0;
			
			if($timeval>1000) $timeval=1000;
			
			if($timeval>0)
			{
				$timeval = (time()-$timeval*60*60*24);
				$sql = "SELECT count(*) FROM fikcdn_recharge WHERE username='$client_username' AND time>'$timeval';"; 
			}
			else
			{
				$sql = "SELECT count(*) FROM fikcdn_recharge WHERE username='$client_username';"; 
			}
			
			$result = mysql_query($sql,$db_link);
			if($result&&mysql_num_rows($result)>0)
			{
				$total_host  = mysql_result($result,0,"count(*)");	
			}
			
			$total_pages = floor($total_host/$PubDefine_PageShowNum);
			if(($total_host%$PubDefine_PageShowNum)>0)
			{
				$total_pages+=1;
			}
			
			if($nPage>$total_pages)
			{
				$nPage = $total_pages;
			}
			
			$pagedown = $nPage+1;
			if($pagedown>$total_pages)
			{	
				$pagedown = $total_pages;			
			}
			
			$pageup = $nPage-1;
			if($pageup<=0)
			{
				$pageup = 1;
			}			
			$offset = (($nPage-1)*$PubDefine_PageShowNum);
			if($offset<0) $offset=0;
			
			if($timeval>0)
			{
				$sql = "SELECT * FROM fikcdn_recharge WHERE username='$client_username' AND time>'$timeval' ORDER BY id DESC Limit $offset,$PubDefine_PageShowNum; "; 
			}
			else
			{
				$sql = "SELECT * FROM fikcdn_recharge WHERE username='$client_username' ORDER BY id DESC Limit $offset,$PubDefine_PageShowNum;";
			}
		
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
				$id  			= mysql_result($result,$i,"id");	
				$order_id   	= mysql_result($result,$i,"order_id");
				$ali_trade_no  	= mysql_result($result,$i,"ali_trade_no");
				$status   		= mysql_result($result,$i,"status");
				$username   	= mysql_result($result,$i,"username");
				$money   		= mysql_result($result,$i,"money");	
				$time  		 	= mysql_result($result,$i,"time");	
				$transactor   	= mysql_result($result,$i,"transactor");	
				$bank_name   	= mysql_result($result,$i,"bank_name");	
				$serial_no   	= mysql_result($result,$i,"serial_no");
				$balance	   	= mysql_result($result,$i,"balance");
				$note   	    = mysql_result($result,$i,"note");
				
				echo '<tr bgcolor="#FFFFFF" align="center" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">';
				echo '<td align="left">'.$order_id.'</td>';	
				echo '<td>'.date("Y-m-d H:i:s",$time).'</td>';
				echo '<td align="right">'.$money.' 元</td>';	
				echo '<td align="right">'.$balance.' 元</td>';
				if($status==0 || strlen($order_id)<=0)
				{
					echo '<td>'." 支付成功".'</td>';	
				}
				else
				{
					echo '<td>'." 等待支付".'</td>';				
				}
				echo '<td>'.$ali_trade_no.'</td>';	
				echo '<td align="left">'.$note.'</td>';			
				
				if($status==0 || strlen($order_id)<=0)
				{
					echo '<td></td>';	
				}
				else
				{
					echo '<td align="left"> <a href="alipay.php?order_id='.$order_id.'" title="立即支付">立即支付</a>&nbsp;
								<a href="#" onclick="FikCDN_DelRechgOrderBox(\''.$order_id.'\')">删除</a>&nbsp;
						  </td>';
				}
				echo '</tr>';
			}
		}while(0);
		
		mysql_close($db_link);
	}
?>
						</tbody>
					</table>

				</div>
			</fieldset>
			
			<div>
				<div style="float: left;" class="leftPagination">
					共 <?php echo $total_host;?> 记录，当前第 <?php echo $nPage; ?> 页，共 <?php echo $total_pages; ?> 页&nbsp;&nbsp;&nbsp;跳转
						<select id="pagesSelect" name="pagesSelect" style="width:50px" onChange="selectPage(this)">
						<?php
							for($i=1;$i<=$total_pages;$i++){
								if($nPage==$i)
								{
									echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
								}
								else
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							}
						?>							
						</select>
						页
				</div>
				<div style="float: right;">
						<ul class="pagination pagination-centered">
							<li><a href="recharge_list.php?page=1&action=first&timeval=<?php echo $timeval; ?>">首页</a></li>
							<li><a href="recharge_list.php?page=<?php echo $pageup; ?>&action=pageup&timeval=<?php echo $timeval; ?>">上一页</a></li>
							<li><a href="recharge_list.php?page=<?php echo $pagedown; ?>&action=pagedown&timeval=<?php echo $timeval; ?> ">下一页</a></li>
							<li><a href="recharge_list.php?page=<?php echo $total_pages; ?>&action=tail&timeval=<?php echo $timeval; ?>">尾页 </a></li>
					</ul>
				</div>
			</div>

		</div>
		<script type="text/javascript" src="plugins/layui/layui.js"></script>
<!----------------------->
<?php

include_once("./tail.php");
?>
