<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/index.css">

	<title>
<?php
	$titles=$_GET['titles'];
	echo  $titles;
?></title>
</head>
<body>
  <div class="navtopbox">
    <div class="navtop">
      <div class="logo">
        <img src="images/LOGO.jpg">
      </div>

   <div class="navwz">
        <ul>
          <ul>
          <li><a href="index.php" id="a">首页</a></li>
          <li><a href="./chanpin/product.html" id="a">产品中心</a></li>
          <li><a href="./gywm/solution.html" id="a">解决方案</a></li>
          <li><a href="./yonghu/boot.html" id="a">使用手册</a></li>
          <li><a href="./gywm/aboutus.html" id="a">关于我们</a></li>
          <li><a href="http://www.15cdn.com/cdn/login.php" id="a">控制台</a></li>
          <li><a href="http://www.tzidc.com/" id="a">IDC业务</a></li>
        </ul>
        </ul>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>

 
 <!--  <div class="slide-bg">
  <div class="slide-wp">
        <div id="slides" class="slides">
            <div>
                <div class="slideChild" style="display:none;">
                    <a class="a-ad js-aAd" href="http://sc.chinaz.com/"></a>
                </div>
                <img class="slideImg" src="images/banner1.jpg" galleryimg="no">
            </div>
            <div>
                <div class="slideChild"></div>
              <img class="slideImg" src="images/banner2.jpg" galleryimg="no">
            </div>
            <div>
                <div class="slideChild">
                    <a class="a-video opa js-aVideo" href="http://sc.chinaz.com/" target="_blank"></a>
                </div>
              <img class="slideImg" src="images/banner3.jpg" galleryimg="no">
            </div>
        </div> 
    </div> 
    </div>  -->
<div style="margin:0 auto; width:70%; height:100px; ">
<div>新闻详情页</div>
<div style="text-align: center;">
<?php
                    include_once("./config/config_global.php");
                    function FikCDNDB_Connect()
                    { 
                      global $_config;
                      
                        // 连接数据库
                      $db_link = mysql_connect($_config['db']['1']['dbhost'],$_config['db']['1']['dbuser'], $_config['db']['1']['dbpw']);
                      //or die("连接数据库错误" . mysql_error());
                      if(!$db_link){
                        return false;
                      }
                      
                      $sql = "SET NAMES ".$_config['db']['1']['dbcharset'];
                      mysql_query($sql,$db_link);
                      mysql_select_db($_config['db']['1']['dbname'],$db_link);
                      
                      return $db_link;  
                    }
                    $db_link = FikCDNDB_Connect();
   
	 
                    $sql="SELECT * FROM `fikcdn_news` WHERE titles='$titles'";
                    $result = mysql_query($sql,$db_link);
                    $data=mysql_fetch_assoc($result);
                    echo "<h1>".$data['titles']."</h1>";
                    
?>
</div>
<div style="text-align: center;     padding: 30px 19px 0 19px;
    line-height: 26px;">
 <?php echo $data['content'];?>
</div>
</div>
</body>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>

<script src="js/jquery.slides.min.js"></script>
<script type="text/javascript" src="js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript" src="js/scroll-v1.js"></script>
<script>

$(function() {
  $('#slides').slidesjs({
    play:{
      active: false,
      effect: "fade",
      auto: true,
      interval: 4000
    },
    effect: {
      fade: {
      speed: 1500,
      crossfade: true
      }
    },
    pagination: {
      active: true
    },
    navigation:{
      active: false
    }
  });
 });
 
</script>
</html>
