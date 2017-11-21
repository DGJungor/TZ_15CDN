<?php
set_time_limit(0);

include_once('../db/db.php');
include_once('../function/fik_api.php');
include_once("function.php");

//是否登录
if(!FuncClient_IsLogin())
{
	$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoLogin);
	PubFunc_EchoJsonAndExit($aryResult,NULL);
}
$client_username 	=$_SESSION['fikcdn_client_username'];
	
$sMod  		= isset($_GET['mod'])?$_GET['mod']:'';
$sAction  	= isset($_GET['action'])?$_GET['action']:'';
if($sMod=="proxy")
{
	 if($sAction=="bandwidth")
	{
		$domain_id 	= isset($_GET['domain_id'])?$_GET['domain_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		if(!is_numeric($domain_id) || !is_numeric($timeval))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
				
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$aryAllData = array();
			
			$sql = "SELECT * FROM fikcdn_domain WHERE id=$domain_id AND username='$client_username'";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2 || mysql_num_rows($result2)<=0)
			{
				$aryResult = array('Return'=>'False','2.ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}	
			
			$hostname  	 = mysql_result($result2,0,"hostname");	
			$username = mysql_result($result2,0,"username");
			$buy_id = mysql_result($result2,0,"buy_id");
			$group_id = mysql_result($result2,0,"group_id");
			
			$timenow=time();
			$nDay1 = date("d")-$timeval;
			
			$timeval1 = mktime(0,0,0,date("m"),$nDay1,date("Y"));
			$timeval2 = $timeval1+24*60*60;
			$sql = "SELECT * FROM domain_stat_host_bandwidth WHERE domain_id='$domain_id' AND time>=$timeval1 AND time<$timeval2 ORDER BY time ASC";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2)
			{
				echo $sql;
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}			
			
			$aryDataDown=array();
			$aryDataUp=array();
			
			$row_count2 = mysql_num_rows($result2);	
			for($k=0;$k<$row_count2;$k++)
			{
				$stat_time = mysql_result($result2,$k,"time");
				$RequestCount_increase = mysql_result($result2,$k,"RequestCount_increase");						
				
				$aryDataUp[$k][0] = $stat_time;
				$aryDataUp[$k][1] = $RequestCount_increase;				
			}
			
			$aryAllData[0]["name"]="用户请求量";
			$aryAllData[0]["data"]=$aryDataDown;	
			
			$aryAllData[1]["name"]="用户请求量";
			$aryAllData[1]["data"]=$aryDataUp;	
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);
	}
	
	
				
}
?>
