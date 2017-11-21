 <?php
include_once("./head.php");
error_reporting ( E_ERROR  |  E_WARNING  |  E_PARSE );
 
$product_id=isset($_GET['product_id'])?$_GET['product_id']:'';
 $product_name=isset($_GET['product_name'])?$_GET['product_name']:'';

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
				 
				<td height="31" width="85"><a href="white_list.php?buy_id=<?php echo $buy_id.'&page='.$nPage.'&action='.$action.'&type='.$sType.'&keyword='.$sKeyword.'&selectOrder='.$selectoder; ?>"><span class="title_bt">套餐节点IP</span></a></td>
		
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
				 
				<th align="left" width="220">所属套餐</th>				
				<th align="left" width="160">节点IP</th>						
				<th align="center" width="160">节点端口</th>
				 
				<th align="right" width="160">机房</th>
				<th align="right" width="160">售后QQ</th>											
				<th align="center">操作</th>
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
			 
				$result3 = mysql_query($sql,$db_link);
				 
				while($rs=mysql_fetch_assoc($result3)){
			  	$arr[]=$rs;
			  	}
			   
				echo '<tr>';
				 
				//echo '<td>'.$username.'</td>';
				echo '<td align="left">'.$product_name.'</td>';
				echo '<td align="left" id="hostname0">'.$arr[0]['node_ip'].'</td>';
				echo '<td align="center" id="port0">'.$arr[0]['node_port'].'</td>';
				 
				echo '<td align="right">'.$arr[0]['machine_room'].'</td>';
				echo '<td align="right">'.$arr[0]['sale_qq'].'</td>';
			 echo '<td><a href="product_node_ip_modify.php?id='.$arr[0]['id'].'&product_name='.$product_name.'"   title="修改套餐节点信息">修改</a>&nbsp;';
				echo '<a href="product_node_ip_delete.php?id='.$arr[0]['id'].'&product_id='.$arr[0]['product_id'].'&product_name='.$product_name.'"   title="删除套餐节点信息">删除</a></td>';
				 
				echo '</tr>';
	 		for($i=1;$i<count($arr);$i++)
			{
				echo '<tr>';
				 
			 
				echo '<td align="left"></td>';
				echo '<td align="left" id="hostname'.$i.'">'.$arr[$i]['node_ip'].'</td>';
				echo '<td align="center" id="port'.$i.'">'.$arr[$i]['node_port'].'</td>';
				 
				echo '<td align="right">'.$arr[$i]['machine_room'].'</td>';
				echo '<td align="right">'.$arr[$i]['sale_qq'].'</td>';
			echo '<td><a href="product_node_ip_modify.php?id='.$arr[$i]['id'].'&product_name='.$product_name.'"   title="修改套餐节点信息">修改</a>&nbsp;';
				echo '<a href="product_node_ip_delete.php?id='.$arr[$i]['id'].'&product_id='.$arr[$i]['product_id'].'&product_name='.$product_name.'"   title="删除套餐节点信息">删除</a></td>';
				 
				echo '</tr>';
			}
		 
		
		mysql_close($db_link);
	}
?>
		 </table></div>
		 
	<table width="800" border="0" class="bottom_btn">
			<tr>
			<td height="28">
				<input    type="submit" style="width:120px;height:28px"   value="增加套餐节点" style="cursor:pointer;"  onclick="javascript:location.href='product_node_ip_add.php?product_id=<?php echo $product_id; ?>&product_name=<?php echo $product_name; ?>'" /> 
			</td>
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
 
<?php

include_once("./tail.php");
?>
