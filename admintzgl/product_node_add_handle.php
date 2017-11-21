<?php
require_once('../db/db.php');
 	$db_link = FikCDNDB_Connect();
	 
	 $product_id=$_POST['product_id'];
	$node_ip=$_POST['node_ip'];
	$machine_room=$_POST['machine_room'];
	$sale_qq=$_POST['sale_qq'];
	$sql = "INSERT INTO `fikcdn_product_node_ip`(`product_id`, `node_ip`,`machine_room`, `sale_qq`) VALUES ('$product_id','$node_ip','$machine_room','$sale_qq')";
	/*var_dump($sql);
	exit();*/
	if(mysql_query($sql,$db_link)){
		echo "<script>alert('添加套餐节点成功');window.location.href='white_list.php';</script>";
	}else{
		echo "<script>alert('添加套餐节点失败');window.location.href='white_list.php';</script>";
	}
?>