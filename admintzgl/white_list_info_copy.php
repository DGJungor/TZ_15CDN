 <?php
include_once("./head.php");
error_reporting ( E_ERROR  |  E_WARNING  |  E_PARSE );
$hostname=isset($_GET['hostname'])?$_GET['hostname']:'';
$product_name=isset($_GET['product_name'])?$_GET['product_name']:'';
$product_id=isset($_GET['product_id'])?$_GET['product_id']:'';
/*echo $hostname."--".$product_name."--".$product_id."--";
exit();*/
	$nPage 		= isset($_GET['page'])?$_GET['page']:'';
	$action 	= isset($_GET['action'])?$_GET['action']:'';

	$buy_id 	= isset($_GET['buy_id'])?$_GET['buy_id']:'all';
	$sType 		= isset($_GET['type'])?$_GET['type']:'';
	$sKeyword 	= isset($_GET['keyword'])?$_GET['keyword']:'';	
	$selectoder	= isset($_GET['selectOrder'])?$_GET['selectOrder']:'down_dataflow_total';
	if($_SESSION['admin_grade']==3){
    FuncAdmin_LocationLogin();
}
?>
 
<div style="min-width:1160px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2" >
			<tr height="31" class="TabToolTitle">
				 
				<td height="31" width="85"><a href="white_list.php?buy_id=<?php echo $buy_id.'&page='.$nPage.'&action='.$action.'&type='.$sType.'&keyword='.$sKeyword.'&selectOrder='.$selectoder; ?>"><span class="title_bt">白名单查询</span></a></td>
		
				<td width="95%"></td>
			</tr>
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
  <tr height="500">
	  <td valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td>
	  <td valign="top">
	  	  
		<div id="div_search_result">
		  <table width="800" border="0" class="dataintable" id="domain_table">
			<tr id="tr_domain_title">
				<th align="left" width="150">网站域名</th> 
				<th align="left" width="220">所属套餐</th>				
				<th align="left" width="160">节点IP</th>						
				<th align="center" width="160">节点端口</th>
				<th align="right" width="160">状态</th>
				<th align="right" width="160">机房</th>
				<th align="right" width="160">售后QQ</th>											
				 
			</tr>			
<?php
		//	<th align="center" width="80" align="center">月累计流量</th>		
		//		<th align="center" width="80" align="center">月总请求数</th>

	$db_link = FikCDNDB_Connect();
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

	if($db_link)
	{
		 
				$sql = "SELECT * FROM fikcdn_product_node_ip WHERE product_id='$product_id'";
				/*echo $sql;
				exit();*/
				$result3 = mysql_query($sql,$db_link);
				/*var_dump(mysql_num_rows($result3));
				exit();*/
				while($rs=mysql_fetch_assoc($result3)){
			  	$arr[]=$rs;
			  	}
			  	/*var_dump($arr[3][node_ip]);
			  	exit();*/
				/*for($i=0;$i<mysql_num_rows($result3);$i++)
				{		
					$node_ip[]		 = mysql_result($result3,0,"node_ip");
					$node_port[]		 = mysql_result($result3,0,"node_port");
					$status[]		 = mysql_result($result3,0,"status");
					$machine_room[]		 = mysql_result($result3,0,"machine_room");
					$sale_qq[]		 = mysql_result($result3,0,"sale_qq");
				}
				var_dump($node_ip);
				exit();*/
				echo '<tr>';
				echo '<td  align="left">'.$hostname.'</td>';
				//echo '<td>'.$username.'</td>';
				echo '<td align="left">'.$product_name.'</td>';
				echo '<td align="left" id="hostname0">'.$arr[0]['node_ip'].'</td>';
				echo '<td align="center" id="port0">'.$arr[0]['node_port'].'</td>';
				echo '<td align="right" id="status0">'.$arr[0]['status'].'</td>';
				echo '<td align="right">'.$arr[0]['machine_room'].'</td>';
				echo '<td align="right">'.$arr[0]['sale_qq'].'</td>';
			 
				 
				echo '</tr>';
	 		for($i=1;$i<count($arr);$i++)
			{
				echo '<tr>';
				echo '<td  align="left"></td>';
				//echo '<td>'.$username.'</td>';
				echo '<td align="left"></td>';
				echo '<td align="left" id="hostname'.$i.'">'.$arr[$i]['node_ip'].'</td>';
				echo '<td align="center" id="port'.$i.'">'.$arr[$i]['node_port'].'</td>';
				echo '<td align="right" id="status'.$i.'">'.$arr[$i]['status'].'</td>';
				echo '<td align="right">'.$arr[$i]['machine_room'].'</td>';
				echo '<td align="right">'.$arr[$i]['sale_qq'].'</td>';
			 
				 
				echo '</tr>';
			}
		 
		
		mysql_close($db_link);
	}
?>
		 </table></div>
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
				页&nbsp;&nbsp;&nbsp;&nbsp;<a href="white_list.php?page=1&action=first&buy_id=<?php echo $buy_id.'&keyword='.$sKeyword.'&type='.$sType.'&selectOrder='.$selectoder; ?>">首页</a>&nbsp;&nbsp;
				<a href="white_list.php?page=<?php echo $pageup; ?>&action=pageup&buy_id=<?php echo $buy_id.'&keyword='.$sKeyword.'&type='.$sType.'&selectOrder='.$selectoder; ?>">上一页</a>&nbsp;&nbsp;				
				<a href="white_list.php?page=<?php echo $pagedown; ?>&action=pagedown&buy_id=<?php echo $buy_id.'&keyword='.$sKeyword.'&type='.$sType.'&selectOrder='.$selectoder; ?>">下一页</a>&nbsp;&nbsp;
				<a href="white_list.php?page=<?php echo $total_pages; ?>&action=tail&buy_id=<?php echo $buy_id.'&keyword='.$sKeyword.'&type='.$sType.'&selectOrder='.$selectoder; ?>">尾页 </a></div></td>
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
<script src="../js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
 
    /*$(function(){
        for(var i=0;i<<?php echo count($arr)?>;i++){
	       var hostname=$("#hostname"+i).text();
	        var port=$("#port"+i).text();
	        
	        $.ajax({
	            url:'ping.php?&hostname='+hostname+'&port='+port,
	            type:'get',
	            success:function(data){
	                if(data==1){
	               $("#status"+i).html("成功");
	                }
	               else{
	                $("#status"+i).html("失败");  
	                }
	            }
	           
	           
	        });
	         $.delay(1000);
    	}
         
    });*/

 /*定时发送请求
 setInterval("AllRequest()",1000);
 
 function AllRequest(){
	for(var i=0;i<<?php echo count($arr)?>;i++){
	         setTimeout("Request("+i+")", 1000);
    	  }
 }
  function Request(i){
       		 
	       var hostname=$("#hostname"+i).text();
	        var port=$("#port"+i).text();
	        
	        $.ajax({
	            url:'ping.php?&hostname='+hostname+'&port='+port,
	            type:'get',
	            success:function(data){
	                if(data==1){
	               $("#status"+i).html("成功");
	                }
	               else{
	                $("#status"+i).html("失败");  
	                }
	            }
	           
	           
	        });
	      
         
    }*/
    $(function(){
	for(var i=0;i<<?php echo count($arr)?>;i++){
	         setTimeout("Request("+i+")", 1000);
    	  }
 });
  function Request(i){
       		 
	       var hostname=$("#hostname"+i).text();
	        var port=$("#port"+i).text();
	        
	        $.ajax({
	            url:'ping.php?&hostname='+hostname+'&port='+port,
	            type:'get',
	            success:function(data){
	                if(data==1){
	               $("#status"+i).html("成功");
	                }
	               else{
	                $("#status"+i).html("失败");  
	                }
	            }
	           
	           
	        });
	      
         
    }
</script>
<?php

include_once("./tail.php");
?>
