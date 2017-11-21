<?php
include_once("./head.php");
?>
<script type="text/javascript">
function FikCdn_BuyProductBox(product_id)
{
	var boxURL="product_buy.php?id="+product_id;
	showMSGBOX('',500,310,BT,BL,120,boxURL,'购买套餐:');
}
</script>
 
<div style="min-width:1080px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
			<tr>
				<td height="31"><div class="title_bt">产品套餐</div></td>
			</tr>
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
  <tr height="500">
	  <td valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td> 
	  <td valign="top">
		  <table width="800" border="0" class="dataintable">
			<tr>
				 
				<th align="center" width="240">套餐名称</th>
				<th align="right" width="80">加速域名个数</th>
				<th align="right" width="90">月度总流量</th>
				<th align="right" width="75">套餐价格</th>
				<th align="right" width="210">CNAME</th>
				<th align="center" width="200">产品说明</th>    
				<th align="center">操作</th>
			</tr>			
<?php	

	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		do
		{
						 
			$sql = "SELECT * FROM fikcdn_product  WHERE is_online=1 ORDER BY `fikcdn_product`.`price`;"; 

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
			  while($rs=mysql_fetch_assoc($result)){
			  	$arr[]=$rs;
			  }
			  /*var_dump($arr);
			  exit();*/
			/*无限分类*/
			function tree($arr,$p_id = 0,$level = 0) {
				static $tree = array();
				foreach ($arr as $v) {
					if ($v['p_id'] == $p_id) {
						//说明找到，保存
						$v['level'] = $level; //保存当前分类的所在层级
						$tree[] = $v;
						//继续找
						tree($arr,$v['id'],$level + 1);
					}
				}
				return $tree;
			}
			/*给指定的字符串加前缀*/
			function str_prefix($str, $n=1, $char=" "){
				     for ($x=0;$x<$n;$x++){$str = $char.$str;}
					 return $str;
					}
					$arr=tree($arr,$p_id = 0,$level = 0);
					 
			for($i=0;$i<count($arr);$i++)
			{
				/*$id  			= mysql_result($result,$i,"id");
				$p_id  			= mysql_result($result,$i,"p_id");

				$name   		= mysql_result($result,$i,"name");
				$price   		= mysql_result($result,$i,"price");		
				$data_flow   	= mysql_result($result,$i,"data_flow");	
				$domain_num		= mysql_result($result,$i,"domain_num");
				$begin_time		= mysql_result($result,$i,"begin_time");
				$is_checks		= mysql_result($result,$i,"is_checks");
				$note			= mysql_result($result,$i,"note");
				$group_id		= mysql_result($result,$i,"group_id");
				$dns_cname		= mysql_result($result,$i,"dns_cname");
				
				$sql = "SELECT count(*) FROM fikcdn_node WHERE groupid=$id;"; 
				$result2 = mysql_query($sql,$db_link);
				if($result2 && mysql_num_rows($result2)>0)
				{
					$node_count = mysql_result($result2,0,"count(*)");	
				}*/
				  if($arr[$i]['p_id']){
				echo "<tr name='".$arr[$i]['p_id']."' style='display:none;' bgcolor='#FFFFFF' align='center' >";
				 }else{
				 	/*echo "<tr  bgcolor='#FFFFFF' align='center'  onclick='add()'>";*/
				 echo "<tr  bgcolor='#FFFFFF' align='center'  >"; 
				
				 }
				 if($arr[$i]['p_id']){
				 echo "<td align='left' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<img src='../images/menu_minus.gif' width='9' height='9' border='0' style='margin-left:0em' onclick='decrease(".$arr[$i]['p_id'].")'>
						<span>".$arr[$i]['name']."</span></td>";}
				  else{
					 	echo "<td align='left'><img src='../images/menu_plus.gif' width='9' height='9' border='0' style='margin-left:0em' onclick='add(".$arr[$i]['id'].")'>
						<span>".$arr[$i]['name']."</span></td>";
					 }
				 				
				echo '<td align="right">'.$arr[$i]['domain_num'].' 个</td>'; 
				echo '<td align="right">'.PubFunc_MBToString($arr[$i]['data_flow']).'</td>';
				echo '<td align="right">'.$arr[$i]['price'].' 元/月</td>';
				echo '<td align="right">购买并添加域名后查看CNAME</td>';
				echo '<td>'.$arr[$i]['note'].'</td>'; 
				if($arr[$i]['id']==1){
					$client_username  =$_SESSION['fikcdn_client_username'];
					$sql="SELECT * FROM `fikcdn_buy` WHERE product_id=1 and username='$client_username'";
					$result = mysql_query($sql,$db_link);
					if(!$result)
					{
						break;
					}
					$row_count=mysql_num_rows($result);
					if($row_count)
					{
						echo '<td>每位客户仅能购买一次</td></tr>';
					}else{
						echo '<td><a href="javascript:void(0);" onclick="javescript:FikCdn_BuyProductBox('.$arr[$i]['id'].');" title="购买产品套餐">购买产品</a>&nbsp;&nbsp</td></tr>';
					}
				}else{
					echo '<td><a href="javascript:void(0);" onclick="javescript:FikCdn_BuyProductBox('.$arr[$i]['id'].');" title="购买产品套餐">购买产品</a>&nbsp;&nbsp</td></tr>';
				}
				
				 				
				
			
			}
		}while(0);
		
		mysql_close($db_link);
	}
?>


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
<script>
function add(name){
 
var names = document.getElementsByName(name);
for(var i=0; i< names.length; i++){
names[i].style.display =""; 
}
}
function decrease(name){
var names = document.getElementsByName(name);
for(var i=0; i< names.length; i++){
names[i].style.display = "none";
}
}
</script>

<?php

include_once("./tail.php");
?>
 