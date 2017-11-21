<?php 
    error_reporting(0);
    header("content-Type: text/html; charset=utf-8");
    set_time_limit(120);
    $domain = isset($_GET['domain']) ? chop($_GET['domain']) : '';
    $host = isset($_GET['hostname']) ? chop(str_replace('http://','',$_GET['hostname'])) : '';
    $port = isset($_GET['port']) ? chop($_GET['port']) : '80';
     
            $fp = @fsockopen($host,$port,$errno,$errstr,3);
            $get = "GET / HTTP/1.1\r\nHost:".$domain."\r\nConnection: Close\r\n\r\n";
            @fputs($fp,$get);
            $data = '';
            while ($fp && !feof($fp))
            $data .= fread($fp, 1024);
            @fclose($fp);
            
            if(!$data){
                echo 0;
            }
            else{
                echo 1;
                }
    
?>
 
 