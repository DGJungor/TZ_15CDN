// JavaScript Document
	var xmlDoc;
	var xmldocp;

	/*调试CODE*/

	var nu1=1;
	//var nu1=1;

	//var nu2=0;
	var nu2=1;

	var nu3=1;
	//var nu3=1;

	//var nu4=0;
	var nu4=1;

	//var nu5=0;
	var nu5=1;

	//var nu6=0;
	var nu6=1;

	//var nu7=0;
	var nu7=1;

	//var nu8=0;
	var nu8=1;

	/*调试CODE*/


	function loadXML() //载入XML文件
		{   
			// 用于 IE 的代码：
			if (window.ActiveXObject)
			{
				xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
				xmlDoc.async=false;
				//xmlDoc.load("temp.xml");
				getmessage();
				xmldocp=new ActiveXObject("Microsoft.XMLDOM");
				xmldocp.async=false;
			}
			// 用于 Mozilla, Firefox, Opera, 等浏览器的代码：
			else if (document.implementation && document.implementation.createDocument)
			{
				xmlDoc=document.implementation.createDocument("","",null);
				//xmlDoc.load("public/test/temp.xml");//这里需要修改，路径为测试路径
				xmlDoc.onload=getmessage;
				getmessage();//测试用
				xmldocp=document.implementation.createDocument("","",null);
			}
			else
			{
				alert('你的浏览器不支持Javascript！请更换最新版本的浏览器后重试。');
			}
			//setTimeout("loadXML()",1000);
		}
		
		function getmessage() //判断XML状态
		{
//			alert("getmessage函数执行了");
//			alert(nu8);
			//msg_refresh();
			/*document.getElementById("ch_one").innerHTML=
			xmlDoc.getElementsByTagName("ch_one")[0].childNodes[0].nodeValue;
			document.getElementById("ch_two").innerHTML=
			xmlDoc.getElementsByTagName("ch_two")[0].childNodes[0].nodeValue;
			document.getElementById("ch_three").innerHTML=
			xmlDoc.getElementsByTagName("ch_three")[0].childNodes[0].nodeValue;
			document.getElementById("ch_four").innerHTML=
			xmlDoc.getElementsByTagName("ch_four")[0].childNodes[0].nodeValue;
			document.getElementById("ch_five").innerHTML=
			xmlDoc.getElementsByTagName("ch_five")[0].childNodes[0].nodeValue;
			document.getElementById("ch_eight").innerHTML=
			xmlDoc.getElementsByTagName("ch_eight")[0].childNodes[0].nodeValue;*/
			
			//8号停车位
//			nu8 =xmlDoc.getElementsByTagName("ch_ten")[0].childNodes[0].nodeValue; 
			if(nu8 == 1) {
				document.getElementById("num6").src ="public/image/youche.png";//id = num6表示第六个格，其他类似。
			}
			else {

				document.getElementById("num6").src ="public/image/kong.jpg";
			}	
			
			//7号停车位
			nu7 =xmlDoc.getElementsByTagName("ch_five")[0].childNodes[0].nodeValue; 
			if(nu7 == 1) {
				document.getElementById("num11").src ="public/image/youche.png";
			}
			else {
				document.getElementById("num11").src ="public/image/kong.jpg";
			}	

			//6号停车位
			//nu6 =xmlDoc.getElementsByTagName("")[0].childNodes[0].nodeValue; 
			if(nu6 == 1) {
				document.getElementById("num16").src ="public/image/youche.png";
			}
			else {
				document.getElementById("num16").src ="";
			}	
			//5号停车位
			nu5 =xmlDoc.getElementsByTagName("ch_eight")[0].childNodes[0].nodeValue; 
			if(nu5 == 1) {
				document.getElementById("num13").src ="public/image/youche.png";
			}
			else {
				document.getElementById("num13").src ="public/image/kong.jpg";
			}	
			//4号停车位
			//nu4 =xmlDoc.getElementsByTagName("")[0].childNodes[0].nodeValue; 
			if(nu4 == 1) {
				document.getElementById("num18").src ="public/image/youche.png";
			}
			else {
				document.getElementById("num18").src ="";
			}	
			//3号停车位
			//nu3 =xmlDoc.getElementsByTagName("")[0].childNodes[0].nodeValue; 
			if(nu3 == 1) {
				document.getElementById("num20").src ="public/image/youche.png";
			}
			else {
				document.getElementById("num20").src ="";
			}	
			//2号停车位
			//nu2 =xmlDoc.getElementsByTagName("")[0].childNodes[0].nodeValue; 
			if(nu2 == 1) {
				document.getElementById("num15").src ="public/image/youche.png";
			}
			else {
				document.getElementById("num15").src ="";
			}	
			//1号停车位
			//nu1 =xmlDoc.getElementsByTagName("")[0].childNodes[0].nodeValue; 
			if(nu1 == 1) {
				document.getElementById("num10").src ="public/image/youche.png";
			}
			else {
				document.getElementById("num10").src ="";
			}	
		}
