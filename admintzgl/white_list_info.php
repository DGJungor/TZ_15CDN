 <?php
include_once("./head.php");
error_reporting ( E_ERROR  |  E_WARNING  |  E_PARSE );
$hostname=isset($_GET['hostname'])?$_GET['hostname']:'';
$product_name=isset($_GET['product_name'])?$_GET['product_name']:'';
$product_id=isset($_GET['product_id'])?$_GET['product_id']:'';
 $action 	= isset($_GET['action'])?$_GET['action']:'';
	$nPage 		= isset($_GET['page'])?$_GET['page']:'';
	 
	$product_id 	= isset($_GET['product_id'])?$_GET['product_id']:'';
	$sType 		= isset($_GET['type'])?$_GET['type']:'';
	 	
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
				 
				<td height="31" width="85"><a href="white_list.php"><span class="title_bt">白名单查询</span></a></td>
		
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
				<th align="right" width="160">服务器名称</th>
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
		 
				$sql = "SELECT count(*) FROM fikcdn_product_node_ip WHERE product_id='$product_id'";
				 $result = mysql_query($sql,$db_link);
			if($result&&mysql_num_rows($result)>0)
			{
				$total_host  = mysql_result($result,0,"count(*)");	
			}
			 //$PubDefine_PageShowNum=1;
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
			$sql = "SELECT * FROM fikcdn_product_node_ip WHERE product_id='$product_id' Limit $offset,$PubDefine_PageShowNum;";
			/*var_dump($sql);
			exit();*/
				$result3 = mysql_query($sql,$db_link);
				 
				while($rs=mysql_fetch_assoc($result3)){
			  	$arr[]=$rs;
			  	}
			  	 
				echo '<tr>';
				echo '<td  align="left" id="hostname">'.$hostname.'</td>';
				 
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
				页&nbsp;&nbsp;&nbsp;&nbsp;<a href="white_list_info.php?hostname=<?php echo $hostname;?>&product_name=<?php echo $product_name;?>&page=1&action=frist&product_id=<?php echo $product_id; ?>">首页</a>&nbsp;&nbsp;
				<a href="white_list_info.php?hostname=<?php echo $hostname;?>&product_name=<?php echo $product_name;?>&page=<?php echo $pageup; ?>&action=pageup&product_id=<?php echo $product_id; ?>">上一页</a>&nbsp;&nbsp;				
				<a href="white_list_info.php?hostname=<?php echo $hostname;?>&product_name=<?php echo $product_name;?>&page=<?php echo $pagedown; ?>&action=pagedown&product_id=<?php echo $product_id; ?>">下一页</a>&nbsp;&nbsp;
				<a href="white_list_info.php?hostname=<?php echo $hostname;?>&product_name=<?php echo $product_name;?>&page=<?php echo $total_pages; ?>&action=tail&product_id=<?php echo $product_id; ?>">尾页 </a></div></td>
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
  function selectPage(obj){
	var pagesSelect    =document.getElementById("pagesSelect").value;
	 
	 
	window.location.href="white_list_info.php?page="+pagesSelect;
}
    $(function(){
	for(var i=0;i<<?php echo count($arr)?>;i++){
	         setTimeout("Request("+i+")", 1000);
    	  }
 });
  function Request(i){
       		var domain= $("#hostname").text(); 
	       var hostname=$("#hostname"+i).text();
	        var port=$("#port"+i).text();
	        
	        $.ajax({
	            url:'ping.php?&hostname='+hostname+'&domain='+domain+'&port='+port,
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
