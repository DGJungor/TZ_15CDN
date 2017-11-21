<?php
set_time_limit(0);

include_once('../db/db.php');
include_once('../function/fik_api.php');
include_once("function_admin.php");

//是否登录
if(!FuncAdmin_IsLogin())
{
	$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoLogin);
	PubFunc_EchoJsonAndExit($aryResult,NULL);
}
	
$sMod  		= isset($_GET['mod'])?$_GET['mod']:'';
$sAction  	= isset($_GET['action'])?$_GET['action']:'';
if($sMod=="realtime")
{
	if($sAction=="bandwidth")
	{
		$group_id 	= isset($_GET['group_id'])?$_GET['group_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		if(!is_numeric($group_id) || !is_numeric($timeval))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
				
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$aryAllData = array();
			
			/*$sql = "SELECT * FROM fikcdn_node WHERE id=$group_id";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2 || mysql_num_rows($result2)<=0)
			{
				$aryResult = array('Return'=>'False','2.ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}*/
			
			$timenow=time();
			$nDay1 = date("d")-$timeval;
			
			$timeval1 = mktime(0,0,0,date("m"),$nDay1,date("Y"));
			$timeval2 = $timeval1+24*60*60;
			
			$sql = "SELECT time,sum(bandwidth_down)  bandwidth_down, sum(bandwidth_up) bandwidth_up, sum(upstream_bandwidth_down) upstream_bandwidth_down, sum(upstream_bandwidth_up) upstream_bandwidth_up FROM realtime_list WHERE group_id=$group_id AND time>=$timeval1 AND time<$timeval2 group BY time order by time asc";

			
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
			
			$aryAllData[0]["name"]="用户下载带宽";
			$aryAllData[0]["data"]=$aryDataDown;	
			
			$aryAllData[1]["name"]="用户上传带宽";
			$aryAllData[1]["data"]=$aryDataUp;	
			
			$aryAllData[2]["name"]="源站上传带宽";
			$aryAllData[2]["data"]=$aryUpstreamDataDown;	
			
			$aryAllData[3]["name"]="源站下载带宽";
			$aryAllData[3]["data"]=$aryUpstreamDataUp;							
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);	
	}	
	else if($sAction=="bandwidth_max")
	{
		$group_id 	= isset($_GET['group_id'])?$_GET['group_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		if(!is_numeric($group_id) || !is_numeric($timeval))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{
			$aryAllData = array();
			
			/*$sql = "SELECT * FROM fikcdn_node WHERE id=$group_id";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2 || mysql_num_rows($result2)<=0)
			{
				$aryResult = array('Return'=>'False','2.ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}*/
			
			$timenow=time();
			
			if($timeval==60)
			{
				$timeval1 = mktime(0,59,59,date("m"),1,date("Y"));
				$timeval2 = mktime(0,0,0,date("m")-1,1,date("Y"));
				$sql = "SELECT time,sum(bandwidth_down) bandwidth_down, sum(bandwidth_up) bandwidth_up, sum(upstream_bandwidth_down) upstream_bandwidth_down, sum(upstream_bandwidth_up) upstream_bandwidth_up FROM realtime_list WHERE group_id=$group_id AND time>=$timeval2 AND time<$timeval1 group BY time order by time asc";
			}			
			else if($timeval==30)
			{
				$timeval1 = mktime(0,0,0,date("m"),1,date("Y"));
				$sql = "SELECT time,sum(bandwidth_down) bandwidth_down, sum(bandwidth_up) bandwidth_up, sum(upstream_bandwidth_down) upstream_bandwidth_down, sum(upstream_bandwidth_up) upstream_bandwidth_up FROM realtime_list_max WHERE group_id=$group_id AND time>=$timeval1 group BY time order by time asc";
			}
			else
			{
				if($timeval==1)
				{
					$timeval = $timenow-24*60*60;
				}
				else if($timeval==7)
				{
					$timeval = $timenow-24*60*60*7;
				}
				else if($timeval==30)
				{
					$timeval = $timenow-24*60*60*30;
				}
				else if($timeval==15)
				{
					$timeval = $timenow-24*60*60*15;
				}
				else
				{
					exit();
				}
							
				//查找此域名的流量统计
				$sql = "SELECT time,sum(bandwidth_down) bandwidth_down, sum(bandwidth_up) bandwidth_up, sum(upstream_bandwidth_down) upstream_bandwidth_down, sum(upstream_bandwidth_up) upstream_bandwidth_up FROM realtime_list_max WHERE group_id=$group_id  AND time>=$timeval group BY time order by time asc";
			}
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
			
			$aryAllData[0]["name"]="用户下载带宽";
			$aryAllData[0]["data"]=$aryDataDown;	
			
			$aryAllData[1]["name"]="用户上传带宽";
			$aryAllData[1]["data"]=$aryDataUp;	
			
			$aryAllData[2]["name"]="源站上传带宽";
			$aryAllData[2]["data"]=$aryUpstreamDataDown;	
			
			$aryAllData[3]["name"]="源站下载带宽";
			$aryAllData[3]["data"]=$aryUpstreamDataUp;							
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);		
	}
	else if($sAction=="DayDownloadCount")
	{
		$group_id 	= isset($_GET['group_id'])?$_GET['group_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		if(!is_numeric($group_id) || !is_numeric($timeval))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
				
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$aryAllData = array();
			
			/*$sql = "SELECT * FROM fikcdn_node WHERE id=$group_id";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2 || mysql_num_rows($result2)<=0)
			{
				$aryResult = array('Return'=>'False','2.ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}*/
			
			$timenow=time();			
			if($timeval==7)
			{
				$timeval = $timenow-24*60*60*15;
			}
			else if($timeval==30)
			{
				$timeval = $timenow-24*60*60*30;
			}
			else if($timeval==90)
			{
				$timeval = $timenow-24*60*60*90;
			}
		
			//查找此域名的流量统计
			$sql = "SELECT time,sum(user_down) user_down,sum(user_up) user_up,sum(upstream_down) upstream_down,sum(upstream_up) upstream_up FROM realtime_list_day WHERE group_id='$group_id' AND time>=$timeval group BY time   ORDER BY time ASC";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'节点不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}	
		
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
				$user_down = mysql_result($result2,$k,"user_down");
				$user_up = mysql_result($result2,$k,"user_up");
				$upstream_down = mysql_result($result2,$k,"upstream_down");				
				$upstream_up = mysql_result($result2,$k,"upstream_up");										
				
				$aryDataDown[$k][0] = $stat_time;  //date('Y/m/d H:i:s',$time);
				$aryDataDown[$k][1] = round($user_down/(1024*1024),2);	
				
				$aryDataUp[$k][0] = $stat_time;  //date('Y/m/d H:i:s',$time);
				$aryDataUp[$k][1] = round($user_up/(1024*1024),2);
				
				$aryUpstreamDataDown[$k][0] = 	$stat_time;	
				$aryUpstreamDataDown[$k][1] = 	round($upstream_down/(1024*1024),2);	
				
				$aryUpstreamDataUp[$k][0] = 	$stat_time;	
				$aryUpstreamDataUp[$k][1] = 	round($upstream_up/(1024*1024),2);					
			}
			
			$aryAllData[0]["name"]="用户下载流量";
			$aryAllData[0]["data"]=$aryDataDown;	
			
			$aryAllData[1]["name"]="用户上传流量";
			$aryAllData[1]["data"]=$aryDataUp;	
			
			$aryAllData[2]["name"]="源站上传流量";
			$aryAllData[2]["data"]=$aryUpstreamDataDown;	
			
			$aryAllData[3]["name"]="源站下载流量";
			$aryAllData[3]["data"]=$aryUpstreamDataUp;							
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);	
	}		
	else if($sAction=="connect")
	{
		$group_id 	= isset($_GET['group_id'])?$_GET['group_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		if(!is_numeric($group_id) || !is_numeric($timeval))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
				
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$aryAllData = array();
			
			/*$sql = "SELECT * FROM fikcdn_node WHERE id=$group_id";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2 || mysql_num_rows($result2)<=0)
			{
				$aryResult = array('Return'=>'False','2.ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}*/
			
			$timenow=time();
			
			if($timeval==60)
			{
				$timeval1 = mktime(0,0,0,date("m"),0,date("Y"));
				$timeval2 = mktime(0,0,0,date("m")-1,0,date("Y"));
				$sql = "SELECT time,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>=$timeval1 AND time<$timeval2 group BY time ORDER BY time ASC";
			}
			else
			{
				if($timeval==1)
				{
					$timeval = $timenow-24*60*60;
				}
				else if($timeval==7)
				{
					$timeval = $timenow-24*60*60*7;
				}
				else if($timeval==30)
				{
					$timeval = $timenow-24*60*60*30;
				}
				else if($timeval==15)
				{
					$timeval = $timenow-24*60*60*15;
				}
				else
				{
					exit();
				}
				//查找此域名的流量统计
				$sql = "SELECT time,sum(CurrentUserConnections) CurrentUserConnections,sum(CurrentUpstreamConnections) CurrentUpstreamConnections FROM realtime_list WHERE group_id='$group_id' AND time>=$timeval group BY time ORDER BY time ASC";
			}
			$result2 = mysql_query($sql,$db_link);
			if(!$result2)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'服务器不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}			
			
			$aryDataDown=array();
			$aryDataUp=array();
			
			$row_count2 = mysql_num_rows($result2);	
			for($k=0;$k<$row_count2;$k++)
			{
				$stat_time = mysql_result($result2,$k,"time");
				$CurrentUserConnections = mysql_result($result2,$k,"CurrentUserConnections");
				$CurrentUpstreamConnections = mysql_result($result2,$k,"CurrentUpstreamConnections");						
				
				$aryDataDown[$k][0] = $stat_time;//+8*3600*1000;  //date('Y/m/d H:i:s',$time);
				$aryDataDown[$k][1] = $CurrentUserConnections;	
				
				$aryDataUp[$k][0] = $stat_time;//+8*3600*1000;  //date('Y/m/d H:i:s',$time);
				$aryDataUp[$k][1] = $CurrentUpstreamConnections;				
			}
			
			$aryAllData[0]["name"]="用户并发连接数";
			$aryAllData[0]["data"]=$aryDataDown;	
			
			$aryAllData[1]["name"]="源站并发连接数";
			$aryAllData[1]["data"]=$aryDataUp;	
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);	
	}
}
else if($sMod=="proxy")
{
	if($sAction=="max_bandwidth")
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
			
			$sql = "SELECT * FROM fikcdn_domain WHERE id=$domain_id";
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
			
			if($timeval==60)
			{
				//上月
				$timeval1 = mktime(0,59,59,date("m"),1,date("Y"));
				$timeval2 = mktime(0,0,0,date("m")-1,1,date("Y"));
				$sql = "SELECT * FROM domain_stat_host_max_bandwidth WHERE domain_id='$domain_id' AND time>=$timeval2 AND time<$timeval1 ORDER BY time ASC";
			}
			else if($timeval==30)
			{
				//本月		
				$timeval1 = mktime(0,0,0,date("m"),1,date("Y"));
				$sql = "SELECT * FROM domain_stat_host_max_bandwidth WHERE domain_id='$domain_id' AND time>=$timeval1 ORDER BY time ASC";
			}
			else
			{
				if($timeval==1)
				{
					$timeval = $timenow-24*60*60;
				}
				else if($timeval==3)
				{
					$timeval = $timenow-24*60*60*3;
				}				
				else if($timeval==7)
				{
					$timeval = $timenow-24*60*60*7;
				}
				else if($timeval==30)
				{
					$timeval = $timenow-24*60*60*30;
				}
			
				//查找此域名的流量统计
				$sql = "SELECT * FROM domain_stat_host_max_bandwidth WHERE domain_id='$domain_id' AND time>=$timeval ORDER BY time ASC";
			}			$result2 = mysql_query($sql,$db_link);
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
				$bandwidth_down = mysql_result($result2,$k,"bandwidth_down");
				$bandwidth_up = mysql_result($result2,$k,"bandwidth_up");						
				
				$aryDataDown[$k][0] = $stat_time;
				$aryDataDown[$k][1] = $bandwidth_down;	
				
				$aryDataUp[$k][0] = $stat_time;
				$aryDataUp[$k][1] = $bandwidth_up;				
			}
			
			$aryAllData[0]["name"]="下载峰值带宽";
			$aryAllData[0]["data"]=$aryDataDown;
			
			$aryAllData[1]["name"]="上传峰值带宽";
			$aryAllData[1]["data"]=$aryDataUp;
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);
	}	
	else if($sAction=="bandwidth")
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
			
			$sql = "SELECT * FROM fikcdn_domain WHERE id=$domain_id";
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
				$bandwidth_down = mysql_result($result2,$k,"bandwidth_down");
				$bandwidth_up = mysql_result($result2,$k,"bandwidth_up");						
				
				$aryDataDown[$k][0] = $stat_time;
				$aryDataDown[$k][1] = $bandwidth_down;	
				
				$aryDataUp[$k][0] = $stat_time;
				$aryDataUp[$k][1] = $bandwidth_up;				
			}
			
			$aryAllData[0]["name"]="用户下载带宽";
			$aryAllData[0]["data"]=$aryDataDown;	
			
			$aryAllData[1]["name"]="用户上传带宽";
			$aryAllData[1]["data"]=$aryDataUp;	
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);
	}
	else if($sAction=="DownloadCount")
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
			
			$sql = "SELECT * FROM fikcdn_domain WHERE id=$domain_id";
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
			
			if($timeval==7)
			{
				$timeval = $timenow-24*60*60*15;
			}
			else if($timeval==30)
			{
				$timeval = $timenow-24*60*60*30;
			}
			else if($timeval==90)
			{
				$timeval = $timenow-24*60*60*90;
			}
		
			//查找此域名的流量统计
			$sql = "SELECT * FROM domain_stat_group_day WHERE domain_id='$domain_id' AND time>=$timeval ORDER BY time ASC";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}			
			
			$aryDataDown=array();
			$aryDataUp=array();
			
			$row_count2 = mysql_num_rows($result2);	
			for($k=0;$k<$row_count2;$k++)
			{
				$stat_time = mysql_result($result2,$k,"time");
				$DownloadCount = mysql_result($result2,$k,"DownloadCount");
				$UploadCount = mysql_result($result2,$k,"UploadCount");						
				
				$aryDataDown[$k][0] = $stat_time;  
				$aryDataDown[$k][1] = round($DownloadCount/1024,2);	
				
				$aryDataUp[$k][0] = $stat_time;
				$aryDataUp[$k][1] = round($UploadCount/1024,2);				
			}
			
			$aryAllData[0]["name"]="日用户下载流量";
			$aryAllData[0]["data"]=$aryDataDown;
			
			$aryAllData[1]["name"]="日用户上传流量";
			$aryAllData[1]["data"]=$aryDataUp;			
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);
	}
	else if($sAction=="RequestCount")
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
			
			$sql = "SELECT * FROM fikcdn_domain WHERE id=$domain_id";
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
			
			if($timeval==7)
			{
				$timeval = $timenow-24*60*60*15;
			}
			else if($timeval==30)
			{
				$timeval = $timenow-24*60*60*30;
			}
			else if($timeval==90)
			{
				$timeval = $timenow-24*60*60*90;
			}
		
			//查找此域名的流量统计
			$sql = "SELECT * FROM domain_stat_group_day WHERE domain_id='$domain_id' AND time>=$timeval ORDER BY time ASC";
	
			$result2 = mysql_query($sql,$db_link);
			if(!$result2)
			{
				echo $sql;
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}			
			
			$aryDataDown=array();

			$row_count2 = mysql_num_rows($result2);	
			for($k=0;$k<$row_count2;$k++)
			{
				$stat_time = mysql_result($result2,$k,"time");
				$DownloadCount = mysql_result($result2,$k,"RequestCount");			
				
				$aryDataDown[$k][0] = $stat_time;
				$aryDataDown[$k][1] = $DownloadCount;				
			}
			
			$aryAllData[0]["name"]="日请求量";
			$aryAllData[0]["data"]=$aryDataDown;		
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);
	}					
}
else if($sMod=="product")
{
	if($sAction=="DayDownloadCount")
	{		
		$buy_id 	= isset($_GET['buy_id'])?$_GET['buy_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$sql = "SELECT * FROM fikcdn_buy WHERE id=$buy_id";
			$result = mysql_query($sql,$db_link);
			if($result && mysql_num_rows($result)>0)
			{
				$aryAllData = array();
				
				$this_buy_id	 = mysql_result($result,0,"id");
				$this_username = mysql_result($result,0,"username");
				$this_product_id = mysql_result($result,0,"product_id");
				
				$sql = "SELECT * FROM fikcdn_product WHERE id=$this_product_id";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$product_name = mysql_result($result1,0,"name");
				}
				
				$sql = "SELECT * FROM fikcdn_client WHERE username='$this_username'";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$company_name = mysql_result($result1,0,"company_name");
					$realname = mysql_result($result1,0,"realname");
				}
				
				$timenow = time();
				
				if($timeval==3)
				{
					$timeval = $timenow-24*60*60*3;
				}				
				else if($timeval==7)
				{
					$timeval = $timenow-24*60*60*7;
				}
				else if($timeval==30)
				{
					$timeval = $timenow-24*60*60*30;
				}
				else if($timeval==90)
				{
					$timeval = $timenow-24*60*60*90;
				}				
				
				//查找此域名的流量统计
				$sql = "SELECT * FROM domain_stat_product_day WHERE buy_id=$this_buy_id AND time>$timeval ORDER BY time ASC";
				$result2 = mysql_query($sql,$db_link);
				if(!$result2)
				{
					exit();
				}			
				
				$aryDataDown=array();
				$aryDataUp=array();
				
				$row_count2 = mysql_num_rows($result2);	
				for($k=0;$k<$row_count2;$k++)
				{
					$stat_time = mysql_result($result2,$k,"time");
					$DownloadCount = mysql_result($result2,$k,"DownloadCount");					
					$UploadCount = mysql_result($result2,$k,"UploadCount");			
					
					$aryDataDown[$k][0] = $stat_time;
					$aryDataDown[$k][1] = $DownloadCount;	
					
					$aryDataUp[$k][0] = $stat_time;
					$aryDataUp[$k][1] = $UploadCount;				
				}
				
				$aryAllData[0]["name"]="日用户下载流量";
				$aryAllData[0]["data"]=$aryDataDown;
				
				$aryAllData[1]["name"]="日用户上传流量";
				$aryAllData[1]["data"]=$aryDataUp;
			}
			echo  json_encode($aryAllData);
			mysql_close($db_link);
		}		
	}	
	else if($sAction=="DayRequestCount")
	{		
		$buy_id 	= isset($_GET['buy_id'])?$_GET['buy_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$sql = "SELECT * FROM fikcdn_buy WHERE id=$buy_id";
			$result = mysql_query($sql,$db_link);
			if($result && mysql_num_rows($result)>0)
			{		
				$aryAllData = array();		
				$this_buy_id	 = mysql_result($result,0,"id");
				$this_username = mysql_result($result,0,"username");
				$this_product_id = mysql_result($result,0,"product_id");
				
				$sql = "SELECT * FROM fikcdn_product WHERE id=$this_product_id";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$product_name = mysql_result($result1,0,"name");
				}
				
				$sql = "SELECT * FROM fikcdn_client WHERE username='$this_username'";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$company_name = mysql_result($result1,0,"company_name");
					$realname = mysql_result($result1,0,"realname");
				}
				
				$timenow = time();
				
				if($timeval==7)
				{
					$timeval = $timenow-24*60*60*15;
				}
				else if($timeval==30)
				{
					$timeval = $timenow-24*60*60*30;
				}
				else if($timeval==90)
				{
					$timeval = $timenow-24*60*60*90;
				}	
				
				//查找此域名的流量统计
				$sql = "SELECT * FROM domain_stat_product_day WHERE buy_id=$this_buy_id AND time>$timeval ORDER BY time ASC";
				$result2 = mysql_query($sql,$db_link);
				if(!$result2)
				{
					exit();
				}			
				
				$aryData=array();
				$row_count2 = mysql_num_rows($result2);	
				for($k=0;$k<$row_count2;$k++)
				{
					$stat_time = mysql_result($result2,$k,"time");
					$RequestCount = mysql_result($result2,$k,"RequestCount");					
					
					$aryData[$k][0] = $stat_time;
					$aryData[$k][1] = $RequestCount;				
				}
				
				$label_name =$product_name.'('.$this_username.')';
				$aryAllData[0]["name"]="日请求数量";
				$aryAllData[0]["data"]=$aryData;	
			}
			echo  json_encode($aryAllData);
			mysql_close($db_link);
		}		
	}	
	else if($sAction=="bandwidth")
	{
		$buy_id 	= isset($_GET['buy_id'])?$_GET['buy_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$sql = "SELECT * FROM fikcdn_buy WHERE id=$buy_id";
			$result = mysql_query($sql,$db_link);
			if($result && mysql_num_rows($result)>0)
			{		
				$aryAllData = array();		
				$this_buy_id	 = mysql_result($result,0,"id");
				$this_username = mysql_result($result,0,"username");
				$this_product_id = mysql_result($result,0,"product_id");
				
				$sql = "SELECT * FROM fikcdn_product WHERE id=$this_product_id";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$product_name = mysql_result($result1,0,"name");
				}
				
				$timenow=time();
				$nDay1 = date("d")-$timeval;
				
				$timeval1 = mktime(0,0,0,date("m"),$nDay1,date("Y"));
				$timeval2 = $timeval1+24*60*60;
				$sql = "SELECT * FROM domain_stat_product_bandwidth WHERE buy_id=$this_buy_id AND time>=$timeval1 AND time<$timeval2 ORDER BY time ASC";	
				
				//查找此域名的流量统计
				$result2 = mysql_query($sql,$db_link);
				if(!$result2)
				{
					continue;
				}			
				
				$aryDataDown=array();
				$aryDataUp=array();
				
				$row_count2 = mysql_num_rows($result2);	
				for($k=0;$k<$row_count2;$k++)
				{
					$stat_time = mysql_result($result2,$k,"time");
					$bandwidth_down = mysql_result($result2,$k,"bandwidth_down");	
					$bandwidth_up = mysql_result($result2,$k,"bandwidth_up");						
					
					$aryDataDown[$k][0] = $stat_time;
					$aryDataDown[$k][1] = $bandwidth_down;	
					
					$aryDataUp[$k][0] = $stat_time;
					$aryDataUp[$k][1] = $bandwidth_up;			
				}
				
				$aryAllData[0]["name"]="用户下载带宽";
				$aryAllData[0]["data"]=$aryDataDown;
				
				$aryAllData[1]["name"]="用户上传带宽";
				$aryAllData[1]["data"]=$aryDataUp;
			}
			echo  json_encode($aryAllData);
			mysql_close($db_link);
		}		
	}
	else if($sAction=="MaxBandwidth")
	{		
		$buy_id 	= isset($_GET['buy_id'])?$_GET['buy_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$sql = "SELECT * FROM fikcdn_buy WHERE id=$buy_id";
			$result = mysql_query($sql,$db_link);
			if($result && mysql_num_rows($result)>0)
			{		
				$aryAllData = array();		
				$this_buy_id	 = mysql_result($result,0,"id");
				$this_username = mysql_result($result,0,"username");
				$this_product_id = mysql_result($result,0,"product_id");
				
				$sql = "SELECT * FROM fikcdn_product WHERE id=$this_product_id";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$product_name = mysql_result($result1,0,"name");
				}
				
				$timenow=time();
				
				if($timeval==60)
				{
					$timeval1 = mktime(0,59,59,date("m"),1,date("Y"));
					$timeval2 = mktime(0,0,0,date("m")-1,1,date("Y"));
					$sql = "SELECT * FROM domain_stat_product_max_bandwidth WHERE buy_id=$this_buy_id AND time>=$timeval2 AND time<$timeval1 ORDER BY time ASC";
				}			
				else if($timeval==30)
				{
					$timeval1 = mktime(0,0,0,date("m"),1,date("Y"));
					$sql = "SELECT * FROM domain_stat_product_max_bandwidth WHERE buy_id=$this_buy_id AND time>=$timeval1 ORDER BY time ASC";
				}
				else
				{
					if($timeval==1)
					{
						$timeval = $timenow-24*60*60;
					}
					else if($timeval==7)
					{
						$timeval = $timenow-24*60*60*7;
					}
					else if($timeval==30)
					{
						$timeval = $timenow-24*60*60*30;
					}
				
					//查找此域名的流量统计
					$sql = "SELECT * FROM domain_stat_product_max_bandwidth WHERE buy_id=$this_buy_id AND time>=$timeval ORDER BY time ASC";
				}
								
				
				//查找此域名的流量统计
				$result2 = mysql_query($sql,$db_link);
				if(!$result2)
				{
					continue;
				}			
				
				$aryDataDown=array();
				$aryDataUp=array();
				
				$row_count2 = mysql_num_rows($result2);	
				for($k=0;$k<$row_count2;$k++)
				{
					$stat_time = mysql_result($result2,$k,"time");
					$bandwidth_down = mysql_result($result2,$k,"bandwidth_down");	
					$bandwidth_up = mysql_result($result2,$k,"bandwidth_up");						
					
					$aryDataDown[$k][0] = $stat_time;
					$aryDataDown[$k][1] = $bandwidth_down;	
					
					$aryDataUp[$k][0] = $stat_time;
					$aryDataUp[$k][1] = $bandwidth_up;			
				}
				
				$aryAllData[0]["name"]="用户下载峰值带宽";
				$aryAllData[0]["data"]=$aryDataDown;
				
				$aryAllData[1]["name"]="用户上传峰值带宽";
				$aryAllData[1]["data"]=$aryDataUp;
			}
			echo  json_encode($aryAllData);
			mysql_close($db_link);
		}		
	}			
}
?>
