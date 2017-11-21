<?php
include_once("./head.php");

$domain_id 		= isset($_GET['domain_id'])?$_GET['domain_id']:'';
$date2          = isset($_GET['date2'])?$_GET['date2']:'';
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="css/table.css" />
<link rel="stylesheet" href="css/global.css" media="all">
<script src="../js/calendar.js"></script>
<script type="text/javascript" src="../highcharts-302/jquery/1.8.2/jquery.min.js"></script>
<script src="../highcharts-302/js/highcharts.js"></script>
<script src="../highcharts-302/js/modules/exporting.js"></script>
<script type="text/javascript">	
function selectDomain(){
	var txtDoaminID		 =document.getElementById("domainSelect").value;
	var nDateSelect2 = document.getElementById("BandwidthDateSelect2").value;
	window.location.href="stat_domain_bandwidth.php?domain_id="+txtDoaminID+"&date2="+nDateSelect2;
}

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

function getDomainBandwidthStatData(domain_id,timeval)
{
	var xmlhttp;
	
    if (window.XMLHttpRequest)
	{
	  	// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	}
	else
	{
	  	// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	if(timeval==1)
	{
		sTimeformat = "%H:%M";
	}
	else
	{
		sTimeformat = "%0m-%0d";
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

	var postUrl = "request_stat_data.php?mod=proxy&action=bandwidth"+"&domain_id=" + domain_id +"&timeval="+timeval;
	xmlhttp.open("GET",postUrl,true);
	xmlhttp.send(null);
	return false;
}

function OnSelectBandwidthDate()
{
	var txtDomainID = document.getElementById("txtDomainID").value;
	var nMaxBandwidthDateSelect = document.getElementById("BandwidthDateSelect").value;
	var nDateSelect2 = document.getElementById("BandwidthDateSelect2").value;
	
	getDomainBandwidthStatData(txtDomainID,nMaxBandwidthDateSelect);
}

function OnSelectBandwidthDate2()
{
	selectDomain();
}

</script>





<!-------------------------------------------------------->
<div style="margin: 15px;">
	
		<div class="layui-tab layui-tab-card">
			<ul class="layui-tab-title">
            	<a href="stat_domain_qqs.php?domain_id=<?php echo $domain_id; ?>"><li>实时请求</li></a>
				<a href="stat_domain_bandwidth.php?domain_id=<?php echo $domain_id; ?>"><li class="layui-this">实时带宽</li></a>
				<a href="stat_domain_bandwidth_max.php?domain_id=<?php echo $domain_id; ?>"><li>峰值带宽</li></a>
				<a href="stat_domain_download.php?domain_id=<?php echo $domain_id; ?>"><li>日流量统计</li></a>
				<a href="stat_domain_request.php?domain_id=<?php echo $domain_id; ?>"><li>请求量统计</li></a>
				<a href="stat_domain_month.php?domain_id=<?php echo $domain_id; ?>"><li>月度流量</li></a>
			</ul>
			<div class="layui-tab-content" style="height: 100%">
				
				<!-- 实时带宽开始 -->
				<div class="layui-tab-item layui-show">
					<div style="float: right;">
						<!-- 查询方法 -->
						<form action="">
							<div class="layui-form-item">
							<label class="layui-form-label">查看域名</label>
							<div class="layui-input-inline">
								 
								 <select id="domainSelect" name="domainSelect" style="height: 37px; width: 190px; border:1px solid #e6e6e6; text-align:center" onChange="selectDomain()">
									<?php
										$this_hostname = "";
										$client_username 	=$_SESSION['fikcdn_client_username'];
										$db_link = FikCDNDB_Connect();
										if($db_link)
										{	
											$domain_id = mysql_real_escape_string($domain_id);
											$date2 = mysql_real_escape_string($date2);
											$client_username = mysql_real_escape_string($client_username);
												
											$sql = "SELECT * FROM fikcdn_domain WHERE username='$client_username';"; 
											$result = mysql_query($sql,$db_link);
											if(!$result ||mysql_num_rows($result)<=0){
												$domain_id ='';
											}
													
											if($result)
											{
												$row_count=mysql_num_rows($result);
												for($i=0;$i<$row_count;$i++)
												{
													$this_id  	 = mysql_result($result,$i,"id");	
													$this_buy_id = mysql_result($result,$i,"buy_id");
													$hostname  	 = mysql_result($result,$i,"hostname");	
													
													if(strlen($domain_id)<=0){
														$domain_id = $this_id;
														$buy_id = $this_buy_id;
													}
															
													if($domain_id==$this_id)
													{
														echo '<option value="'.$this_id.'" selected="selected">'.$hostname."</option>";
														$this_hostname = $hostname;
														$show_this_name = $hostname;
													}
													else
													{
														echo '<option value="'.$this_id.'">'.$hostname."</option>";				
													}
												}
											}
												
											// 计算最大带宽
											$timenow=time();
											$timeval = $timenow-24*60*60;
											$sql = "SELECT max(bandwidth_down),max(bandwidth_up),avg(bandwidth_down),avg(bandwidth_up) FROM domain_stat_host_bandwidth WHERE domain_id='$domain_id' AND time>=$timeval";
											$result2 = mysql_query($sql,$db_link);
											if($result2 && mysql_num_rows($result2)>0)
											{
												$max1_bandwidth_down = mysql_result($result2,0,"max(bandwidth_down)");
												$max1_bandwidth_up = mysql_result($result2,0,"max(bandwidth_up)");		
												$avg1_bandwidth_down = mysql_result($result2,0,"avg(bandwidth_down)");
												$avg1_bandwidth_up = mysql_result($result2,0,"avg(bandwidth_up)");		
												
												$max1_bandwidth_down = round($max1_bandwidth_down,2);
												$max1_bandwidth_up = round($max1_bandwidth_up,2);
												$avg1_bandwidth_down = round($avg1_bandwidth_down,2);
												$avg1_bandwidth_up = round($avg1_bandwidth_up,2);									
											}
											
											if(strlen($max1_bandwidth_down)<=0) $max1_bandwidth_down=0;
											if(strlen($max1_bandwidth_up)<=0) $max1_bandwidth_up=0;
											if(strlen($avg1_bandwidth_down)<=0) $avg1_bandwidth_down=0;
											if(strlen($avg1_bandwidth_up)<=0) $avg1_bandwidth_up=0;			
											
											// 计算最大带宽
											$timeval = $timenow-24*60*60*3;
											$sql = "SELECT max(bandwidth_down),max(bandwidth_up) FROM domain_stat_host_bandwidth WHERE domain_id='$domain_id' AND time>=$timeval";
											$result2 = mysql_query($sql,$db_link);
											if($result2 && mysql_num_rows($result2)>0)
											{
												$max7_bandwidth_down = mysql_result($result2,0,"max(bandwidth_down)");
												$max7_bandwidth_up = mysql_result($result2,0,"max(bandwidth_up)");		
										
												$max7_bandwidth_down = round($max7_bandwidth_down,2);
												$max7_bandwidth_up = round($max7_bandwidth_up,2);								
											}	
											
											if(strlen($max7_bandwidth_down)<=0) $max7_bandwidth_down=0;
											if(strlen($max7_bandwidth_up)<=0) $max7_bandwidth_up=0;						
										}			
									 ?>
									</select>

							</div>
							<div class="layui-input-inline">
								 <select id="BandwidthDateSelect" style="height: 37px; width: 190px; border:1px solid #e6e6e6; text-align:center"onChange="OnSelectBandwidthDate()">
									<?php
										$timenow =time();
										for($i=0;$i<3;$i++)
										{
											if($date2==$i){
												echo '<option value="'.$i.'" selected="selected">'.date("Y-m-d",$timenow-($i*60*60*24)).'</option>';
											}else{
												echo '<option value="'.$i.'" >'.date("Y-m-d",$timenow-($i*60*60*24)).'</option>';
											}
										}
									?>
									</select>
							</div>
								<input id="txtDomainID" type="hidden" size="20" maxlength="256" value="<?php echo $domain_id; ?>" />
								<!--<button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>&nbsp;&nbsp;-->
							</div>
						</form>	
					</div>
					
				<div style="height: 300px;width:100%;float:left;" id="placeholder"></div>
				<!-- 监控流量表格 -->
				<table align="center">
					<tr style="height: 30px; border-bottom:1px dotted #000;text-align: right;">
						<td style="width: 220px; background-color: #eee;">24小时最大下载峰值带宽：</td>	
						<td style="width: 100px;"><span id="tb_max_mirror_flow_of_1day"><?php echo $max1_bandwidth_down; ?> Mbps</span></td>
						<td style="width: 10px;"></td>
						<td style="width: 220px; background-color: #eee; ">24小时平均下载带宽：</td>
						<td style="width: 100px;"><span id="tb_max_mirror_flow_of_1day"><?php echo $avg1_bandwidth_down; ?> Mbps</span></td>
						<td style="width: 10px;"></td>
						<td style="width: 220px; background-color: #eee; ">3天内最大下载带宽：</td>
						<td style="width: 100px;"><span id="tb_max_mirror_flow_of_7day"><?php echo $max7_bandwidth_down; ?> Mbps</span></td>
						<td style="width: 10px;"></td>
					</tr>	
					<tr style="height: 30px; border-bottom:1px dotted #000;text-align: right;">
						<td style="width: 220px; background-color: #eee;">24小时最大上传峰值带宽：</td>	
						<td style="width: 100px;"><span id="tb_avg_mirror_flow_of_1day"><?php echo $max1_bandwidth_up; ?> Mbps</span></td>
						<td style="width: 10px;"></td>
						<td style="width: 220px; background-color: #eee; ">24小时平均上传带宽：	</td>
						<td style="width: 100px;"><span id="tb_avg_mirror_flow_of_1day"><?php echo $avg1_bandwidth_up; ?> Mbps</span></td>
						<td style="width: 10px;"></td>
						<td style="width: 220px; background-color: #eee; ">3天内最大上传峰值带宽：</td>
						<td style="width: 100px;"><span id="tb_avg_mirror_flow_of_7day"><?php echo $max7_bandwidth_up; ?> Mbps</span></td>
						<td style="width: 10px;"></td>
					</tr>	
				</table>
				
				<div style="height: 20px;"></div>
				
				<blockquote class="layui-elem-quote">
					实时带宽详细统计数据 - <?php echo $this_hostname; ?>
					<div style="float: right; margin-top: -7px;">	
							<div class="layui-inline">
								<label class="layui-form-label">选择日期</label>
							<div class="layui-input-block">
								<!--<input type="text" name="date" id="date" lay-verify="date" placeholder="点击选择日期"
								 autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})">-->
								 <select id="BandwidthDateSelect2" style="width:120px" onChange="OnSelectBandwidthDate2()">
									<?php
										$timenow =time();
										for($i=0;$i<3;$i++)
										{
											if($date2==$i){
												echo '<option value="'.$i.'" selected="selected">'.date("Y-m-d",$timenow-($i*60*60*24)).'</option>';
											}else{
												echo '<option value="'.$i.'" >'.date("Y-m-d",$timenow-($i*60*60*24)).'</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
					</div>
				</blockquote>


					
<div id="div_search_result2" style="padding-left:0px">
			<table width="800" border="0" class="site-table table-hover" id="domain_table">
				<tr id="tr_domain_title" style="text-align: center;">
					<th align="center" width="150">时间</th> 
					<th align="center" width="120">每间隔用户下载数据</th>
					<th align="center" width="120">每间隔用户上传数据</th>
					<th align="center" width="120">用户下载带宽</th>
					<th align="center" width="100" align="center">用户上传带宽</th>
					<th align="center" width="100" align="center">每间隔请求量</th>
				</tr>	
<?php				
			if($db_link){
				$timeval1 = mktime(0,0,0,date("m"),date("d"),date("Y"))-($date2*60*60*24);
				$timeval2 = $timeval1 + 60*60*24;
				//echo "the timeval1 is=". date("Y-m-d H:i:s",$timeval1)."<br/>";
				//echo "the timeval2 is=". date("Y-m-d H:i:s",$timeval2)."<br/>";
				
				$sql = "SELECT * FROM domain_stat_host_bandwidth where domain_id='$domain_id' AND time>='$timeval1' AND time<'$timeval2' ORDER BY time DESC"; 
				$result = mysql_query($sql,$db_link);
				if($result){
					$row_count=mysql_num_rows($result);
					for($i=0;$i<$row_count;$i++){
						$id  			= mysql_result($result,$i,"id");	
						$group_id  		= mysql_result($result,$i,"group_id");	
						$this_buy_id	 	= mysql_result($result,$i,"buy_id");	
						$this_time  		= mysql_result($result,$i,"time");	
						$down_increase   		= mysql_result($result,$i,"down_increase");	
						$up_increase	= mysql_result($result,$i,"up_increase");
						$bandwidth_down	   	= mysql_result($result,$i,"bandwidth_down");		
						$bandwidth_up	   	= mysql_result($result,$i,"bandwidth_up");		
						$RequestCount_increase	   	= mysql_result($result,$i,"RequestCount_increase");		
						$IpCount_increase	   	= mysql_result($result,$i,"IpCount_increase");		
						
						echo '<tr bgcolor="#FFFFFF" align="center" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)" id="tr_domain_'.$id.'">';
						echo '<td>'.date("Y-m-d H:i:s",$this_time).'</td>';
						echo '<td align="right">'.PubFunc_MBToString($down_increase).'</td>';
						echo '<td align="right">'.PubFunc_MBToString($up_increase).'</td>';
						echo '<td align="right">'.$bandwidth_down.' Mbps</td>';		
						echo '<td align="right">'.$bandwidth_up.' Mbps</td>';		
						echo '<td align="right">'.$RequestCount_increase.' 次</td>';					
					}		
				}
			}	
?>								
		 	</table>
		 </div>	
		 
<?php		 
/*
		 <div style="width:930px; padding-left:0px">
		 <table width="800" border="0" class="disc">
			<tr>
			<td bgcolor="#FFFFE6" height="25"></td>
			</tr>
		</table>	
		</div>
		*/
?>			 
		 	
	  </td> 
  </tr>
</table>
</div>

<div id="textStatDataTable"></div>

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
				defaultSeriesType: 'spline',
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
						return this.value + ' Mbps';
					}
				},
								  
				title: {
					text: '域名实时带宽统计',
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
				valueSuffix: 'Mbps',
				formatter: function() { //当鼠标悬置数据点时的格式化提示 
					var myDate = new Date(this.x);
					var strTime = numAddZero((myDate.getMonth()+1),2) + '-' + numAddZero(myDate.getDate(),2) + " " + numAddZero(myDate.getHours(),2) + ':' + numAddZero(myDate.getMinutes(),2) + ':' + numAddZero(myDate.getSeconds(),2); 
					
					//var strTime = myDate.toLocaleString();
	       	        return '<b>' + strTime + '</b><br/><b>' + this.series.name + ': ' + this.y + ' Mbps</b>'; 
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
var nCurBandwidthDateSelect = document.getElementById("BandwidthDateSelect").value;
getDomainBandwidthStatData(<?php echo $domain_id; ?>,nCurBandwidthDateSelect);	
</script>



					
				</div>
				<!-- 实时带宽结束 -->
				
				
				
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

<!----------------------------------------------------------------------->

<?php

include_once("./tail.php");
?>
