 <?php
include_once("./head.php");
error_reporting ( E_ERROR  |  E_WARNING  |  E_PARSE );
 	$id=isset($_GET['id'])?$_GET['id']:'';
 	$product_name=isset($_GET['product_name'])?$_GET['product_name']:''; 
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
				 
				<td height="31" width="85"><span class="title_bt">修改套餐节点</span></a></td>
				<td width="95%"></td>
			</tr>
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
</table>	
<?php
	$db_link = FikCDNDB_Connect();
	 

	if($db_link)
	{
		 
				$sql = "SELECT * FROM `fikcdn_product_node_ip` where id=$id";
				 
				$result3 = mysql_query($sql,$db_link);
				 
			   $rs=mysql_fetch_assoc($result3);
			  	/* var_dump($rs['titles']);
			  	 exit();*/
	 		 
				 
			 
		 
		
		mysql_close($db_link);
	}
?>
		  
  
<form id="form1" name="form1" method="post" action="product_node_ip_modify_handle.php">
    	<input type="hidden" name="id" value="<?php echo $rs['id']?>" />
    	<input type="hidden" name="product_id" value="<?php echo $rs['product_id']?>" />
      <input type="hidden" name="product_name" value="<?php echo $product_name?>" />
      
      <table width="590" border="0" cellpadding="8" cellspacing="1">
         
           
        <tr>
          <td width="119">节点IP：</td>
          <td width="437"> 
            <input type="text" name="node_ip" id="node_ip" value="<?php echo $rs['node_ip']?>"/></td>
        </tr>
         <tr>
          <td width="119">端口：</td>
          <td width="437"> 
            <input type="text" name="node_port" id="node_port" value="<?php echo $rs['node_port']?>"/></td>
        </tr>
        <tr>
          <td width="119">机房：</td>
          <td width="437"> 
            <input type="text" name="machine_room" id="machine_room" value="<?php echo $rs['machine_room']?>"/></td>
        </tr><tr>
          <td width="119">售后QQ：</td>
          <td width="437"> 
            <input type="text" name="sale_qq" id="sale_qq" value="<?php echo $rs['sale_qq']?>"/></td>
        </tr>
        <tr>
          <td colspan="2" align="right"><input type="submit" name="button" id="button" value="提交" />&nbsp;<input type="reset"value="重置" />
 </td>
          </tr>
      </table>
    </form>	 
<?php

include_once("./tail.php");
?>
