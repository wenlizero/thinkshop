<?php
require_once"config.php";
if(isset($_COOKIE['username']) &&isset($_GET['order_id']))
{
	//展示订单信息
	$order_id = $_GET['order_id'];
	$sql = "select order_sn,order_time,subtotal from ts_order where order_id=$order_id";
	$rec = mysql_query($sql);
	if(is_resource($rec) && mysql_num_rows($rec)>0)
	{
		$order = mysql_fetch_assoc($rec);
	}
	//立即支付
	if(isset($_GET['type']) && $_GET['type']=='pay')
	{
		if(update(array('pay_status'=>1),'ts_order',"order_id=$order_id"))
		{
			msg('支付成功,查看订单','user.php?type=order');exit;
		}
	}
}
?>
<!doctype  html>
<html>
	<head>
		<meta charset="utf-8" />
		<?if($config){foreach($config as $k=>$v){if($v['sys_name']=='title'){?>
			<title><?=$v['sys_val']?></title>
			<?}else{?>
			<meta name="<?=$v['sys_name']?>" content="<?=$v['sys_val']?>" />
		<?}}}?>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/index.css">
	</head>

	<body>
		<!--头部代码  公用 start-->
		<?include_once"header.php"?>
		<!--头部代码  公用 end-->
        <!--位置导航 start-->
		<div class="position">
			<p>当前所在:
				<a href="index.php">商城</a>&gt;
				<a >完成订单</a>
			</p>
		</div>
		<!--位置导航 end-->
		<!--产品展示 start-->
		<?if(isset($order)){?>
		<div class="do-div">
		<div class="do-img"></div>
			<h2 class="do-cog">恭喜您，成功提交订单</h2>
			<h3 class="do-info">您的订单号是：<?=$order['order_sn']?></h3>
			<h3 class="do-info">下单时间：<?=date('Y-m-d H:i:s',$order['order_time'])?></h3>
			<h3 class="do-info">订单总额：<font color="red">&yen;<?=$order['subtotal']?></font></h3>
			<h3 class="do-info">
			<a href="done.php?type=pay&order_id=<?=$order_id?>" class='do-but'>立即支付</a>
			<a href="index.php" class='do-but do-index'>返回首页</a>
			</h3>
		</div>
		<?}?>
		<!--产品展示 end-->
	
		<!--底部代码  公用 start-->
		<?include_once"footer.php"?>
		<!--底部代码  公用 end-->
	</body>
</html>


