<?php
include_once("function.php");
include_once("../config/PDO_config.php");
if (!FuncClient_IsLogin()) {
    FuncClient_LocationLogin();
}


$userItems = $_SESSION['userInfo']['userItems'];


////获取本月总流量
//$sqlMonthCount = "
//";
//
////获取本月时间戳
//$beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));

//--------------------------------打印数据

//echo '<pre>';
//var_dump($_SESSION);
//echo '</pre>';
//
//echo '<pre>';
//var_dump($sth);
////echo $beginThismonth;
//echo '</pre>';
//?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    <script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
    <!--    <link rel="stylesheet" href="./plugins/layui2/css/layui.css?t=1504112998306" media="all">-->
    <link rel="stylesheet" href="./plugins/layui2/css/layui.css">


    <!--        <script src="./Public/jquery/1.11.3/jquery.js"></script>-->
    <script src="./plugins/layui2/layui.all.js"></script>
    <!-- <script src="./js/echarts.min.js"></script> -->
    <script src="../highcharts-302/js/highcharts.js"></script>
	<script src="../highcharts-302/js/modules/exporting.js"></script>


</head>
<body>

<ul class="layui-nav" lay-filter="filter">
<!--    <li class="layui-nav-item">概览</li>-->
    <!--    <li class="layui-nav-item layui-this"><a href="">产品</a></li>-->
    <!--    <li class="layui-nav-item"><a href="">大数据</a></li>-->
    <li class="layui-nav-item">
        <a href="javascript:;">全部项目</a>
        <dl class="layui-nav-child"> <!-- 二级菜单 -->
            <?php
            $i = 0;
            foreach ($userItems as $k => $v) {

                ?>
                <dd>
                    <a href="./info_c.php?id=<?php echo $v['id'] ?>&i=<?php echo $i; ?>"><?php echo $v['name'] . '_' . $v['id']; ?></a>
                </dd>
                <?php
                $i++;
            }
            ?>


        </dl>
    </li>
    <!--    <li class="layui-nav-item"><a href="">社区</a></li>-->
</ul>


<!--<div id="aaa"></div>-->

<fieldset class="layui-elem-field" style="margin-top: 60px;">
    <legend id="aaa"><?php echo $_SESSION['userInfo']['name'] ?></legend>
    <div class="layui-field-box">

        <div class="layui-collapse">
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">我的服务</h2>
                <div class="layui-colla-content layui-show">
                    <div class="layui-row">
                        <div class="layui-col-md6">
                            <div>
                                <h2>接入域名 <?php echo $_SESSION['userInfo']['cdnNum']; ?>个</h2>
                            </div>
                        </div>
                        <div class="layui-col-md6">
                            <div>
                                <h2>
                                    本月总流量 <?php echo isset($_SESSION['userInfo']['monthCount']) ? $_SESSION['userInfo']['monthCount'] : '0'; ?>
                                    G</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="layui-field-box">

        <div class="layui-collapse">
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">今日数据</h2>
                <div class="layui-colla-content layui-show">

                    <div class="layui-row">

                        <div class="layui-col-md4">
                            实时宽带
                            <div id="statBW">

                            </div>
                            kbs
                        </div>
                        <div class="layui-col-md4">
                            今日流量
                            <div id="statSum">

                            </div>
                        </div>
                        <div class="layui-col-md4">
                            今日请求数量
                            <div id="statRes">

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>


    <div class="layui-field-box">

        <div class="layui-collapse">
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">CDN流量本月趋势</h2>
                <div class="layui-colla-content layui-show">


                    <!-- <div id="main" style="width:100%; height: 400px;"></div> -->
                    <div style="height: 300px;width:100%;" id="placeholder"></div>

                </div>
            </div>
        </div>

    </div>


</fieldset>



<script type="text/javascript">
function getCrashReportStatData() {
    $.ajax({
                type: "POST",
                url: "./ajax_info.php",
//                url: "./info_stat.php",
                data: {'buy_id': <?php echo $_SESSION['userInfo']['buy_id'] ?>, 'action': 'graphData'},
                dataType: "json",
                success: function (data) {
                    var __StatDataSets = [];
                    __StatDataSets.push({
                        name: "流量趋势",
                        data: data
                    });
                    console.log(data);
                    update_enginConn_chart(__StatDataSets);
                },
            })
}
var enginConn_chart;

function update_enginConn_chart(__StatDataSets){
	enginConn_chart.redraw();
	var down_data=[];
	// var up_data=[];

	down_data = __StatDataSets[0];
	// up_data = __StatDataSets[1];
	
	var down_name = down_data['name'];
	// var up_name = up_data['name'];
	
	var down_num = [];
	// var up_num = [];
	
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
	
		
	// for(var key in up_data['data'])
	// {		
	// 	data_grp = up_data['data'][key];
			
	// 	xData = parseInt(data_grp[0])*1000;	
	// 	yData = parseFloat(data_grp[1]);
				
	// 	up_num.push({ y : yData, x : xData});
	// }
		
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
	// enginConn_chart.addSeries({
	// 	type: 'area',
	// 	color: '#f0d52e',//color: '#a8d822',
	// 	name:  up_name,
	// 	data: up_num,
	// });
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
				text: '<span class="input_tips_txt"><strong>数据展示</strong></span>',
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
				enabled: false,       
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
getCrashReportStatData();
//位数不够补0
function numAddZero(num, n) {
	return Array(n-(''+num).length+1).join(0)+num; 
}


//     //指定图标的配置和数据
//     var option = {
// //        title: {
// //            text: '流量统计'
// //        },
// //        tooltip: {},
// //        legend: {
// //            data: ['用户来源']
// //        },
// //        xAxis: {
// //            data: [0]
// //        },
// //        yAxis: {},
// //        series: [{
// //            name: '日流量(单位:G)',
// //            type: 'line',
// //            data: [' ']
// //        }]

//         visualMap: {
//             show: false,
//             type: 'continuous',
//             seriesIndex: 0,
//             min: 0,
//             max: 300
//         },


//         title: {
//             left: 'center',
//             text: ''
//         },
//         tooltip: {
//             trigger: 'axis'
//         },
//         xAxis: {
//             data: [0]
//         },
//         yAxis: {
//             splitLine: {show: false}
//         },
//         grid: {
//             bottom: '5%'
//         },
//         series: {
//             type: 'line',
//             showSymbol: false,
//             data: [' ']
//         }
//     };
//     //初始化echarts实例
//     var myChart = echarts.init(document.getElementById('main'));

//     //使用制定的配置项和数据显示图表
//     myChart.setOption(option);
</script>


<script src="./plugins/layui2/layui.all.js"></script>
<script>
    //注意：折叠面板 依赖 element 模块，否则无法进行功能性操作
    layui.use(['element', 'layer'], function () {
        var element = layui.element
            , layer = layui.layer;


        element.on('nav(filter)', function (elem) {
            console.log(elem)
            console.log(elem.context.innerText); //得到当前点击的DOM对象
            var fTitle = elem.context.innerText
//            layer.msg('asdfa');
            document.getElementById('aaa').innerHTML = fTitle;

        });

        //…
    });




    setTimeout("fmPost()", 800)

    function fmPost() {
//        alert("j");
//        location.reload();

        $.ajax({
            type: "POST",
            url: "./ajax_info.php",
            data: {'buy_id': <?php echo $_SESSION['userInfo']['buy_id'] ?>, 'action': 'bandwidth'},
            dataType: "json",
            success: function (msg) {
//                console.log(msg.msgBW);
                var msgBW = msg.msgBW
                $("#statBW").html(msgBW);


            },
        }),

            $.ajax({
                type: "POST",
                url: "./ajax_info.php",
                data: {'buy_id': <?php echo $_SESSION['userInfo']['buy_id'] ?>, 'action': 'Count'},
                dataType: "json",
                success: function (msg) {
//                    console.log(msg);
                    var msgSum = msg.msgSum
                    var msgSumRes = msg.msgSumRes
//                console.log(msgSum)
                    $("#statSum").html(msgSum);
                    $("#statRes").html(msgSumRes);

                },
            }),


            $.ajax({
                type: "POST",
                url: "./ajax_info.php",
//                url: "./info_stat.php",
                data: {'buy_id': <?php echo $_SESSION['userInfo']['buy_id'] ?>, 'action': 'graphData'},
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    // myChart.setOption({
                    //     xAxis: {
                    //         data:data.date
                    //     },
                    //     series: [{
                    //         // 根据名字对应到相应的系列
                    //         name: '日流量(G)',
                    //         data:data.sum
                    //     }]
                    // });


                },
            }),


            setTimeout("fmPost()", 800)
    }







    //    setTimeout("fmPost()",100)
    //    function fmPost(){alert("j");
    //        location.reload();
    //
    //    }
</script>



</body>
</html>


<!--<div class="ibox-content">-->
<!--    <h1 class="no-margins">40 886,200</h1>-->
<!--    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i>-->
<!--    </div>-->
<!--    <small>总收入</small>-->
<!--</div>-->