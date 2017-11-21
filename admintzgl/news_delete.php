<?php
	require_once('../db/db.php');
	$db_link = FikCDNDB_Connect();
	$newsid = $_GET['newsid'];
	$sql = "delete from fikcdn_news where newsid=$newsid";
	if(mysql_query($sql)){
		echo "<script>alert('删除新闻成功');window.location.href='news_list.php';</script>";
	}else{
		echo "<script>alert('删除新闻失败');window.location.href='news_list.php';</script>";
	}
?>