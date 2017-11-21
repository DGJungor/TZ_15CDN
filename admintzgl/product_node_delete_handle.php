<?php
	require_once('../db/db.php');
	$db_link = FikCDNDB_Connect();
	$node_ip = $_POST['node_ip'];
	$sql = "delete from fikcdn_product_node_ip where node_ip='$node_ip'";
	if(mysql_query($sql)){
		echo "<script>alert('删除套餐节点成功');window.location.href='white_list.php';</script>";
	}else{
		echo "<script>alert('删除套餐节点失败');window.location.href='white_list.php';</script>";
	}
?>