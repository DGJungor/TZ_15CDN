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
				 
				<td height="31" width="85"><span class="title_bt">添加新闻</span></a></td>
				<td width="95%"></td>
			</tr>
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
</table>	
 
<form id="form1" enctype="multipart/form-data" name="form1" method="post" action="news_add_handle.php">
    	<input type="hidden" name="newsid" value="<?php echo $rs['newsid']?>" />
      <table width="590" border="0" cellpadding="8" cellspacing="1">
         <tr>
          <td width="119">图片上传：</td>
          <td width="437"><label for="titles"></label>
            <input type="file" name="company_logo" /></td>
        </tr>
           <tr>
          <td width="119">图片路径：</td>
          <td width="437"><label for="img_url"></label>
            <input type="text" name="img_url" id="img_url"  /><span>格式为：images/+图片英文名 例如：images/image7.jpg</span></td>
        </tr>
        <tr>
          <td width="119">标题：</td>
          <td width="437"><label for="titles"></label>
            <input type="text" name="titles" id="titles"  /></td>
        </tr>
        
        <tr>
          <td>内容：</td>
          <td><textarea name="content" cols="60" rows="20" id="content"> </textarea></td>
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
