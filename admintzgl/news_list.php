 <?php
include_once("./head.php");
error_reporting ( E_ERROR  |  E_WARNING  |  E_PARSE );
 
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
				 
				<td height="31" width="85"><span class="title_bt">新闻列表</span></a></td>
				<td height="31" width="85"><a href="news_add.php"><span class="title_bt">添加新闻</span></a></td>
		
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
				<th align="left" width="150">图片路径</th> 
				<th align="left" width="220">新闻标题</th>				
				<th align="left" width="400">新闻内容</th>						
				<th align="center" width="160">创建时间</th>
				<th align="center">操作</th>									
				 
			</tr>			
<?php
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
		 
				$sql = "SELECT * FROM `fikcdn_news`";
				 
				$result3 = mysql_query($sql,$db_link);
				 
				while($rs=mysql_fetch_assoc($result3)){
			  	$arr[]=$rs;
			  	}
			  /* var_dump($arr);
			   exit();*/
	 		for($i=0;$i<count($arr);$i++)
			{
				echo '<tr>';
				 
				echo '<td align="left"  >'.$arr[$i]['img_url'].'</td>';
				echo '<td align="center"  >'.$arr[$i]['titles'].'</td>';
				echo '<td align="right" >'.$arr[$i]['content'].'</td>';
				echo '<td align="right">'.$arr[$i]['createdate'].'</td>';
				echo '<td><a href="news_update.php?newsid='.$arr[$i]['newsid'].'" title="修改新闻">修改</a>&nbsp;<a href="news_delete.php?newsid='.$arr[$i]['newsid'].'" title="删除新闻">删除</a></td>';
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
				页&nbsp;&nbsp;&nbsp;&nbsp;<a href="news_list.php?page=1&action=first&buy_id=<?php echo $buy_id.'&keyword='.$sKeyword.'&type='.$sType.'&selectOrder='.$selectoder; ?>">首页</a>&nbsp;&nbsp;
				<a href="news_list.php?page=<?php echo $pageup; ?>&action=pageup&buy_id=<?php echo $buy_id.'&keyword='.$sKeyword.'&type='.$sType.'&selectOrder='.$selectoder; ?>">上一页</a>&nbsp;&nbsp;				
				<a href="news_list.php?page=<?php echo $pagedown; ?>&action=pagedown&buy_id=<?php echo $buy_id.'&keyword='.$sKeyword.'&type='.$sType.'&selectOrder='.$selectoder; ?>">下一页</a>&nbsp;&nbsp;
				<a href="news_list.php?page=<?php echo $total_pages; ?>&action=tail&buy_id=<?php echo $buy_id.'&keyword='.$sKeyword.'&type='.$sType.'&selectOrder='.$selectoder; ?>">尾页 </a></div></td>
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
