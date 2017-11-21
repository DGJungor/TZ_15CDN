<?php
include_once("./head.php");
$group_id 		= isset($_GET['id'])?$_GET['id']:'1';
$order_type		= isset($_GET['order_type'])?$_GET['order_type']:'';
$order_field 	= isset($_GET['order_field'])?$_GET['order_field']:'';

if(strlen($order_type)<=0)
{
	$order_type="desc";
}

if(strlen($order_field)<=0)
{
	$order_field="CurrentUserConnections";
}
?>
<script type="text/javascript">	

function selectPage(obj){
	var pagesSelect  =document.getElementById("pagesSelect").value;
	var order_type		 =document.getElementById("orderTypeSelect").value;
	var order_field		 =document.getElementById("orderFieldSelect").value;
	window.location.href="group_stat_node_hostorder.php?page="+pagesSelect+"&action=jump"+"&id="+group_id+"&order_type="+order_type+"&order_field="+order_field;
}

function OnSelectOrderType(group_id){
	var order_type		 =document.getElementById("orderTypeSelect").value;
	var order_field		 =document.getElementById("orderFieldSelect").value;
	window.location.href="group_stat_node_hostorder.php?page="+1+"&action=jump"+"&id="+group_id+"&order_type="+order_type+"&order_field="+order_field;
}

function OnSelectFieldType(group_id){
	var order_type		 =document.getElementById("orderTypeSelect").value;
	var order_field		 =document.getElementById("orderFieldSelect").value;
	window.location.href="group_stat_node_hostorder.php?page="+1+"&action=jump"+"&id="+group_id+"&order_type="+order_type+"&order_field="+order_field;
}

function OnSelectNode()
{
	var order_type		 =document.getElementById("orderTypeSelect").value;
	var order_field		 =document.getElementById("orderFieldSelect").value;
	var txtSelectNode = document.getElementById("SelectNode").value;
	window.location.href="group_stat_node_hostorder.php?id="+txtSelectNode+"&order_type="+order_type+"&order_field="+order_field;
}

</script>

<div style="min-width:1000px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2" >
			<tr height="31" class="TabToolTitle">
				<td height="31" width="85"><a href="group_stat_node_bandwidth.php?id=<?php echo $group_id; ?>"><span class="title_bt_active">实时带宽</span></a></td>
				<td height="31" width="85"><a href="group_stat_node_bandwidth_max.php?id=<?php echo $group_id; ?>"><span class="title_bt_active">峰值带宽</span></a></td>
				<td height="31" width="85"><a href="group_stat_node_day_download.php?id=<?php echo $group_id; ?>"><span class="title_bt_active">日流量统计</span></a></td>				
				<td height="31" width="85"><a href="group_stat_node_conn.php?id=<?php echo $group_id; ?>"><span class="title_bt_active">连接数统计</span></a></td>
				<td height="31" width="85"><a href="group_stat_node_hostorder.php?id=<?php echo $group_id; ?>"><span class="title_bt">最新排名</span></a></td>
				<td width="95%"></td>
			</tr>
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
  <tr height="500">
	  <td valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td> 
	  <td valign="top">
	  		<table width="1000" border="0" class="dataintable">
			<tr height="30">
			<td><span class="input_tips_txt3">最近10分钟内流量排名:</span>
			<div class="div_search_title">
		<select id="SelectNode" style="width:280px" onChange="OnSelectNode()">
 	<?php  
	   
	$group_id 	= isset($_GET['id'])?$_GET['id']:'1';
	$show_this_name="";
  	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		$group_id 	= mysql_real_escape_string($group_id); 
		$sql = "SELECT * FROM fikcdn_group;"; 
		$result = mysql_query($sql,$db_link);
		if($result)
		{
			$row_count=mysql_num_rows($result);
			for($i=0;$i<$row_count;$i++)
			{
				$this_group_id	= mysql_result($result,$i,"id");	
				$group_name  	= mysql_result($result,$i,"name");	
				 
				
				if(strlen($group_id)<=0) $group_id = $this_group_id;
				
				 
				 
				$show_name = $group_name;
	
				if($this_group_id==$group_id)
				{
					echo '<option value="'.$this_group_id.'" selected="selected" >'.$show_name.'</option>';
					
					$show_this_name = $group_name;	
				}
				else
				{
					echo '<option value="'.$this_group_id.'" >'.$show_name.'</option>';
				}
			}
		}
		
	 
		
		// 计算最大带宽
		/*$timenow=time();
		$timeval = $timenow-24*60*60;
		$sql = "SELECT max(down_increase),max(up_increase),avg(down_increase),avg(up_increase) FROM realtime_list WHERE group_id=$group_id AND time>=$timeval";
		$result2 = mysql_query($sql,$db_link);
		if($result2 && mysql_num_rows($result2)>0)
		{
			$max1_down_increase = mysql_result($result2,0,"max(down_increase)");
			$max1_up_increase = mysql_result($result2,0,"max(up_increase)");		
			$avg1_down_increase = mysql_result($result2,0,"avg(down_increase)");
			$avg1_up_increase = mysql_result($result2,0,"avg(up_increase)");		
			
			$max1_down_increase = round($max1_down_increase,2);
			$max1_up_increase = round($max1_up_increase,2);
			$avg1_down_increase = round($avg1_down_increase,2);
			$avg1_up_increase = round($avg1_up_increase,2);									
		}
		
		if(strlen($max1_down_increase)<=0) $max1_down_increase=0;
		if(strlen($max1_up_increase)<=0) $max1_up_increase=0;
		if(strlen($avg1_down_increase)<=0) $avg1_down_increase=0;
		if(strlen($avg1_up_increase)<=0) $avg1_up_increase=0;	*/		
		
		// 计算最大带宽
		/*$timeval = $timenow-24*60*60*3;
		$sql = "SELECT max(down_increase),max(up_increase) FROM realtime_list WHERE group_id=$group_id AND time>=$timeval";
		$result2 = mysql_query($sql,$db_link);
		if($result2 && mysql_num_rows($result2)>0)
		{
			$max7_down_increase = mysql_result($result2,0,"max(down_increase)");
			$max7_up_increase = mysql_result($result2,0,"max(up_increase)");		
	
			$max7_down_increase = round($max7_down_increase,2);
			$max7_up_increase = round($max7_up_increase,2);								
		}	
		
		if(strlen($max7_down_increase)<=0) $max7_down_increase=0;
		if(strlen($max7_up_increase)<=0) $max7_up_increase=0;	*/					
	}

?>
				</select>&nbsp;
 	
				排序方式：					
				<select id="orderTypeSelect" name="orderTypeSelect" style="width:65px" onChange="OnSelectOrderType(<?php echo $group_id;?>)">
				<option value="desc" <?php if($order_type=='desc')  echo 'selected="selected"'; ?>>降序</option>
					<option value="asc" <?php if($order_type=='asc')  echo 'selected="selected"'; ?>>升序</option>
				</select>	
				<select id="orderFieldSelect" name="orderFieldSelect" style="width:150px" onChange="OnSelectFieldType(<?php echo $group_id;?>)">
					<option value="CurrentUserConnections" <?php if($order_field=='CurrentUserConnections')  echo 'selected="selected"'; ?>>用户连接数</option>
					<option value="CurrentUpstreamConnections" <?php if($order_field=='CurrentUpstreamConnections')  echo 'selected="selected"'; ?>>源站连接数</option>
					<option value="down_increase" <?php if($order_field=='down_increase')  echo 'selected="selected"'; ?>>用户下载数据</option>					
					<option value="up_increase" <?php if($order_field=='up_increase')  echo 'selected="selected"'; ?>>用户上传数据</option>
					<option value="bandwidth_down" <?php if($order_field=='bandwidth_down')  echo 'selected="selected"'; ?>>用户下载带宽</option>
					<option value="bandwidth_up" <?php if($order_field=='bandwidth_up')  echo 'selected="selected"'; ?>>用户上传带宽</option>
					<option value="upstream_down_increase" <?php if($order_field=='upstream_down_increase')  echo 'selected="selected"'; ?>>源站上传数据</option>
					<option value="upstream_up_increase" <?php if($order_field=='upstream_up_increase')  echo 'selected="selected"'; ?>>源站下载数据</option>
					<option value="upstream_bandwidth_down" <?php if($order_field=='upstream_bandwidth_down')  echo 'selected="selected"'; ?>>源站上传带宽</option>
					<option value="upstream_bandwidth_up" <?php if($order_field=='upstream_bandwidth_up')  echo 'selected="selected"'; ?>>源站下载带宽</option>
				</select>
				</div></td>
			</tr>
		</table>	
		<div id="div_search_result">
					<table width="800" border="0" class="dataintable" id="domain_table">
				<tr id="tr_domain_title">
					<th align="center" width="150">时间</th> 
					<th  width="80" align="center">IP</th>
					<th  width="80" align="center">用户连接数</th>
					<th  width="80" align="center">源站连接数</th>			
					<th align="right" width="100">用户下载数据</th>
					<th align="right" width="100">用户上传数据</th>
					<th align="right" width="100">用户下载带宽</th>
					<th align="right" width="100" align="center">用户上传带宽</th>
					<th align="right" width="100">源站上传数据</th>
					<th align="right" width="100">源站下载数据</th>
					<th align="right" width="100">源站上传带宽</th>
					<th align="right" width="100" align="center">源站下载带宽</th>		
				</tr>	
<?php				
 $timeval = time()-60*10;
  	 
	$nPage 		= isset($_GET['page'])?$_GET['page']:'';
	$action 	= isset($_GET['action'])?$_GET['action']:'';
	
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
 	$total_host 	= 0;
	
	$sql = "SELECT count(a.node_id) sum_n FROM (SELECT distinct node_id FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval') a";
	$result = mysql_query($sql,$db_link);
	if($result&&mysql_num_rows($result)>0)
	{
		$total_host  = mysql_result($result,0,"sum_n");	
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

	if($order_type=="asc")
	{
		if($order_field=='CurrentUserConnections')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by CurrentUserConnections ASC Limit $offset,$PubDefine_PageShowNum;";
			 
		}
		else if($order_field=='CurrentUpstreamConnections')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by CurrentUpstreamConnections ASC Limit $offset,$PubDefine_PageShowNum;";
		}				
		else if($order_field=='down_increase')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by down_increase ASC Limit $offset,$PubDefine_PageShowNum;";
		}
		else if($order_field=='up_increase')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by up_increase ASC Limit $offset,$PubDefine_PageShowNum;";
		}
		else if($order_field=='bandwidth_down')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by bandwidth_down ASC Limit $offset,$PubDefine_PageShowNum;";
		}
		else if($order_field=='bandwidth_up')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by bandwidth_up ASC Limit $offset,$PubDefine_PageShowNum;";
		}				
		else if($order_field=='upstream_down_increase')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by upstream_down_increase ASC Limit $offset,$PubDefine_PageShowNum;";
		}	
		else if($order_field=='upstream_up_increase')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by upstream_up_increase ASC Limit $offset,$PubDefine_PageShowNum;";
		}
		else if($order_field=='upstream_bandwidth_down')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by upstream_bandwidth_down ASC Limit $offset,$PubDefine_PageShowNum;";
		}	
		else
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by upstream_bandwidth_up ASC Limit $offset,$PubDefine_PageShowNum;";
		}						
		
	}
	else
	{
		if($order_field=='CurrentUserConnections')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by CurrentUserConnections DESC Limit $offset,$PubDefine_PageShowNum;";
		}
		else if($order_field=='CurrentUpstreamConnections')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by CurrentUpstreamConnections DESC Limit $offset,$PubDefine_PageShowNum;";
		}				
		else if($order_field=='down_increase')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by down_increase DESC Limit $offset,$PubDefine_PageShowNum;";
		}
		else if($order_field=='up_increase')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by up_increase DESC Limit $offset,$PubDefine_PageShowNum;";
		}
		else if($order_field=='bandwidth_down')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by bandwidth_down DESC Limit $offset,$PubDefine_PageShowNum;";
		}	
		else if($order_field=='bandwidth_up')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by bandwidth_up DESC Limit $offset,$PubDefine_PageShowNum;";
		}
		else if($order_field=='upstream_down_increase')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by upstream_down_increase DESC Limit $offset,$PubDefine_PageShowNum;";
		}	
		else if($order_field=='upstream_up_increase')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by upstream_up_increase DESC Limit $offset,$PubDefine_PageShowNum;";
		}	
		else if($order_field=='upstream_bandwidth_down')
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by upstream_bandwidth_down DESC Limit $offset,$PubDefine_PageShowNum;";
		}		
		else
		{
			$sql="SELECT node_id,time,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(down_increase) down_increase,sum(up_increase) up_increase,sum(upstream_down_increase) upstream_down_increase,sum(upstream_up_increase) upstream_up_increase,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>='$timeval' group BY node_id order by upstream_bandwidth_up DESC Limit $offset,$PubDefine_PageShowNum;";
		}
	}
		
	$result = mysql_query($sql,$db_link);
	if(!$result)
	{
		exit();
	}
	
	$row_count=mysql_num_rows($result);
	if(!$row_count)
	{
		exit();
	}
	
	for($i=0;$i<$row_count;$i++){
		$node_id  		= mysql_result($result,$i,"node_id"); 
		$this_time  		= mysql_result($result,$i,"time");	
		$down_increase   		= mysql_result($result,$i,"down_increase");	
		$up_increase	= mysql_result($result,$i,"up_increase");
		$upstream_down_increase   		= mysql_result($result,$i,"upstream_down_increase");	
		$upstream_up_increase	= mysql_result($result,$i,"upstream_up_increase");						
		$down_increase	   	= mysql_result($result,$i,"down_increase");		
		$up_increase	   	= mysql_result($result,$i,"up_increase");	
		$upstream_down_increase	   	= mysql_result($result,$i,"upstream_down_increase");		
		$upstream_up_increase	   	= mysql_result($result,$i,"upstream_up_increase");								
		$CurrentUserConnections	   	= mysql_result($result,$i,"CurrentUserConnections");		
		$CurrentUpstreamConnections	   	= mysql_result($result,$i,"CurrentUpstreamConnections");		
		$sql="SELECT ip FROM `fikcdn_node` WHERE id='$node_id'";
		$result1 = mysql_query($sql,$db_link);
		$ip  		= mysql_result($result1,0,"ip");
		echo '<tr bgcolor="#FFFFFF" align="center"   >';
		echo '<td>'.date("Y-m-d H:i:s",$this_time).'</td>';
		echo '<td align="right">'.$ip.'</td>';
		echo '<td align="right">'.$CurrentUserConnections.'  个</td>';
		echo '<td align="right">'.$CurrentUpstreamConnections.' 个</td>';		
		echo '<td align="right">'.PubFunc_KBToString($down_increase).'</td>';
		echo '<td align="right">'.PubFunc_KBToString($up_increase).'</td>';
		echo '<td align="right">'.$down_increase.' Mbps</td>';		
		echo '<td align="right">'.$up_increase.' Mbps</td>';							
		
		echo '<td align="right">'.PubFunc_KBToString($upstream_down_increase).'</td>';
		echo '<td align="right">'.PubFunc_KBToString($upstream_up_increase).'</td>';
		echo '<td align="right">'.$upstream_down_increase.' Mbps</td>';		
		echo '<td align="right">'.$upstream_up_increase.' Mbps</td>';												
	}		
 
	 	
?>								
		 	</table>
	 </div>
		 <table width="800" border="0" class="disc">
			<tr>
			<td bgcolor="#FFFFE6"><div class="div_page_bar"> 记录总数：<?php echo $total_host;?>条&nbsp;&nbsp;&nbsp;当前第<?php echo $nPage; ?>页|共<?php echo $total_pages; ?>页&nbsp;&nbsp;&nbsp;跳转
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
				页&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="group_stat_node_hostorder.php?page=1&action=first&id=<?php echo $group_id.'&order_type='.$order_type.'&order_field='.$order_field; ?>">首页</a>&nbsp;&nbsp;
				<a href="group_stat_node_hostorder.php?page=<?php echo $pageup; ?>&action=pageup&id=<?php echo $group_id.'&order_type='.$order_type.'&order_field='.$order_field; ?>">上一页</a>&nbsp;&nbsp;				
				<a href="group_stat_node_hostorder.php?page=<?php echo $pagedown; ?>&action=pagedown&id=<?php echo $group_id.'&order_type='.$order_type.'&order_field='.$order_field; ?>">下一页</a>&nbsp;&nbsp;
				<a href="group_stat_node_hostorder.php?page=<?php echo $total_pages; ?>&action=tail&id=<?php echo $group_id.'&order_type='.$order_type.'&order_field='.$order_field; ?>">尾页 </a></div></td>
			</tr>
		</table>	
	  </td> 
	  <td background="../images/mail_rightbg.gif">&nbsp;</td>
  </tr>
  
   <tr>
    <td valign="bottom" background="../images/mail_leftbg.gif"><img src="../images/buttom_left2.gif" width="17" height="17" /></td>
    <td background="../images/buttom_bgs.gif"><img src="../images/buttom_bgs.gif" width="17" height="17"></td>
    <td valign="bottom" background="../images/mail_rightbg.gif"><img src="../images/buttom_right2.gif" width="16" height="17" /></td>
  </tr> 
</table>
</div>
<?php

include_once("./tail.php");
?>

