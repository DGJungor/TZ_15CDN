<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel=stylesheet type="text/css" href="css/common.css" />
	<link rel=stylesheet type="text/css" href="css/regist.css" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#user-regist-li").click(function(){
			$("#user-regist-li").addClass("guids-onselect");
			$("#user-recharge-li").removeClass("guids-onselect");
			$("#buy-set-li").removeClass("guids-onselect");
			$("#add-domain-li").removeClass("guids-onselect");
			$("#user-regist").show();
			$("#user-recharge").hide();
			$("#buy-sett").hide();
			$("#add-domain").hide();
		});
		$("#user-recharge-li").click(function(){
			$("#user-recharge-li").addClass("guids-onselect");
			$("#user-regist-li").removeClass("guids-onselect");
			$("#buy-set-li").removeClass("guids-onselect");
			$("#add-domain-li").removeClass("guids-onselect");
			$("#user-recharge").show();
			$("#user-regist").hide();
			$("#buy-sett").hide();
			$("#add-domain").hide();
		});
		$("#buy-set-li").click(function(){
			$("#buy-set-li").addClass("guids-onselect");
			$("#user-regist-li").removeClass("guids-onselect");
			$("#user-recharge-li").removeClass("guids-onselect");
			$("#add-domain-li").removeClass("guids-onselect");
			$("#buy-set").show();
			$("#user-recharge").hide();
			$("#user-regist").hide();
			$("#add-domain").hide();
		});
		$("#add-domain-li").click(function(){
			$("#add-domain-li").addClass("guids-onselect");
			$("#user-regist-li").removeClass("guids-onselect");
			$("#user-recharge-li").removeClass("guids-onselect");
			$("#buy-set-li").removeClass("guids-onselect");
			$("#add-domain").show();
			$("#user-regist").hide();
			$("#user-recharge").hide();
			$("#buy-set").hide();
		});
	});
	</script>
	
	<title>用户手册</title>
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
<body style="overflow-x: hidden">
<?php include("header.php");?>
		<!-- 中部 -->
		<div id="cdn15bdy">
			<!-- banner -->
			<!-- <div class="regist-nbanner">
					
			</div> -->
			
			<div class="user-guid">
					<!--Table of contents  -->
					<div class="user-guid-step">
							<div class="user-guid-step-head">
									<span>用户使用教程</span>
							</div>
							<ul>
								<li class="guids guids-onselect" id="user-regist-li">用户注册</li>
								<li class="guids" id="user-recharge-li">用户充值</li>
								<li class="guids" id="buy-set-li">用户购买套餐</li>
								<li class="guids" id="add-domain-li">添加域名</li>
							</ul>
					</div>
					<div class="user-guid-contents">
							<div class="user-guid-content" id="user-regist">
									<span class="user-guid-content-step">第一步：用户注册 </span>
									<br/><br/>
									<span class="user-guid-content-con">1、访问官网www.15cdn.com 点击有控制台登录，如没账户点击（注册账号）</span>
									<br/>
									<img src="images/regist_img-1.png">
									<span>2、填入准确信息，资料务必真实准确。</span>
									<br/>
									<img src="images/regist_img-2.png">
									<span>3、注册成功：</span>
									<br/>
									<img src="images/regist_img-3.png">
							</div>
							
							<div class="user-guid-content" id="user-recharge" style="display: none;">
									<span class="user-guid-content-step">第二步：用户充值 </span>
									<br/><br/>
									<span class="user-guid-content-con">1、以支付宝的方式充值。比如（充值1000元）：</span>
									<br/>
									<img src="images/regist_img-4.png" width="580px" height="255px" >
									<span>2、核对充值账单，并点击（立即在线支付）：</span>
									<br/>
									<img src="images/regist_img-5.png" width="580px" height="255px" >
									<span>3、手机登录支付宝扫一扫即可充值成功：（支付完成之后，就可以购买套餐了）</span>
									<br/>
									<img src="images/regist_img-6.png"width="580px" >
							</div>
							
							<div class="user-guid-content" id="buy-set" style="display: none;">
									<span class="user-guid-content-step">第三步：用户购买套餐 </span>
									<br/><br/>
									<span class="user-guid-content-con">1、在左侧选择产品套餐，根据用户需求点击购买合适的产品：</span>
									<br/>
									<img src="images/regist_img-7.png" width="580px" height="255px" >
									<span>2、输入购买月份数，并点击购买：</span>
									<br/>
									<img src="images/regist_img-8.png" width="580px"  >
									<span>3、核对订单信息，并完成支付</span>
									<br/>
									<img src="images/regist_img-9.png"width="580px" >
							</div>
							
							
							<div class="user-guid-content" id="add-domain" style="display: none;">
									<span class="user-guid-content-step">第四步：添加域名 </span>
									<br/><br/>
									<span class="user-guid-content-con">1、选择域名列表项，并点击添加域名</span>
									<br/>
									<img src="images/regist_img-10.png" width="580px" height="255px" >
									<span>2、注：准确填写，切勿出错</span>
									<br/>
									<img src="images/regist_img-11.png" width="580px"  >
									<span>3、添加完成后，刷新一下列表，然后把CANME项的别名复制：（用于修改域名解析）</span>
									<img src="images/regist_img-12.png"width="580px" >
									<span>4、联系技术支持进行审核，审核通过修改域名解析</span>
									<br/>
									<br/>
									<span>5、修改域名供应商的域名解析（如：万网）：</span>
									<br/>
									<img src="images/regist_img-13.png"width="580px" >
									<span>6、如果有A记录就删除，再添加CNAME类型；没有就直接添加或修改成CANME 类型和记录值：</span>
									<br/>
									<img src="images/regist_img-14.png"width="580px" >
									
									<br/>
									<br/>
									<span>7、有任何疑问请联系右上角的技术人员</span>
									<img src="images/regist_img-15.png"width="580px" >
									<br/>
							</div>
					</div>
			</div>
			
			
	</div>
	<?php include("footer.php");?>
</body>
</html>