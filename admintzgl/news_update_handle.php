<?php
require_once('../db/db.php');
	$db_link = FikCDNDB_Connect();
	$newsid=$_POST['newsid'];
	$img_url=$_POST['img_url'];
	$titles=$_POST['titles'];
	$content=$_POST['content'];
	$sql = "update fikcdn_news set img_url='$img_url',titles='$titles',content='$content' where newsid=$newsid";
	/*var_dump($sql);
	exit();*/
	if(mysql_query($sql,$db_link)){
		echo "<script>alert('修改新闻成功');window.location.href='news_list.php';</script>";
	}else{
		echo "<script>alert('修改新闻失败');window.location.href='news_list.php';</script>";
	}
?>