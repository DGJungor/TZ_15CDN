<?php
include_once("./head.php");
  
 
if(!FuncAdmin_IsLogin())
{
	FuncAdmin_LocationLogin();
}
	
$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
?>
<script type="text/javascript">	
var __nProductId;
function FikCdn_ModifyProductBox(product_id)
{
	__nProductId = product_id;
	var boxURL="product_modify.php?id="+product_id;
	showMSGBOX('',500,320,BT,BL,120,boxURL,'修改产品套餐:');	
}

function FikCdn_DelProductBox(product_id)
{
	__nProductId = product_id;
	var boxURL="msg.php?4.7";
	showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');		
}

function FikCdn_DelProduct()
{
	var postURL="./ajax_product.php?mod=product&action=del";
	var postStr="id="+__nProductId;
	AjaxBasePost("product","del","POST",postURL,postStr);	
}

function FikCdn_DelProductResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
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

/*function FikCdn_AddProductBox()
{
	var boxURL="product_add.php";
	showMSGBOX('',520,330,BT,BL,120,boxURL,'创建套餐:');	
}*/

function selectPage(obj){
	var timeval	 =document.getElementById("timeSelect").value;
	var pagesSelect  =document.getElementById("pagesSelect").value;
	window.location.href="product_list3.php?page="+pagesSelect+"&action=jump"+"&timeval="+timeval;
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
	window.location.href="product_list3.php?page=1"+"&action=jump"+"&timeval="+txtTimeval;
}

</script>

<div style="min-width:1080px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2" >
			<tr height="31" class="TabToolTitle">
				<td height="31" width="85"><span class="title_bt">套餐列表</span></td>
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
		  <table width="800" border="0" class="dataintable">
			<tr>
				 
				<th align="center" width="150">产品名称</th>
				<th align="center" width="130">服务器组</th> 
				<th align="right" width="180">CNAME</th> 
				<th align="right" width="75">月度总流量</th>
				<th align="right" width="65">域名个数</th>
				<th align="right" width="75">价格</th>
				<th align="center" width="50">状态</th> 
				<th align="center">产品介绍</th>
				 
			</tr>			
<?php
	/*无限分类函数
	*@para1:需要修改的数组
	*@para2：开始的父亲id
	*/
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
		
	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		do
		{		
			$total_host 	= 0;
			
			$sql = "SELECT count(*) FROM fikcdn_product;"; 
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
			

			$sql = "SELECT * FROM `fikcdn_product` ORDER BY `fikcdn_product`.`price` Limit $offset,$PubDefine_PageShowNum;";			
			
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
			  $arr=tree($arr,$p_id = 0,$level = 0);
			for($i=0;$i<count($arr);$i++)
			{
				/*$id  			= mysql_result($result,$i,"id");
				$name  			= mysql_result($result,$i,"name");
				$price   		= mysql_result($result,$i,"price");	
				$data_flow   	= mysql_result($result,$i,"data_flow");
				$domain_num		= mysql_result($result,$i,"domain_num");
				$is_online  	= mysql_result($result,$i,"is_online");
				$buy_time   	= mysql_result($result,$i,"begin_time");
				$buy_ip 		= mysql_result($result,$i,"is_checks");
				$group_id		= mysql_result($result,$i,"group_id");
				$note   		= mysql_result($result,$i,"note");
				$dns_cname 		= mysql_result($result,$i,"dns_cname");*/
				$is_online=$arr[$i]['is_online'];
				$group_id=$arr[$i]['group_id'];
				$sql = "SELECT * FROM fikcdn_group WHERE id='$group_id'";
				$result2 = mysql_query($sql,$db_link);
				if($result2 && mysql_num_rows($result2)>0)
				{
					$grp_name  = mysql_result($result2,0,"name");
				}
								
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
				echo '<td>'.$grp_name.'</td>';
				echo '<td align="right">'.$arr[$i]['dns_cname'].'</td>';				
				echo '<td align="right">'.PubFunc_MBToString($arr[$i]['data_flow']).'</td>';
				echo '<td align="right">'.$arr[$i]['domain_num'].' 个</td>';
				echo '<td align="right">'.$arr[$i]['price'].' 元/月</td>';
				if($is_online)
				{
					echo '<td>上架</td>';
				}
				else
				{
					echo '<td>已下架</td>';
				}
	
				echo '<td>'.$arr[$i]['note'].'</td>';
			 
				echo '</tr>';
			}
		}while(0);
		
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
				页&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="product_list3.php?page=1&action=first&timeval=<?php echo $timeval; ?>">首页</a>&nbsp;&nbsp;
				<a href="product_list3.php?page=<?php echo $pageup; ?>&action=pageup&timeval=<?php echo $timeval; ?>">上一页</a>&nbsp;&nbsp;				
				<a href="product_list3.php?page=<?php echo $pagedown; ?>&action=pagedown&timeval=<?php echo $timeval; ?> ">下一页</a>&nbsp;&nbsp;
				<a href="product_list3.php?page=<?php echo $total_pages; ?>&action=tail&timeval=<?php echo $timeval; ?>">尾页 </a></div></td>
			</tr>
		</table>	
 		<!-- <table width="800" border="0" class="bottom_btn">
			<tr>
			<td height="28">
				<input name="btnAddProductBox"  type="submit" style="width:80px;height:28px" id="btnAddProductBox" value="创建套餐" style="cursor:pointer;" onClick="FikCdn_AddProductBox();" /> 
			</td>
			</tr>
		</table>	 -->
				
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
