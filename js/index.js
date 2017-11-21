$(document).ready(function() {
	$("#service_h1_1").css("color","#EEC900");
	$("#service_p_1").css("color","#EEC900");
	$("#service_1").mouseover(function() {
		$("#service_h1_1").css("color","#EEC900");
		$("#service_p_1").css("color","#EEC900");
		$("#service_h1_2").css("color","#a8a8a8");
		$("#service_p_2").css("color","#a8a8a8");
		$("#service_h1_3").css("color","#a8a8a8");
		$("#service_p_3").css("color","#a8a8a8");
		$("#service_h1_4").css("color","#a8a8a8");
		$("#service_p_4").css("color","#a8a8a8");
		$("#service_1").attr("src","images/huangtu1.jpg");
		$("#service_2").attr("src","images/huitu2.jpg");
		$("#service_3").attr("src","images/huitu3.jpg");
		$("#service_4").attr("src","images/huitu4.jpg");
	})
	$("#service_2").mouseover(function() {
		$("#service_h1_1").css("color","#a8a8a8");
		$("#service_p_1").css("color","#a8a8a8");
		$("#service_h1_2").css("color","#EEC900");
		$("#service_p_2").css("color","#EEC900");
		$("#service_h1_3").css("color","#a8a8a8");
		$("#service_p_3").css("color","#a8a8a8");
		$("#service_h1_4").css("color","#a8a8a8");
		$("#service_p_4").css("color","#a8a8a8");
		$("#service_1").attr("src","images/huitu1.jpg");
		$("#service_2").attr("src","images/huangtu2.jpg");
		$("#service_3").attr("src","images/huitu3.jpg");
		$("#service_4").attr("src","images/huitu4.jpg");
	})
	$("#service_3").mouseover(function() {
		$("#service_h1_1").css("color","#a8a8a8");
		$("#service_p_1").css("color","#a8a8a8");
		$("#service_h1_2").css("color","#a8a8a8");
		$("#service_p_2").css("color","#a8a8a8");
		$("#service_h1_3").css("color","#EEC900");
		$("#service_p_3").css("color","#EEC900");
		$("#service_h1_4").css("color","#a8a8a8");
		$("#service_p_4").css("color","#a8a8a8");
		$("#service_1").attr("src","images/huitu1.jpg");
		$("#service_2").attr("src","images/huitu2.jpg");
		$("#service_3").attr("src","images/huangtu3.jpg");
		$("#service_4").attr("src","images/huitu4.jpg");
	})
	$("#service_4").mouseover(function() {
		$("#service_h1_1").css("color","#a8a8a8");
		$("#service_p_1").css("color","#a8a8a8");
		$("#service_h1_2").css("color","#a8a8a8");
		$("#service_p_2").css("color","#a8a8a8");
		$("#service_h1_3").css("color","#a8a8a8");
		$("#service_p_3").css("color","#a8a8a8");
		$("#service_h1_4").css("color","#EEC900");
		$("#service_p_4").css("color","#EEC900");
		$("#service_1").attr("src","images/huitu1.jpg");
		$("#service_2").attr("src","images/huitu2.jpg");
		$("#service_3").attr("src","images/huitu3.jpg");
		$("#service_4").attr("src","images/huangtu4.jpg");
	})
})


//解决方案
function clickmethod(temp){
	$("#ds").removeClass();
	$("#jr").removeClass();
	$("#yl").removeClass();
	$("#xr").removeClass();
	$("#o2o").removeClass();
	$("#dmt").removeClass();
	$("#yx").removeClass();
	$("#zw").removeClass();
	$("#wlw").removeClass();
	$("#dsinfo").hide();
	$("#jrinfo").hide();
	$("#ylinfo").hide();
	$("#xrinfo").hide();
	$("#o2oinfo").hide();
	$("#dmtinfo").hide();
	$("#yxinfo").hide();
	$("#zwinfo").hide();
	$("#wlwinfo").hide();
	if(temp=="ds"){
		$("#ds").removeClass().addClass("sleft_on");
		$("#dsbg").show();
		$("#dsinfo").show();
	}else if(temp=="jr"){
		$("#jr").removeClass().addClass("sleft_on");
		$("#jrbg").show();
		$("#jrinfo").show();
	}else if(temp=="yl"){
		$("#yl").removeClass().addClass("sleft_on");
		$("#ylbg").show();
		$("#ylinfo").show();
	}else if(temp=="xr"){
		$("#xr").removeClass().addClass("sleft_on");
		$("#xrbg").show();
		$("#xrinfo").show();
	}else if(temp=="o2o"){
		$("#o2o").removeClass().addClass("sleft_on");
		$("#o2obg").show();
		$("#o2oinfo").show();
	}else if(temp=="dmt"){
		$("#dmt").removeClass().addClass("sleft_on");
		$("#dmtbg").show();
		$("#dmtinfo").show();
	}else if(temp=="yx"){
		$("#yx").removeClass().addClass("sleft_on");
		$("#yxbg").show();
		$("#yxinfo").show();
	}else if(temp=="zw"){
		$("#zw").removeClass().addClass("sleft_on");
		$("#zwbg").show();
		$("#zwinfo").show();
	}else if(temp=="wlw"){
		$("#wlw").removeClass().addClass("sleft_on");
		$("#wlwbg").show();
		$("#wlwinfo").show();
	}
}