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
	var timeval	 =document.getElementById("timeSelect").value;
	var pagesSelect  =document.getElementById("pagesSelect").value;
	window.location.href="buy_history.php?page="+pagesSelect+"&action=jump"+"&timeval="+timeval;
}

function fikcdn_search(){
	var txtKeyword   =document.getElementById("txtKeyword").value;
	var searchSelect =document.getElementById("searchSelect").value;
	var timeSelect	 =document.getElementById("timeSelect").value;

	if(txtKeyword.length==0 ){
		return;
	}	
	
	var getURL="./ajax_search.php?mod=search&action=buyhistory"+"&type="+UrlEncode(searchSelect) +"&keyword="+UrlEncode(txtKeyword)+"&timeval="+UrlEncode(timeSelect);
	
	AjaxBasePost("search","buyhistory","GET",getURL);			
}

function selectTimeval(){
	var txtTimeval		 =document.getElementById("timeSelect").value;
	window.location.href="buy_history.php?page=1"+"&action=jump"+"&timeval="+txtTimeval;
}

</script>
<!---------------->
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
				<legend>消费记录</legend>
				<div class="layui-field-box">
					<table class="site-table table-hover">
						<thead>
							<tr>
								<th>已购买套餐名称</th>
								<th>加速域名数</th>
								<th>月度总流量</th>
								<th>月份数</th>
								<th>价格(元/月)</th>
								<th>总金额(元)</th>
								<th>余额(元)</th>
								<th>购买日期</th>
								<th>到期日期</th>
								<th>购买IP</th>
								<th>购买类型</th>
								<th>备注</th>
							</tr>
						</thead>
						<tbody>
							<?php
	
	$nPage 		= isset($_GET['page'])?$_GET['page']:'';
	$action 	= isset($_GET['action'])?$_GET['action']:'';
	
	$client_username 					=$_SESSION['fikcdn_client_username'];
	
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
				$sql = "SELECT count(*) FROM fikcdn_buyhistory WHERE username='$client_username' AND buy_time>'$timeval';"; 
			}
			else
			{
				$sql = "SELECT count(*) FROM fikcdn_buyhistory WHERE username='$client_username';"; 
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
				$sql = "SELECT * FROM fikcdn_buyhistory WHERE username='$client_username' AND buy_time>'$timeval' ORDER BY id DESC Limit $offset,$PubDefine_PageShowNum;"; 
			}
			else
			{
				$sql = "SELECT * FROM fikcdn_buyhistory WHERE username='$client_username' ORDER BY id DESC Limit $offset,$PubDefine_PageShowNum;";
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
				$username  		= mysql_result($result,$i,"username");
				$buy_id	  		= mysql_result($result,$i,"buy_id");
				$price   		= mysql_result($result,$i,"price");	
				$month   		= mysql_result($result,$i,"month");
				$auto_renew		= mysql_result($result,$i,"auto_renew");
				$domain_num  	= mysql_result($result,$i,"domain_num");
				$data_flow  	= mysql_result($result,$i,"data_flow");
				$balance  		= mysql_result($result,$i,"balance");
				$buy_time   	= mysql_result($result,$i,"buy_time");
				$end_time   	= mysql_result($result,$i,"end_time");
				$buy_ip 		= mysql_result($result,$i,"ip");
				$type   		= mysql_result($result,$i,"type");
				$note   		= mysql_result($result,$i,"note");
				$frist_month_money   		= mysql_result($result,$i,"frist_month_money");
				
				$total_money = $price*$month; 
				
				$sql = "SELECT * FROM fikcdn_buy WHERE id='$buy_id'";
				$result2 = mysql_query($sql,$db_link);
				if($result2 && mysql_num_rows($result2)>0)
				{
					$product_id  = mysql_result($result2,0,"product_id");
					
					$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
					$result2 = mysql_query($sql,$db_link);
					if($result2 && mysql_num_rows($result2)>0)
					{
						$product_name  = mysql_result($result2,0,"name");
						//$product_name = $product_name.'('.$buy_id.')';
					}
				}
								
				echo '<tr bgcolor="#FFFFFF" align="center" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">';
				echo '<td>'.$product_name.'</td>';
				echo '<td>'.$domain_num.'</td>';
				echo '<td>'.PubFunc_MBToString($data_flow).'</td>';
				echo '<td>'.$month.'</td>';
				echo '<td>'.$price.'</td>';
				echo '<td>'.$total_money.'</td>';
				echo '<td>'.$balance.'</td>';
				echo '<td>'.date("Y-m-d",$buy_time).'</td>';
				echo '<td>'.date("Y-m-d",$end_time).'</td>';
				echo '<td>'.$buy_ip.'</td>';
				echo '<td>'.$PubDefine_BuyTypeStr[$type].'</td>';//或继费
				echo '<td>'.$note.'</td>';
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
							<li><a href="buy_history.php?page=1&action=first&timeval=<?php echo $timeval; ?>">首页</a></li>
							<li><a href="buy_history.php?page=<?php echo $pageup; ?>&action=pageup&timeval=<?php echo $timeval; ?>">上一页</a></li>
							<li><a href="buy_history.php?page=<?php echo $pagedown; ?>&action=pagedown&timeval=<?php echo $timeval; ?> ">下一页</a></li>
							<li><a href="buy_history.php?page=<?php echo $total_pages; ?>&action=tail&timeval=<?php echo $timeval; ?>">尾页 </a></li>
					</ul>
				</div>
			</div>

		</div>
		<script type="text/javascript" src="plugins/layui/layui.js"></script>
<!----------------->

<?php

include_once("./tail.php");
?>
