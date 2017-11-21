<?php
	require_once('../db/db.php');
	$db_link = FikCDNDB_Connect();
	$id = $_GET['id'];
	$product_name = $_GET['product_name'];
	$product_id = $_GET['product_id'];
	$sql = "delete from fikcdn_product_node_ip where id=$id";
	if(mysql_query($sql)){
		echo "<script>alert('删除套餐节点成功');window.location.href='product_node_ip.php?product_id=".$product_id."&product_name=".$product_name."';</script>";
	}else{
		echo "<script>alert('删除套餐节点失败');window.location.href='product_node_ip.phpproduct_id=".$product_id."&product_name=".$product_name."';</script>";
	}
?>