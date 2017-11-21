 <?php
include_once("./head.php");
error_reporting ( E_ERROR  |  E_WARNING  |  E_PARSE );
 
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
				 
				<td height="31" width="85"><span class="title_bt">添加套餐节点</span></a></td>
				<td width="95%"></td>
			</tr>
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
</table>	
 
<form id="form1" enctype="multipart/form-data" name="form1" method="post" action="product_node_add_handle.php">
    	 
      <table width="590" border="0" cellpadding="8" cellspacing="1">
       <tr>
         <td width="100"  >套餐分类：</td>
         <td border="none"> 
          <select id="product_id" name="product_id" >
             <?php
             require_once('../db/db.php');
             $db_link = FikCDNDB_Connect();
                if($db_link)
                {
                  $sql = "SELECT id,name FROM fikcdn_product;";
                  $result = mysql_query($sql,$db_link); 
                  if($result)
                  {     
                    $row_count = mysql_num_rows($result);
                    for($i=0;$i<$row_count;$i++)
                    {
                      $product_id = mysql_result($result,$i,"id");  
                      $product_name    = mysql_result($result,$i,"name");  
                         
                      
                      echo '<option value="'.$product_id.'" >'.$product_name.'</option>';        
                    }
                  }
                  
                  mysql_close($db_link);
                }     
            ?>
          
          </select> 
        </td>
       </tr>
       <tr>
          <td width="119">节点IP：</td>
          <td width="437"><label for="node_ip"></label>
            <input type="text" name="node_ip" id="node_ip"  /></td>
        </tr>
        <tr>
          <td width="119">服务器名称：</td>
          <td width="437"><label for="machine_room"></label>
            <input type="text" name="machine_room" id="machine_room"  /></td>
        </tr>
        <tr>
          <td width="119">售后QQ:</td>
          <td width="437"><label for="sale_qq"></label>
            <input type="text" name="sale_qq" id="sale_qq"  /></td>
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
