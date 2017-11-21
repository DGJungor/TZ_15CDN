<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/regist.css" />
	<link rel="stylesheet" href="css/index.css">
	 <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
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
</head>
<body style="overflow-x: hidden">
<style>
.header{
	background-color:#2BA3D4;
}
</style>
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
							<ul style="list-style: outside none none;margin: 0;padding: 0;">
								<li class="guids guids-onselect" id="user-regist-li">用户登录</li>
								<li class="guids" id="user-recharge-li">用户充值</li>
								<li class="guids" id="buy-set-li">选择套餐并购买</li>
								<li class="guids" id="add-domain-li">添加域名并修改解析</li>
							</ul>
					</div>
					<div class="user-guid-contents">
							<div class="user-guid-content" id="user-regist">
									<span class="user-guid-content-step">第一步：用户登录 </span>
									<br/><br/>
									<span class="user-guid-content-con">
										若没有用户名，请先完成注册。<br/>
										若有用户名，请登录控制台。（可跳过此步骤）<br/>
										在C盾官网上点击“注册”
									</span>
									<br/>
									<img src="images/course/image1.png" width="836px;">
									<span>请填入准确信息，资料务必真实准确。</span>
									<br/>
									<img src="images/course/image2.png" width="836px;">
									<span>注册完成，点击登录。</span>
							</div>
							
							<div class="user-guid-content" id="user-recharge" style="display: none;">
									<span class="user-guid-content-step">第二步：用户充值 </span>
									<br/><br/>
									<span class="user-guid-content-con">在控制台—账务管理—在线充值。</span>
									<br/>
									<span class="user-guid-content-con">以支付宝方式进行充值，充值1000元为例。</span>
									<br/>
									<img src="images/course/image3.png" width="836px;">
									<span>核对充值账单无误后点击“立刻在线支付”</span>
									<br/>
									<img src="images/course/image4.png" width="836px;">
									<span>手机登录支付宝扫一扫付款或者登录支付宝账号付款。</span>
									<br/>
									<img src="images/course/image5.png" width="836px;">
							</div>
							
							<div class="user-guid-content" id="buy-set" style="display: none;">
									<span class="user-guid-content-step">第三步：选择套餐并购买</span>
									<br/><br/>
									<span class="user-guid-content-con">在控制台—套餐管理—产品套餐中根据需求购买相应的套餐。</span>
									<br/>
									<img src="images/course/image6.png" width="836px;">
									<span> 输入购买月份，点击“购买”。</span>
									<br/>
									<img src="images/course/image7.png" width="836px;">
									<span>核对订单无误后点击“支付”。</span>
									<br/>
									<img src="images/course/image8.png" width="836px;">
							</div>
							
							
							<div class="user-guid-content" id="add-domain" style="display: none;">
									<span class="user-guid-content-step">第四步：添加域名并修改解析 </span>
									<br/><br/>
									<span class="user-guid-content-con">在控制台—域名管理—域名列表中点击“添加域名”。</span>
									<br/>
									<img src="images/course/image9.png" width="836px;">
									<span>添加完成后返回域名列表，即可看到 CNAME 项的别名记录。</span>
									<br/>
									<img src="images/course/image10.png" width="836px;">
									<span>等待后台审核，审核通过后修改域名解析。</span>
									<br/>
									<span>修改域名供应商的的域名解析,以万网为例。</span>
									<img src="images/course/image11.png" width="836px;">
									<span>如有A记录修改成CNAME记录，没有的添加CNAME记录。</span>
							</div>
					</div>
			</div>
			
			
	</div>
	<?php include("footer.php");?>
</body>
</html>