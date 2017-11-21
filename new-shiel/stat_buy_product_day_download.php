<?php
include_once("./head.php");

// ID
$buy_id 		= isset($_GET['buy_id'])?$_GET['buy_id']:'';
$date2          = isset($_GET['date2'])?$_GET['date2']:'30';
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="css/table.css" />
<link rel="stylesheet" href="css/global.css" media="all">

<script type="text/javascript" src="../highcharts-302/jquery/1.8.2/jquery.min.js"></script>
<script src="../highcharts-302/js/highcharts.js"></script>
<script src="../highcharts-302/js/modules/exporting.js"></script>
<script type="text/javascript">	

// 将 GMT 时间转换为本地时间 
// phpLocalTime 时间格式 "2010/12/09 00:00:00"
function  ConvDate(phpLocalTime)
{
	var d=new Date(phpLocalTime); //"2010/12/09 00:00:00");

	day = d.getHours();

	d = d.setHours(8+day);

	d = new Date(d);

	x = d.getTime(); 
	
	return x;
}

function getCrashReportStatData(buy_id,timeval)
{
	var xmlhttp;
	
    if (window.XMLHttpRequest){
	  	// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	}else{
	  	// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
	  	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	
			/*
		    var data = [
					{
						label: "United States",
						data: [[1990, 18.9], [1991, 18.7], [1992, 18.4], [1993, 19.3], [1994, 19.5], [1995, 19.3], [1996, 19.4], [1997, 20.2], [1998, 19.8], [1999, 19.9], [2000, 20.4], [2001, 20.1], [2002, 20.0], [2003, 19.8], [2004, 20.4]]
					},
					{
            			label: "Russia", 
			            data: [[1992, 13.4], [1993, 12.2], [1994, 10.6], [1995, 10.2], [1996, 10.1], [1997, 9.7], [1998, 9.5], [1999, 9.7], [2000, 9.9], [2001, 9.9], [2002, 9.9], [2003, 10.3], [2004, 10.5]]
        			}];
			*/	
			var sResponse= xmlhttp.responseText;
			//document.getElementById("textStatDataTable").innerHTML=sResponse;	
			__StatDataSets = eval('('+sResponse+')');
			var data = [];
			for(var key in __StatDataSets)
			{
				data.push(__StatDataSets[key]);				
			}
							
			//hdrchart.series = data;
			update_enginConn_chart(__StatDataSets);
		}
	}

	var postUrl = "request_stat_data.php?mod=product&action=DayDownloadCount&buy_id="+buy_id+"&timeval="+timeval;
	xmlhttp.open("GET",postUrl,true);
	xmlhttp.send(null);
	return false;
}

function OnSelectFlawDate()
{
	var buy_id= document.getElementById("buySelect").value;	
	var nFlawDateSelect = document.getElementById("FlawDateSelect").value;
	getCrashReportStatData(buy_id,nFlawDateSelect);
}

function selectProduct()
{
	var buy_id= document.getElementById("buySelect").value;
	var nDateSelect2 = document.getElementById("BandwidthDateSelect2").value;
	window.location.href="stat_buy_product_day_download.php?buy_id="+buy_id+"&date2="+nDateSelect2;
}
function OnSelectBandwidthDate2()
{
	selectProduct();
}
</script>

<!----------------------------->
<div style="margin: 15px;">
	
		<div class="layui-tab layui-tab-card">
			<ul class="layui-tab-title">
				<a href="stat_buy_product_bandwidth.php?buy_id=<?php  echo $buy_id; ?>"><li>实时带宽</li></a>
				<a href="stat_buy_product_bandwidth_max.php?buy_id=<?php  echo $buy_id; ?>"><li>峰值带宽</li></a>
				<a href="stat_buy_product_day_download.php?buy_id=<?php  echo $buy_id; ?>"><li class="layui-this">日流量统计</li></a>
				<a href="stat_buy_product_day_request.php?buy_id=<?php  echo $buy_id; ?>"><li>请求量统计</li></a>
				<a href="stat_buy_product_month.php?buy_id=<?php  echo $buy_id; ?>"><li>月度流量</li></a>
			</ul>
			<div class="layui-tab-content" style="height: 100%">
				
				<!-- 日流量统计开始 -->
				<div class="layui-tab-item layui-show">
					<div style="float: right;">
						<!-- 查询方法 -->
						<form action="aa.html">
							<div class="layui-form-item">
							<label class="layui-form-label">查看域名:</label>
							<div class="layui-input-inline">
								 <select id="buySelect" name="buySelect" style="height: 37px; width: 190px; border:1px solid #e6e6e6; text-align:center" onChange="selectProduct()">
							<?php
								$client_username 					=$_SESSION['fikcdn_client_username'];
								$db_link = FikCDNDB_Connect();
								if($db_link)
								{	
									$buy_id = mysql_real_escape_string($buy_id);
									$date2 = mysql_real_escape_string($date2);
									$client_username = mysql_real_escape_string($client_username);
										
									$sql = "SELECT * FROM fikcdn_buy WHERE username='$client_username';"; 
									$result = mysql_query($sql,$db_link);
									if(!$result ||mysql_num_rows($result)<=0){
										$buy_id ='';
									}
											
									if($result)
									{
										$row_count=mysql_num_rows($result);
										for($i=0;$i<$row_count;$i++)
										{
											$this_id  	 		= mysql_result($result,$i,"id");
											$this_username  	 = mysql_result($result,$i,"username");	
											$this_product_id  	 = mysql_result($result,$i,"product_id");	
											
											
											if(strlen($buy_id)<=0) $buy_id  = $this_id;
											
											$sql = "SELECT * FROM fikcdn_product WHERE id='$this_product_id'";
											$result2 = mysql_query($sql,$db_link);
											if($result2 && mysql_num_rows($result2)>0)
											{
												$product_name  		= mysql_result($result2,0,"name");
												$product_name = $product_name.'('.$this_username.')';
											}
																	
											if($buy_id==$this_id)
											{
												echo '<option value="'.$this_id.'" selected="selected">'.$product_name."</option>";
												$show_this_name = $product_name;
											}
											else
											{
												echo '<option value="'.$this_id.'">'.$product_name."</option>";				
											}
										}
									}
								}			
							 ?>
											</select>
							</div>
							<div class="layui-input-inline">
								 <select id="FlawDateSelect" style="height: 37px; width: 190px; border:1px solid #e6e6e6; text-align:center" onChange="OnSelectFlawDate()">
												<option value="30" >最近一个月</option>
												<option value="60" >最近三个月</option>
											</select>	
							</div>
								<button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>&nbsp;&nbsp;
							</div>
						</form>	
					</div>
					
				<div style="height: 300px;width:100%;float:left;" id="placeholder"></div>
				
				<blockquote class="layui-elem-quote">
					日流量详细统计数据 - <?php echo $show_this_name; ?>
					<div style="float: right; margin-top: -7px;">	
							<div class="layui-inline">
								<label class="layui-form-label">选择日期</label>
							<div class="layui-input-block">
								<!--<input type="text" name="date" id="date" lay-verify="date" placeholder="点击选择日期"
								 autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})">-->
								 <select id="BandwidthDateSelect2" style="width:120px" onChange="OnSelectBandwidthDate2()">
									<option value="30" <?php if($date2==30) echo 'selected="selected"'; ?> >最近一个月</option>
									<option value="60" <?php if($date2==60) echo 'selected="selected"'; ?>>最近三个月</option>
								</select>
							</div>
						</div>
					</div>
				</blockquote>

				<table class="site-table table-hover">
						<thead>
							<tr style="text-align: center;">
								<th>时间</th>
								<th>每日用户下载数据</th>
								<th>每日用户上传数据</th>
								<th>每日请求量</th>
							</tr>
						</thead>
						<tbody>
							<?php
			if($db_link){
				$timeval1 = mktime(0,0,0,date("m"),date("d"),date("Y"))-($date2*60*60*24);
				$timeval2 = $timeval1 + 60*60*24;
				//echo "the timeval1 is=". date("Y-m-d H:i:s",$timeval1)."<br/>";
				//echo "the timeval2 is=". date("Y-m-d H:i:s",$timeval2)."<br/>";
				
				$sql = "SELECT * FROM domain_stat_product_day where buy_id='$buy_id' AND time>='$timeval1' "; 
				$result = mysql_query($sql,$db_link);
				if($result){
					$row_count=mysql_num_rows($result);
					for($i=0;$i<$row_count;$i++){
						$id  			= mysql_result($result,$i,"id");	
						$this_buy_id	 	= mysql_result($result,$i,"buy_id");	
						$this_time  		= mysql_result($result,$i,"time");	
						$RequestCount   		= mysql_result($result,$i,"RequestCount");	
						$UploadCount	= mysql_result($result,$i,"UploadCount");
						$DownloadCount	   	= mysql_result($result,$i,"DownloadCount");		
						
						echo '<tr bgcolor="#FFFFFF" align="center" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)" id="tr_domain_'.$id.'">';
						echo '<td>'.date("Y-m-d",$this_time).'</td>';
						echo '<td align="right">'.PubFunc_GBToString($DownloadCount).'</td>';
						echo '<td align="right">'.PubFunc_GBToString($UploadCount).'</td>';	
						echo '<td align="right">'.$RequestCount.' 次</td>';					
					}		
				}
			}	
?>	
						</tbody>
					</table>
					<div id="textStatDataTable"> </div>

<script type="text/javascript">	

var enginConn_chart;

function update_enginConn_chart(data){
	enginConn_chart.redraw();
	var down_data=[];
	var up_data=[];

	down_data = __StatDataSets[0];
	up_data = __StatDataSets[1];
	
	var down_name = down_data['name'];
	var up_name = up_data['name'];
	
	var down_num = [];
	var up_num = [];
	
	var data_grp = [];
	
	var xData = 0;		
	var yData = 0;	
		
	for(var key in down_data['data'])
	{		
		data_grp = down_data['data'][key];
		
		xData = parseInt(data_grp[0])*1000;	
		yData = parseFloat(data_grp[1]);
				
		down_num.push({ y : yData,x : xData});
	}
	
		
	for(var key in up_data['data'])
	{		
		data_grp = up_data['data'][key];
			
		xData = parseInt(data_grp[0])*1000;	
		yData = parseFloat(data_grp[1]);
				
		up_num.push({ y : yData, x : xData});
	}
		
    for(var k = enginConn_chart.series.length - 1; k >= 0; k--){
         enginConn_chart.series[k].remove();
    }
		
	//var jsonText = JSON.stringify(up_num); 
	//alert(jsonText);
	
	//[{x: 12,y: 10}, {x: 24,y: 45},{x: 34,y: 25},{x: 67,y: 265},{x: 123,y: 365},{x: 233,y: 95},{x: 363,y: 87}],
	
	enginConn_chart.addSeries({
		type: 'area',
		color: '#2ebacb',//'#2f7ed8',
		name: down_name,
		data: down_num,
	});
	
	
	//[{x: 12,y: 310}, {x: 24,y: 345},{x: 34,y: 225},{x: 67,y: 465},{x: 123,y: 78},{x: 233,y: 35},{x: 363,y: 234}],
	enginConn_chart.addSeries({
		type: 'area',
		color: '#f0d52e',//color: '#a8d822',
		name:  up_name,
		data: up_num,
	});
}

Highcharts.setOptions( {
	global : {
		useUTC : false
	}
});

jQuery(document).ready(function(){
		sLabelName='';
		aryData=[];                          

		enginConn_chart = new Highcharts.Chart({
		   chart: {
				renderTo: 'placeholder',
				defaultSeriesType: 'column',
                marginRight: 0,
                marginBottom: 40,
				backgroundColor: '#F8F9FA'
		   },                                 

		   title: {
				text: '<span class="input_tips_txt"><strong><?php echo $show_this_name; ?></strong></span>',
				style: {color:'#004499',fontSize:'13px'},
				align: 'center',
				x: -40, //center
				y: 15
		   },
		   /*	
           subtitle: {
               text: '服务器带宽统计',
               x: -20
           },
		   */
		   xAxis: {
				type: 'datetime',
            	lineWidth :2,//自定义x轴宽度  
            	gridLineWidth :0,//默认是0，即在图上没有纵轴间隔线
				dateTimeLabelFormats : {
					second: '%H:%M:%S',
					minute: '%H:%M',
					hour: '%H:%M',
					day: '%m-%d', 
					week: '%m-%d',
					month: '%Y-%m',
					year: '%Y'
				},		
				lineColor : '#3E576F'
		   },

  		   exporting:{
				// 是否允许导出
				enabled:false,
				// 按钮配置
				buttons:{
					// 导出按钮配置
					exportButton:{
						menuItems: null,
						onclick: function() {
							this.exportChart();
						}
					},
					// 打印按钮配置
					printButton:{
						enabled:false
					}
				},
				// 文件名
				filename: '报表',
				// 导出文件默认类型
				type:'application/pdf'
			},
			
    		plotOptions: {			   
			    column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                },
				area: {
					fillOpacity: 0.2,
					lineWidth: 1,
					marker: {
						enabled: false,
						states: {
							hover: {
								enabled: true,
								radius: 5
							}
						}
					},
					shadow: false,
					states: {
						hover: {
							lineWidth: 1
						}
					},
					threshold: null
				}
			},
			/*									   
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]				
                        ]
                    },
                    lineWidth: 1,
                    marker: {
                        enabled: false
                    },
                    shadow: false,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
			*/
		   yAxis: {
		   		min: 0,
				labels:{
					// 标签位置
					align: 'right',
					// 标签格式化
					formatter: function(){
						return this.value + ' GB';
					}
				},
								  
				title: {
					text: '套餐日流量统计',
					style: {color:'#aaaaaa',fontSize:'12px'},
				},
				showFirstLabel: true,  
				plotLines: [{
						 value: 0,
						 width: 1,
						 color: '#87BED3'
				}]
		   },
		   
		   tooltip: {
		   		enabled: true,
				userHTML: true,
				valueSuffix: 'GB',
				formatter: function() { //当鼠标悬置数据点时的格式化提示 
					var myDate = new Date(this.x);
					var strTime = myDate.getFullYear() + '-' + numAddZero((myDate.getMonth()+1),2) + '-' + numAddZero(myDate.getDate(),2); 
					
					//var strTime = myDate.toLocaleString();
	       	        return '<b>' + strTime + '</b><br/><b>' + this.series.name + ': ' + this.y + ' GB</b>'; 
				}
		   },
		   
           legend: {
				enabled: true,       
                layout: 'horizontal',
                align: 'right',
                verticalAlign: 'top',
                x: 0,
                y: 0,
                borderWidth: 0
            },		   
   			
			credits: {  
                enabled: false     //去掉highcharts网站url  
           	},
	});
});

getCrashReportStatData(<?php echo $buy_id; ?>,30);
</script>
				</div>
				<!-- 日流量统计结束 -->
				
				<!-- 请求量统计开始 -->
				<div class="layui-tab-item">
					<div style="float: right;">
						<!-- 查询方法 -->
						<form action="aa.html">
							<div class="layui-form-item">
							<label class="layui-form-label">查看域名:</label>
							<div class="layui-input-inline">
								 <select name="" style="height: 37px; width: 190px; border:1px solid #e6e6e6; text-align:center">
								 	<option value=""> -- 请选择 -- </option>
								 	<option value="0">网站域名</option>
									<option value="1">源站IP一</option>
									<option value="2">源站IP二</option>
								 </select>
							</div>
							<div class="layui-input-inline">
								 <select name="" style="height: 37px; width: 190px; border:1px solid #e6e6e6; text-align:center">
								 	<option value=""> -- 请选择 -- </option>
								 	<option value="0">最近24小时</option>
									<option value="1">最近7天</option>
									<option value="2">本月</option>
									<option value="2">上月</option>
								 </select>
							</div>
								<button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>&nbsp;&nbsp;
							</div>
						</form>	
					</div>
					
				<div style="height: 300px;"></div>
				
				<blockquote class="layui-elem-quote">
					日流量详细统计数据 -
					<div style="float: right; margin-top: -7px;">	
							<div class="layui-inline">
								<label class="layui-form-label">选择日期</label>
							<div class="layui-input-block">
								<input type="text" name="date" id="date" lay-verify="date" placeholder="点击选择日期"
								 autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})">
							</div>
						</div>
					</div>
				</blockquote>
					
				<table class="site-table table-hover">
						<thead>
							<tr style="text-align: center;">
								<th>时间</th>
								<th>每日用户下载数据</th>
								<th>每日用户上传数据</th>
								<th>每日请求量</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Layui</td>
								<td>
									演示站点发布成功啦。
								</td>
								<td>Beginner</td>
								<td>正常</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- 请求量统计结束 -->
				
				<!-- 月度流量开始 -->
				<div class="layui-tab-item">
					<div style="float: right;">
						<!-- 查询方法 -->
						<form action="aa.html">
							<div class="layui-form-item">
							<label class="layui-form-label">查看域名:</label>
							<div class="layui-input-inline">
								 <select name="" style="height: 37px; width: 190px; border:1px solid #e6e6e6; text-align:center">
								 	<option value=""> -- 请选择 -- </option>
								 	<option value="0">网站域名</option>
									<option value="1">源站IP一</option>
									<option value="2">源站IP二</option>
								 </select>
							</div>
								<button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>&nbsp;&nbsp;
							</div>
						</form>	
					</div>
				<table class="site-table table-hover">
						<thead>
							<tr style="text-align: center;">
								<th>序号</th>
								<th>统计月份</th>
								<th>月用户下载流量</th>
								<th>月用户上传流量</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Layui</td>
								<td>
									演示站点发布成功啦。
								</td>
								<td>Beginner</td>
								<td>正常</td>
							</tr>
						</tbody>
					</table>
					
					<div style="height: 230px;"></div>
					
				</div>
				<!-- 月度流量结束 -->
				
			</div>
		</div>

</div>
		<script type="text/javascript" src="plugins/layui/layui.js"></script>
		<script>
			layui.use('element', function() {
				var $ = layui.jquery,
					element = layui.element(); //Tab的切换功能，切换事件监听等，需要依赖element模块

				//触发事件
				var active = {
					tabAdd: function() {
						//新增一个Tab项
						element.tabAdd('demo', {
							title: '新选项' + (Math.random() * 1000 | 0) //用于演示
								,
							content: '内容' + (Math.random() * 1000 | 0)
						})
					},
					tabDelete: function() {
						//删除指定Tab项
						element.tabDelete('demo', 2); //删除第3项（注意序号是从0开始计算）
					},
					tabChange: function() {
						//切换到指定Tab项
						element.tabChange('demo', 1); //切换到第2项（注意序号是从0开始计算）
					}
				};

				$('.site-demo-active').on('click', function() {
					var type = $(this).data('type');
					active[type] ? active[type].call(this) : '';
				});
			});
		</script>
<script>
			layui.use(['form', 'layedit', 'laydate'], function() {
				var form = layui.form(),
					layer = layui.layer,
					layedit = layui.layedit,
					laydate = layui.laydate;

				//创建一个编辑器
				var editIndex = layedit.build('LAY_demo_editor');
				//自定义验证规则
				form.verify({
					title: function(value) {
						if(value.length < 5) {
							return '标题至少得5个字符啊';
						}
					},
					pass: [/(.+){6,12}$/, '密码必须6到12位'],

					content: function(value) {
						layedit.sync(editIndex);
					}
				});

				//监听提交
				form.on('submit(demo1)', function(data) {
					layer.alert(JSON.stringify(data.field), {
						title: '最终的提交信息'
					})
					return false;
				});
			});
		</script>
<!------------------------------->

<?php

include_once("./tail.php");
?>
