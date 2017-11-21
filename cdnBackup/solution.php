<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>15CDN-解决方案</title>
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
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
	var solutionG_premenu;
	$(function(){
		hideModles();	
		$("#accelerate-ebiz-c").show();
		$("#accelerate-ebiz").addClass("menu-sub-onselect");
		solutionG_premenu = "accelerate-ebiz";
		$("#accelerate-ebiz").click(function(){
			hideModles();
			removeClass(solutionG_premenu,"menu-sub-onselect");
			solutionG_premenu = "accelerate-ebiz";
			$(this).addClass("menu-sub-onselect");
			$("#accelerate-ebiz-c").show();
		});
		$("#accelerate-portals").click(function(){
			hideModles();
			removeClass(solutionG_premenu,"menu-sub-onselect");
			solutionG_premenu = "accelerate-portals";
			$(this).addClass("menu-sub-onselect");
			$("#accelerate-portals-c").show();
		});
		$("#accelerate-games").click(function(){
			hideModles();
			removeClass(solutionG_premenu,"menu-sub-onselect");
			solutionG_premenu = "accelerate-games";
			$(this).addClass("menu-sub-onselect");
			$("#accelerate-games-c").show();
		});
		$("#accelerate-video").click(function(){
			hideModles();
			removeClass(solutionG_premenu,"menu-sub-onselect");
			solutionG_premenu = "accelerate-video";
			$(this).addClass("menu-sub-onselect");
			$("#accelerate-video-c").show();
		});
		$("#accelerate-company-site").click(function(){
			hideModles();
			removeClass(solutionG_premenu,"menu-sub-onselect");
			solutionG_premenu = "accelerate-company-site";
			$(this).addClass("menu-sub-onselect");
			$("#accelerate-comp-c").show();
		});
	});
	
	function hideModles(){
		$("#accelerate-ebiz-c").hide();
		$("#accelerate-portals-c").hide();
		$("#accelerate-games-c").hide();
		$("#accelerate-video-c").hide();
		$("#accelerate-comp-c").hide();
	}
	
	function removeClass(d,c){
		$("#"+d).removeClass(c);
	}
</script>
<link rel=stylesheet type="text/css" href="css/common.css" />
<link rel=stylesheet type="text/css" href="css/solution.css" />
<!--Table of contents  -->
<?php include("header.php");?>
<div id="mid">
	<div id="solution-banner"></div>
	<div id="solution-ct1">
		<div class="left-menu-panel">
			<div class="menu-head">
					<span>行业服务解决方案</span>
			</div>
			<ul>
				<li class="menu-sub" id="accelerate-ebiz">电商加速</li>
				<li class="menu-sub" id="accelerate-portals">门户网站加速</li>
				<li class="menu-sub" id="accelerate-games">游戏加速</li>
				<li class="menu-sub" id="accelerate-video">视频加速</li>
				<li class="menu-sub" id="accelerate-company-site">企业网站加速</li>
			</ul>

			<div class="menu-head">
					<span>安全增值解决方案</span>
			</div>
			<ul>
				<li class="menu-sub">防盗链</li>
				<li class="menu-sub">网络攻击防御</li>
				<li class="menu-sub">突发流量应对</li>
				<li class="menu-sub">访问区域控制</li>
				<li class="menu-sub">智能调度服务</li>
			</ul>

			<div class="menu-head">
					<span>运营商解决方案</span>
			</div>
			<ul>
				<li class="menu-sub">内容加速方案</li>
				<li class="menu-sub">内容引入方案</li>
			</ul>
		</div>
		<div class="right-content">
			<!-- 电商加速 -->
			<div id="accelerate-ebiz-c" class="right-content-c">
				<div id="accelerate-ebiz-banner" class="right-content-banner">
					<img src="images/solution/banner01.jpg">
				</div>
				<div id="ebiz-solution" class="right-content-info">
					<div id="ebiz-sol-title" class="rci-title">解决方案</div>
					<ul>
						<li class="li-blue-dot">增强稳定性和可靠性，满足网站的运行需求</li>
						<li class="li-blue-dot">动态数据为主，保证动态数据的安全传输</li>
						<li class="li-blue-dot">扩展带宽，轻松应对流量突发</li>
					</ul>
				</div>
				<div id="ebiz-acc-result" class="acc-result">
					<div id="ebiz-acc-title" class="rci-title">加速成效</div>
				<ul>
					<li class="li-blue-dot li-blue">安全性增强</li>
					<p>数据源的安全隐藏，减少了黑客核病毒攻击的可能</p>
					<li class="li-blue-dot li-blue">可靠性增强</li>
					<p>可靠性增强，局部故障不影响全局用户访问</p>
					<li class="li-blue-dot li-blue">扩展性增强</li>
					<p>带宽扩展性强，部署方便，源站不需要额外购买任何设备</p>
				</ul>
				</div>
			</div>
			<!-- 门户网站加速 -->
			<div id="accelerate-portals-c" class="right-content-c">
				<div id="accelerate-portals-banner" class="right-content-banner">
					<img src="images/solution/banner02.jpg">
				</div>
				<div id="portals-solution" class="right-content-info">
					<div id="portals-sol-title" class="rci-title">解决方案</div>
					<ul>
						<li class="li-blue-dot">提升性能与速度：网站加速更快，消耗的宽带流量更少</li>
						<li class="li-blue-dot">大存储功能：满足用户对高精度图片和视频的自定义需求</li>
						<li class="li-blue-dot">应对突发流量：对于特殊事件或者时间段的突发大流量进行分流，防止网站崩溃</li>
						<li class="li-blue-dot">网络攻击防御：隐藏源站IP，防止源站真实IP暴露，节点式分布承载DDOS/CC等网络攻击，确保在加速前提下提升网站安全性</li>
					</ul>
				</div>
				<div id="portals-acc-result" class="acc-result">
					<div id="portals-acc-title" class="rci-title">加速成效</div>
				<ul>
					<li class="li-blue-dot li-blue">安全机制</li>
					<p>通过有效的系列安全机制，保证网站安全，加速不受影响，网站服务正常运营</p>
					<li class="li-blue-dot li-blue">降低负载</li>
					<p>运用多种网络技术，增加中间节点服务集群，减少远程访问宽带，降低源站负载压力</p>
					<li class="li-blue-dot li-blue">提升速度</li>
					<p>提升网站访问速度，消除了不同运营商之间互联的瓶颈造成的影响，不同网络的用户都能得到良好的访问体验</p>
					<li class="li-blue-dot li-blue">同步更新</li>
					<p>内容更新同步，确保用户能第一时间看到后台更新内容</p>
				</ul>
				</div>
			</div>
			<!-- 游戏加速 -->
			<div id="accelerate-games-c" class="right-content-c">
				<div id="accelerate-games-banner" class="right-content-banner">
					<img src="images/solution/banner03.jpg">
				</div>
				<div id="games-solution" class="right-content-info">
					<div id="games-sol-title" class="rci-title">解决方案</div>
					<ul>
						<li class="li-blue-dot">精心挑选的网络各处安置节点服务器，将网站内容放置在离用户最近的地方</li>
						<li class="li-blue-dot">绕开影响互联网传输性能的各个环节，全面改善网络质量，促进网络内容和应用的发展</li>
						<li class="li-blue-dot">提升网站安全性能，有效保障网站正常运行</li>
						<li class="li-blue-dot">CND加速网络的雄厚资源储备和合理布局提供极大的带宽扩展性，加强应对突发流量</li>
					</ul>
				</div>
				<div id="games-acc-result" class="acc-result">
					<div id="games-acc-title" class="rci-title">加速成效</div>
				<ul>
					<li class="li-blue-dot li-blue">用户体验好</li>
					<p>用户访问速度加快，访问体验感良好，增加访问量</p>
					<li class="li-blue-dot li-blue">保证用户体验</li>
					<p>解决不同运营商之间的网络影响，保证用户体验</p>
					<li class="li-blue-dot li-blue">节省成本</li>
					<p>节省基础投入和运维成本</p>
					<li class="li-blue-dot li-blue">提供数据</li>
					<p>提供网民访问数据和访问习性，为网站改进和业务发展提供数据</p>
				</ul>
				</div>
			</div>
			<!-- 视频加速 -->
			<div id="accelerate-video-c" class="right-content-c">
				<div id="accelerate-video-banner" class="right-content-banner">
					<img src="images/solution/banner04.jpg">
				</div>
				<div id="video-solution" class="right-content-info">
					<div id="video-sol-title" class="rci-title">解决方案</div>
					<ul>
						<li class="li-blue-dot">按每个视频网站的运营情况提供最经济优化的网站加速方案，对静态，动态，热点内容，冷视频等各种内容和形式采取不同的加速或解决方法，并对加速节点优化布局。</li>
						<li class="li-blue-dot">采用独特的防盗链技术</li>
						<li class="li-blue-dot">实行内容分布式存储</li>
					</ul>
				</div>
				<div id="video-acc-result" class="acc-result">
					<div id="video-acc-title" class="rci-title">加速成效</div>
				<ul>
					<li class="li-blue-dot li-blue">节省成本</li>
					<p>解决网络瓶颈，在大幅加快网站访问速度的同时节省运营成本</p>
					<li class="li-blue-dot li-blue">避免带宽浪费</li>
					<p>保护内容版权和网站的利益，并避免了带宽的浪费</p>
					<li class="li-blue-dot li-blue">资源优化</li>
					<p>达到资源优化的效果，避免内容过多的重复缓存</p>
				</ul>
				</div>
			</div>
			<!-- 企业网站加速 -->
			<div id="accelerate-comp-c" class="right-content-c">
				<div id="accelerate-comp-banner" class="right-content-banner">
					<img src="images/solution/banner05.jpg">
				</div>
				<div id="comp-solution" class="right-content-info">
					<div id="comp-sol-title" class="rci-title">解决方案</div>
					<ul>
						<li class="li-blue-dot">专门为企业网站量身定制了针对其网站内图片和Flash文件等元素进行全网加速</li>
						<li class="li-blue-dot">结合流量监控对其站点流量进行分析，合理分配节点资源</li>
						<li class="li-blue-dot">隐藏源站IP及结合防盗链技术，提高网站安全性</li>
					</ul>
				</div>
				<div id="comp-acc-result" class="acc-result">
					<div id="comp-acc-title" class="rci-title">加速成效</div>
				<ul>
					<li class="li-blue-dot li-blue">访问速度提高</li>
					<p>用户对网站内容的访问速度等到显著的提升，有效增加了用户体验。据统计数据显示，使用了15CDN的网站访问速度较之前有了10倍以上的提高</p>
					<li class="li-blue-dot li-blue">更好的网络营销效果</li>
					<p>更多的访问量，显著增加了网站的宣传和推广效果，从而带来更好的网络营销结果</p>
					<li class="li-blue-dot li-blue">降低运营成本</li>
					<p>更多的访问量，显著增加了网站的宣传和推广效果，从而带来更好的网络营销结果</p>
					<li class="li-blue-dot li-blue">保护网站安全</li>
					<p>保护企业网站服务的安全，有效避免因恶意攻击带来的网站失效的可能</p>
				</ul>
				</div>
			</div>
		</div>
	</div>
</div>


<?php include("footer.php");?>
</body>
</html>