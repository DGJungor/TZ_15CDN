<?php
require_once('../db/db.php');
	$db_link = FikCDNDB_Connect();
	$product_name=$_POST['product_name'];
	$product_id=$_POST['product_id'];
	 
	$node_ip=$_POST['node_ip'];
	$node_port=$_POST['node_port'];
	$machine_room=$_POST['machine_room'];
	$sale_qq=$_POST['sale_qq'];
	$sql = "INSERT INTO `fikcdn_product_node_ip`(`product_id`, `node_ip`, `node_port`, `machine_room`, `sale_qq`) VALUES ('$product_id','$node_ip','$node_port','$machine_room','$sale_qq')";
 
	if(mysql_query($sql,$db_link)){
		echo "<script>alert('添加节点成功');window.location.href='product_node_ip.php?product_id=".$product_id."&product_name=".$product_name."';</script>";
	}else{
		echo "<script>alert('添加节点失败');window.location.href='product_node_ip.php?product_id=".$product_id."&product_name=".$product_name."';</script>";
	}
?>