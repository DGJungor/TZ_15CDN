<?php
set_time_limit(0);

include_once('../db/db.php');

include_once("function_admin.php");

//是否登录
	
$sMod  		= isset($_GET['mod'])?$_GET['mod']:'';
$sAction  	= isset($_GET['action'])?$_GET['action']:'';
if($sMod=="realtime")
{
	if($sAction=="bandwidth")
	{
		$node_id 	= isset($_GET['node_id'])?$_GET['node_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		if(!is_numeric($node_id) || !is_numeric($timeval))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
				
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$aryAllData = array();
			
			
			
			$timenow=time();
			$nDay1 = date("d")-$timeval;
			
			$timeval1 = mktime(0,0,0,date("m"),$nDay1,date("Y"));
			$timeval2 = $timeval1+24*60*60;
			
			$sql = "SELECT * FROM fyip WHERE node_id='$node_id' AND time>=$timeval1 AND time<$timeval2 ORDER BY time ASC";
			
			//echo $sql."</br>";
	
			$result2 = mysql_query($sql,$db_link);
			if(!$result2)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'服务器不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}			
			
			$aryDataDown=array();
			$aryDataUp=array();
			$aryUpstreamDataDown=array();
			$aryUpstreamDataUp=array();			
			
			$row_count2 = mysql_num_rows($result2);	
			for($k=0;$k<$row_count2;$k++)
			{
				$stat_time = mysql_result($result2,$k,"time");
				$bandwidth_down = mysql_result($result2,$k,"bandwidth_down");
				$bandwidth_up = mysql_result($result2,$k,"bandwidth_up");
				$upstream_bandwidth_down = mysql_result($result2,$k,"upstream_bandwidth_down");				
				$upstream_bandwidth_up = mysql_result($result2,$k,"upstream_bandwidth_up");										
				
				$aryDataDown[$k][0] = $stat_time;  //date('Y/m/d H:i:s',$time);
				$aryDataDown[$k][1] = $bandwidth_down;	
				
				$aryDataUp[$k][0] = $stat_time;  //date('Y/m/d H:i:s',$time);
				$aryDataUp[$k][1] = $bandwidth_up;		
				
				$aryUpstreamDataDown[$k][0] = 	$stat_time;	
				$aryUpstreamDataDown[$k][1] = 	$upstream_bandwidth_down;	
				
				$aryUpstreamDataUp[$k][0] = 	$stat_time;	
				$aryUpstreamDataUp[$k][1] = 	$upstream_bandwidth_up;					
			}
			
			$aryAllData[0]["name"]="被攻击流量(IN)";
			$aryAllData[0]["data"]=$aryDataDown;	
			
			$aryAllData[1]["name"]="TCP(PPS)";
			$aryAllData[1]["data"]=$aryDataUp;	
			
			$aryAllData[2]["name"]="UDP(PPS)";
			$aryAllData[2]["data"]=$aryUpstreamDataDown;	
			
			$aryAllData[3]["name"]="正常带宽(OUT)";
			$aryAllData[3]["data"]=$aryUpstreamDataUp;							
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);	
	}	
}
?>
