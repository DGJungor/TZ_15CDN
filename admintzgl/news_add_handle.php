<?php
require_once('../db/db.php');
 
 if(is_uploaded_file($_FILES['company_logo']['tmp_name']))
        {
           
          //把整个信息取出
          $fileInfo=$_FILES["company_logo"];
           
          //看看上传文件名
          $true_name=$fileInfo["name"];
          //文件大小,按照字节
          $file_size=$fileInfo["size"];
          
          //取出tmp_name
          $tem_name=$fileInfo["tmp_name"];
          
          $file_full_path=$_SERVER["DOCUMENT_ROOT"]."/fikcdn/images/".$true_name;
          move_uploaded_file($tem_name,$file_full_path);
       }
	$db_link = FikCDNDB_Connect();
	 
	$img_url=$_POST['img_url'];
	$titles=$_POST['titles'];
	$content=$_POST['content'];
	$sql = "insert into fikcdn_news(img_url, titles, content,createdate) values('$img_url', '$titles', '$content',now())";
	/*var_dump($sql);
	exit();*/
	if(mysql_query($sql,$db_link)){
		echo "<script>alert('添加新闻成功');window.location.href='news_list.php';</script>";
	}else{
		echo "<script>alert('添加新闻失败');window.location.href='news_list.php';</script>";
	}
?>