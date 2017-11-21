<?php
include_once("./head.php");
if(!FuncClient_IsLogin())
{
	FuncClient_LocationLogin();
}
	
$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
$buy_id 		= isset($_GET['buy_id'])?$_GET['buy_id']:'';
?>
<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="css/table.css" />
<link rel="stylesheet" href="css/global.css" media="all">

<script type="text/javascript">	
function selectProduct()
{
	var buy_id= document.getElementById("buySelect").value;
	
	window.location.href="stat_buy_product_month.php?buy_id="+buy_id;

}

</script>
<!----------------------------->
<div style="margin: 15px;">
	
		<div class="layui-tab layui-tab-card">
			<ul class="layui-tab-title">
				<a href="stat_buy_product_bandwidth.php?buy_id=<?php  echo $buy_id; ?>"><li>实时带宽</li></a>
				<a href="stat_buy_product_bandwidth_max.php?buy_id=<?php  echo $buy_id; ?>"><li>峰值带宽</li></a>
				<a href="stat_buy_product_day_download.php?buy_id=<?php  echo $buy_id; ?>"><li>日流量统计</li></a>
				<a href="stat_buy_product_day_request.php?buy_id=<?php  echo $buy_id; ?>"><li>请求量统计</li></a>
				<a href="stat_buy_product_month.php?buy_id=<?php  echo $buy_id; ?>"><li class="layui-this">月度流量</li></a>
			</ul>
			<div class="layui-tab-content" style="height: 100%">
				
				
				<!-- 月度流量开始 -->
				<div class="layui-tab-item layui-show">
					<div style="float: right;">
						<!-- 查询方法 -->
						<form action="">
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
										$timeval = mysql_real_escape_string($timeval);
										$client_username = mysql_real_escape_string($client_username);
											
										$sql = "SELECT * FROM fikcdn_buy WHERE username='$client_username';"; 
										$result = mysql_query($sql,$db_link);
										if(!$result ||mysql_num_rows($result)<=0){
											$buy_id ='';
										}
										
										if($result){
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
								<th>月请求数(次)</th>
							</tr>
						</thead>
						<tbody>
							<?php
	$nPage 		= isset($_GET['page'])?$_GET['page']:'';
	$action 	= isset($_GET['action'])?$_GET['action']:'';
	
	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		do
		{			
			$sql = "SELECT * FROM domain_stat_product_month WHERE buy_id=$buy_id ORDER BY id DESC";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				break;
			}
			
			$row_count=mysql_num_rows($result);
			if(!$row_count)
			{
				break;
			}
			
			$timenow = time();
			$timeval1 = mktime(0,0,0,date("m",$timenow),0,date("Y",$timenow));
			
			for($i=0;$i<$row_count;$i++)
			{
				$id  			= mysql_result($result,$i,"id");
				$stat_time  	= mysql_result($result,$i,"time");
				$RequestCount	= mysql_result($result,$i,"RequestCount");
				$UploadCount   	= mysql_result($result,$i,"UploadCount");
				$DownloadCount  = mysql_result($result,$i,"DownloadCount");
				$IpCount   		= mysql_result($result,$i,"IpCount");
												
				if(strlen($RequestCount)<=0) $RequestCount=0;
				if(strlen($UploadCount)<=0) $UploadCount=0;
				if(strlen($DownloadCount)<=0) $DownloadCount=0;
				if(strlen($IpCount)<=0) $IpCount=0;
																
				echo '<tr bgcolor="#FFFFFF" align="center" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">';
				echo '<td>'.($i+1).'</td>';
				echo '<td>'.date("Y 年 m 月",$stat_time).'</td>';
				echo '<td>'.PubFunc_GBToString($DownloadCount).'</td>';
				echo '<td>'.PubFunc_GBToString($UploadCount).'</td>';
				echo '<td>'.$RequestCount.'</td>';				
				echo '</tr>';
			}
		}while(0);
		
		mysql_close($db_link);
	}
?>
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
