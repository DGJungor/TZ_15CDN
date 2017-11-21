<?php
	
include_once('../db/db.php');
include_once('../function/pub_function.php');
include_once('../function/define.php');
include_once("function.php");

//是否登录
if(!FuncClient_IsLogin())
{
	$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoLogin);
	PubFunc_EchoJsonAndExit($aryResult,NULL);
}

$sMod 	 	 = isset($_GET['mod'])?$_GET['mod']:'';
$sAction 	 = isset($_GET['action'])?$_GET['action']:'';

if($sMod=='setting')
{
	if($sAction=="modifypasswd")
	{
		$username 	= $_SESSION['fikcdn_client_username'];
		$IsLogin 	= $_SESSION['fikcdn_client_IsLogin'];
		$oldpasswd 	= isset($_POST['oldpasswd'])?$_POST['oldpasswd']:'';
		$newpasswd 	= isset($_POST['newpasswd'])?$_POST['newpasswd']:'';
		
		if(strlen($username)==0 || $IsLogin!=true)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		if(strlen($oldpasswd)!=32 || strlen($newpasswd)!=32)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{	
			$escape_oldpasswd = mysql_real_escape_string($oldpasswd); 
			$escape_newpasswd = mysql_real_escape_string($newpasswd); 		
			
			$sql = "SELECT * FROM fikcdn_client WHERE username='$username'"; 
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'修改密码失败，用户不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}	
			
			$passwd  = mysql_result($result,0,"password");	
			if($escape_oldpasswd != $passwd)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrOldPasswd,'ErrorMsg'=>'修改密码失败，原密码错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}

			$sql = "UPDATE fikcdn_client SET password='$escape_newpasswd' WHERE username='$username';";
			$result = mysql_query($sql,$db_link);	
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate,'ErrorMsg'=>'修改密码失败，更新数据库错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$aryResult = array('Return'=>'True','ErrorNo'=>$PubDefine_ResultOK);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'修改密码失败，连接数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}	
	}
	else if($sAction=="modifyinfo")
	{		
		$txtRealname 	 = isset($_POST['Realname'])?$_POST['Realname']:'';
		$txtAddr	 = isset($_POST['Addr'])?$_POST['Addr']:'';	
		$txtRelation	 = isset($_POST['Relation_sale'])?$_POST['Relation_sale']:'';	
		$txtPhone	 = isset($_POST['Phone'])?$_POST['Phone']:'';	
		$txtQQ	 = isset($_POST['QQ'])?$_POST['QQ']:'';
		
		if(strlen($txtRealname)<=0 || strlen($txtRealname)>64 ||strlen($txtAddr)<=0 || strlen($txtAddr)>128 )
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		if(strlen($txtPhone)<=0 || strlen($txtPhone)>20 ||strlen($txtQQ)<=0 || strlen($txtQQ)>16 )
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
				
		$client_username 	= $_SESSION['fikcdn_client_username'];
		
		$txtRealname = htmlspecialchars($txtRealname); 
		$txtAddr = htmlspecialchars($txtAddr); 
		$txtPhone = htmlspecialchars($txtPhone);
		$txtQQ = htmlspecialchars($txtQQ);
		$txtRelation = htmlspecialchars($txtRelation);		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{	
			$txtRealname = mysql_real_escape_string($txtRealname); 
			$txtAddr = mysql_real_escape_string($txtAddr); 
			$txtPhone = mysql_real_escape_string($txtPhone);
			$txtQQ = mysql_real_escape_string($txtQQ);
			$txtRelation = mysql_real_escape_string($txtRelation);
			$_SESSION['fikcdn_client_nick'] = $txtRealname;	
			if(empty($txtRelation)){
			$belong="";
			$sql = "UPDATE fikcdn_buy SET sale_group='',relation_sale='$txtRelation' WHERE username='$client_username';";
			$result = mysql_query($sql,$db_link);
			$sql = "UPDATE fikcdn_domain SET sale_group='',relation_sale='$txtRelation' WHERE username='$client_username';";
			$result = mysql_query($sql,$db_link);	
			}else{
				$sql="SELECT belong FROM `fikcdn_admin` WHERE username='$txtRelation'";
				$result = mysql_query($sql,$db_link);
				$belong 			= mysql_result($result,0,"belong");
				$sql = "UPDATE fikcdn_buy SET sale_group='$belong',relation_sale='$txtRelation' WHERE username='$client_username';";
			$result = mysql_query($sql,$db_link);	
			$sql = "UPDATE fikcdn_domain SET sale_group='$belong',relation_sale='$txtRelation' WHERE username='$client_username';";
			$result = mysql_query($sql,$db_link);	
			}	
			 		
			$sql = "UPDATE fikcdn_client SET sale_group='$belong',realname='$txtRealname',addr='$txtAddr',phone='$txtPhone',qq='$txtQQ',relation_sale='$txtRelation' WHERE username='$client_username';";
			$result = mysql_query($sql,$db_link);	

			if(!$result)
			{			
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate,'ErrorMsg'=>'修改用户信息失败，更新数据库错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$aryResult = array('Return'=>'True','username'=>$client_username);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}	
		else
		{			
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'修改用户信息失败，连接数据库失败。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}			
	}
}
else if($sMod=="logs")
{
	if($sAction=="clearloginlog")
	{
		$txtPassword = isset($_POST['passwd'])?$_POST['passwd']:'';
		$timeval = isset($_POST['timeval'])?$_POST['timeval']:'';
		if(strlen($txtPassword)<=0 || strlen($txtPassword)>64 || !is_numeric($timeval))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam);
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		$txtPassword = htmlspecialchars($txtPassword);
		$admin_username 	= $_SESSION['fikcdn_admin_username'];
				
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{	
			$txtPassword = mysql_real_escape_string($txtPassword); 
			
			$sql = "SELECT * FROM fikcdn_admin WHERE username='$admin_username' AND password='$txtPassword'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrPasswd);
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}	
			if($timeval>0)
			{	
				$login_time = time()-($timeval*24*60*60);
				$sql = "DELETE FROM fikcdn_login_log WHERE login_time<$login_time";
			}
			else
			{
				$sql = "DELETE FROM fikcdn_login_log";
			}
			
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrDel);
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$aryResult = array('Return'=>'True');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}
	}
}
else if($sMod=="recharge")
{
	if($sAction=="add")
	{
		$txtUsername = isset($_POST['username'])?$_POST['username']:'';	
		$txtPasswd   = isset($_POST['passwd'])?$_POST['passwd']:'';	
		$txtSerialNo = isset($_POST['serialno'])?$_POST['serialno']:'';	
		$nBankname = isset($_POST['bankname'])?$_POST['bankname']:'';	
		$txtTransactor= isset($_POST['transactor'])?$_POST['transactor']:'';	
		$nMoney	 = isset($_POST['money'])?$_POST['money']:'';
		$txtBackup	 = isset($_POST['backup'])?$_POST['backup']:'';		
		
		if(!is_numeric($nMoney) || !is_numeric($nBankname) || ($nBankname<0) || $nBankname>4)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam);
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		if($nMoney<=0 ) //|| $nMoney>
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam);
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
				
		if( strlen(txtUsername)<=0 || strlen(txtUsername)>64 || strlen($txtPasswd)<=0 || strlen($txtPasswd) > 64 || strlen($txtSerialNo)<=0 || strlen($txtSerialNo) > 128 )
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam);
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
	
		if(strlen($txtTransactor)<=0 || strlen($txtTransactor) > 64 ||  strlen($txtBackup) > 128)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam);
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}		
		
		$txtBankname = $PubDefine_BankName[$nBankname];

		$txtUsername = htmlspecialchars($txtUsername);
		$txtPasswd = htmlspecialchars($txtPasswd);
		$txtSerialNo = htmlspecialchars($txtSerialNo);
		$txtBankname = htmlspecialchars($txtBankname);
		$txtTransactor = htmlspecialchars($txtTransactor);
		$txtBackup = htmlspecialchars($txtBackup);
		
		$admin_username =$_SESSION['fikcdn_admin_username'];
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{
			$txtUsername = mysql_real_escape_string($txtUsername);
			$txtPasswd = mysql_real_escape_string($txtPasswd);
			$txtSerialNo = mysql_real_escape_string($txtSerialNo);
			$txtBankname = mysql_real_escape_string($txtBankname);
			$txtTransactor = mysql_real_escape_string($txtTransactor);
			$txtBackup = mysql_real_escape_string($txtBackup);
			
			$sql="SELECT * FROM fikcdn_admin WHERE username='$admin_username' AND password='$txtPasswd'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{	
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrPasswd);
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$sql="SELECT * FROM fikcdn_client WHERE username='$txtUsername'";			
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery);
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$sql="UPDATE fikcdn_client SET money=money+$nMoney WHERE username='$txtUsername';";			
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate);
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$sql="SELECT * FROM fikcdn_client WHERE username='$txtUsername'";			
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery);
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			$money_total = mysql_result($result,0,"money");	
			
			$timenow = time();
			//插入充值记录
			$sql="INSERT INTO fikcdn_recharge(id,username,money,balance,time,transactor,opt_username,bank_name,serial_no,note)
				VALUES(NULL,'$txtUsername','$nMoney','$money_total','$timenow','$txtTransactor','$admin_username','$txtBankname','$txtSerialNo','$txtBackup')";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{	
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrInsert);
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			$re_id = mysql_insert_id($db_link);
			
			$aryResult = array('Return'=>'True','id'=>$re_id);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}	
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB);
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}	
	
	}
}

?>
