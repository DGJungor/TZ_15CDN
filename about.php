<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>关于我们</title>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?e9babec693a691e0f89aea867d6c48e6";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</head>
<body>
<link rel="stylesheet" href="css/index.css">
<link rel=stylesheet type="text/css" href="css/common.css" />
<link rel=stylesheet type="text/css" href="css/about.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
var aboutG_premenu;
function blueMenuItem(d){
	aboutG_premenu.removeClass("menu-sub-onselect");
	aboutG_premenu = d;
	d.addClass("menu-sub-onselect");
}
$(function(){
	aboutG_premenu = $("#about-com");
	aboutG_premenu.addClass("menu-sub-onselect");
	$("#content-about").show();
	
	
	$(window).resize(function(){
		$("#bgr").css("height",$(document).height());
	});
	$(".img-box").click(function(){
		$("#bgr").css("height",$(document).height());
		$("#big-pic").attr("src","images/about/honor/"+$(this).attr("id")+".jpg");
		center("#pic");
		$("#bgr").show();
		$("#pic").show();
	});
	$("#bgr").click(function(){
		$("#pic").hide();
		$("#bgr").hide();
		$("#big-pic").attr("src","");
	});
	$("#pic").click(function(){
		$("#pic").hide();
		$("#bgr").hide();
		$("#big-pic").attr("src","");
	});
	
	$("#about-com").click(function(){
		hideAllModels();
		blueMenuItem($(this));
		$("#content-about").show();

	});
	$("#about-honor").click(function(){
		hideAllModels();
		blueMenuItem($(this));
		$("#content-honor").show();
	});
	$("#about-contact-us").click(function(){
		hideAllModels();
		blueMenuItem($(this));
		$("#content-contact-us").show();
	});
	$("#about-friendly-link").click(function(){
/* 		hideAllModels();
		$("#bussness-us").show(); */
	});
	
});

function center(obj){
	 var windowWidth = document.documentElement.clientWidth;  
	 var windowHeight = document.documentElement.clientHeight;  
	 var popupHeight = $(obj).height();  
	 var popupWidth = $(obj).width();   
	 $(obj).css({  
	  "position": "absolute",  
	  "top": (windowHeight-popupHeight)/2+$(document).scrollTop(),  
	  "left": (windowWidth-popupWidth)/2  
	 });
}
function hideAllModels(){
	$("#content-about").hide();
	$("#content-honor").hide();
	$("#content-contact-us").hide();
	$("#bussness-us").hide();
}
</script>
<?php include("header.php");?>
<div id="mid">
	<div id="content-1" class="content-about"></div>
	<div id="content-2" class="rk-tag-box">
		<div class="left-menu-panel">
			<div class="menu-head">
					<span>公司介绍</span>
			</div>
			<ul>
				<li class="menu-sub" id="about-com">公司介绍</li>
				<li class="menu-sub" id="about-honor">公司荣誉</li>
				<li class="menu-sub" id="about-contact-us">联系我们</li>
				<li class="menu-sub" id="about-friendly-link">友情链接</li>
			</ul>
			<div class="menu-head">
					<span>新闻中心</span>
			</div>
			<ul>
				<li class="menu-sub" id="news-our">公司新闻</li>
				<li class="menu-sub" id="news-peer">行业新闻</li>
			</ul>
		</div>
		<div id="content-about" class="right-content" style="display:none;" >
			<div>
				<h1 class="h1en" id="h1about">ABOUT</h1>
				<h1 class="h1cn" id="h1aboutcn">公司介绍</h1>
				<p>
				作为一家专注于互联网安全技术研究的现代网络综合服务性的高科技公司，腾正科技一直致力于为企业提供领先，安全，高效，全面的IDC数据中心，数据安全，CDN内容加速，系统研发，电商平台支撑等互联网运营服务。腾正科技与中科院联合打造的TzCloud公有云-云计算操作系统，不仅与中科院达成战略性合作，并且获得了中国信息安全评测中心最高等级安全认证，给予”安全可控优秀云计算解决方案”的评价。腾正云投入使用后，已经与曙光等知名公司建立了深度合作，并服务了南方报业集团等上百家企事业单位。
				</p>
				<p>
				腾正科技位于东莞松山湖国际金融IT研发创新园，旗下全资拥有两家子公司，长沙正易网络科技有限公司和广东腾川网络科技有限公司及多家分子公司。自成立起，依托自身雄厚的技术力量团队及丰富的互联网技术经验，腾正科技迅速建立了完善的服务体系，不仅在网络运营领域取得了骄人的成绩，还获得多个自有的软件著作权及专利。在强大的研发人员队伍及庞大的信息资源支持下，腾正科技已成长为国内互联网基础网络服务领域具有较强影响力的公司。
				</p>
				<p>
				面对互联网产业蓬勃发展的全球化格局，为了更好的迎接互联网时代的浪潮，腾正科技以提供安全的互联网解决方案为目标，以市场的需求和业务的发展为先导，以互联网安全技术为核心，以专业，快速的售后服务为支撑，本着坚定的信念，开拓创新，为广大的互联网同行与合作伙伴提供优质的产品和完善的服务。
				</p>
				<p>
				在您的成功路上，有我们为您护航；腾正科技，期待与您共享更好的明天。
				</p>
			</div>
		</div>
		<div id="content-honor" class="right-content" style="display:none;" >
			<div>
				<h1 class="h1en" id="h1honor">HONOR</h1>
				<h1 class="h1cn" id="h1honorcn">公司荣誉</h1>
				<div class="honor-pannel">
					<div class="honor-box">
						<img id="l2016020101" class="img-box" src="images/about/honor/20160201s01.jpg" />
					</div>
					<div class="honor-box">
						<img id="l2016020103" class="img-box" src="images/about/honor/20160201s03.jpg" />
					</div>
					<div class="honor-box">
						<img id="l2016020104" class="img-box" src="images/about/honor/20160201s04.jpg" />
					</div>
					<div class="honor-box">
						<img id="l2016020105" class="img-box" src="images/about/honor/20160201s05.jpg" />
					</div>
					<div class="honor-box">
						<img id="l2016020107" class="img-box" src="images/about/honor/20160201s07.jpg" />
					</div>
					<div class="honor-box">
						<img id="l2016020108" class="img-box" src="images/about/honor/20160201s08.png" />
					</div>
					<div class="honor-box">
						<img id="l2016030301" class="img-box" src="images/about/honor/20160303s01.jpg" />
					</div>
					<div class="honor-box">
						<img id="l20160714" class="img-box" src="images/about/honor/20160714.jpg" />
					</div>
				</div>
			</div>
		</div>
		<div id="content-contact-us" class="right-content" style="display:none;" >
			<div>
					<h1 class="h1en" id="h1contact">CONTACT</h1>
					<h1 class="h1cn" id="h1contactcn">联系我们</h1>
			</div>
			<div id="call-us">
				<div id="basic-addr">
					<h2 class="ctitle">广东腾正计算机科技有限公司</h2>
					<span class="caddr">地址：广东省东莞市松山湖科技十路国际金融IT研发中心2栋B座</span>
					<span id="czipcode">邮编：523000</span>
				</div>
				<div id="basic-phone">
					<ul>
						<li id="cphone">电话：0769-22226555</li>
						<li id="cfax">传真：0769-22385552</li>
						<li id="cmail">邮箱：JOB@TZIDC.COM</li>
						<li id="cphones">电话：0769-22895563&#12288;&#12288;0769-22895536<br/>&#12288;&#12288;&#12288;0769-22895561&#12288;&#12288;0769-22895564</li>
					</ul>
					
				</div>
			</div>
			
			<div id="baidu-map">
				<!--引用百度地图API-->
				<style type="text/css">
				    .iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
				    .iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word}
				</style>
				<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
				  <!--百度地图容器-->
				  <div style="width:388px;height:264px;border:#ccc solid 1px;" id="dituContent"></div>
				<script type="text/javascript">
				    //创建和初始化地图函数：
				    function initMap(){
				        createMap();//创建地图
				        setMapEvent();//设置地图事件
				        addMapControl();//向地图添加控件
				        addMarker();//向地图中添加marker
				    }
				    
				    //创建地图函数：
				    function createMap(){
				        var map = new BMap.Map("dituContent");//在百度地图容器中创建一个地图
				        var point = new BMap.Point(113.892225,22.952631);//定义一个中心点坐标
				        map.centerAndZoom(point,18);//设定地图的中心点和坐标并将地图显示在地图容器中
				        window.map = map;//将map变量存储在全局
				    }
				    
				    //地图事件设置函数：
				    function setMapEvent(){
				        map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
				        map.enableScrollWheelZoom();//启用地图滚轮放大缩小
				        map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
				        map.enableKeyboard();//启用键盘上下左右键移动地图
				    }
				    
				    //地图控件添加函数：
				    function addMapControl(){
				        //向地图中添加缩放控件
					var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
					map.addControl(ctrl_nav);
				        //向地图中添加缩略图控件
					var ctrl_ove = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:1});
					map.addControl(ctrl_ove);
				        //向地图中添加比例尺控件
					var ctrl_sca = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
					map.addControl(ctrl_sca);
				    }
				    
				    //标注点数组
				    var markerArr = [{title:"广东腾正科技",content:"广东腾正计算机科技有限公司",point:"113.893933|22.951773",isOpen:0,icon:{w:21,h:21,l:0,t:0,x:6,lb:5}}
						 ];
				    //创建marker
				    function addMarker(){
				        for(var i=0;i<markerArr.length;i++){
				            var json = markerArr[i];
				            var p0 = json.point.split("|")[0];
				            var p1 = json.point.split("|")[1];
				            var point = new BMap.Point(p0,p1);
							var iconImg = createIcon(json.icon);
				            var marker = new BMap.Marker(point,{icon:iconImg});
							var iw = createInfoWindow(i);
							var label = new BMap.Label(json.title,{"offset":new BMap.Size(json.icon.lb-json.icon.x+10,-20)});
							marker.setLabel(label);
				            map.addOverlay(marker);
				            label.setStyle({
				                        borderColor:"#808080",
				                        color:"#333",
				                        cursor:"pointer"
				            });
							
							(function(){
								var index = i;
								var _iw = createInfoWindow(i);
								var _marker = marker;
								_marker.addEventListener("click",function(){
								    this.openInfoWindow(_iw);
							    });
							    _iw.addEventListener("open",function(){
								    _marker.getLabel().hide();
							    })
							    _iw.addEventListener("close",function(){
								    _marker.getLabel().show();
							    })
								label.addEventListener("click",function(){
								    _marker.openInfoWindow(_iw);
							    })
								if(!!json.isOpen){
									label.hide();
									_marker.openInfoWindow(_iw);
								}
							})()
				        }
				    }
				    //创建InfoWindow
				    function createInfoWindow(i){
				        var json = markerArr[i];
				        var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>"+json.content+"</div>");
				        return iw;
				    }
				    //创建一个Icon
				    function createIcon(json){
				        var icon = new BMap.Icon("http://app.baidu.com/map/images/us_mk_icon.png", new BMap.Size(json.w,json.h),{imageOffset: new BMap.Size(-json.l,-json.t),infoWindowOffset:new BMap.Size(json.lb+5,1),offset:new BMap.Size(json.x,json.h)})
				        return icon;
				    }
				    
				    initMap();//创建和初始化地图
				</script>
			</div>
			<div id="bussness-us">
				<h2 class="ctitle">业务合作</h2>
				<span class="caddr">地址：广东省东莞市松山湖科技十路国际金融IT研发中心2栋B座</span>
				<span id="cphone-again">电话：0769-22226555（分机号8359）</span>
				<span id="cmail-again">合作邮箱：MOLIN@TZIDC.COM</span>
			</div>
			<div id="tech-support-24h">
				<h2 class="ctitle">24小时技术支持</h2>
				<span id="cphone-tech-support">电话：0769-22385558</span>
			</div>
			<div ></div>
		</div>
		<div id="content-about-f-link" class="right-content" style="display:none;" >
		</div>
		<div id="content-about-c-news" class="right-content" style="display:none;" >
		</div>
		<div id="content-about-i-news" class="right-content" style="display:none;" >
		</div>
	</div>
</div>
<div id="bgr" style="display: block; width: 100%;height: 1080px;background: black;position:absolute;top:0px;opacity: 0.5;display: none"></div>
<div id="pic" style="display: block; width: 800px;height: 400px;position: absolute;opacity: 1; left: 50%;margin-left: -400px; top:0px;margin-top: 0px;display: none;margin: 5px;"><img id="big-pic" style="width: 100%;border:5px solid white;"></div>

<?php include("footer.php");?>
</body>
</html>