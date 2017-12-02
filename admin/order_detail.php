<?php
require_once"../config.php";
if(isset($_GET['order_id']))
{
	extract($_GET);
	$sql="select * from ts_order where order_id=$order_id";
	$order = mysql_fetch_assoc(mysql_query($sql));
	if(isset($type))
	{
		if($type == 'pay')
		{
			$res =update(array('pay_status'=>1) ,'ts_order',"order_id=$order_id");
		}
		if($type == 'delivery')
		{
			$res =update(array('delivery_status'=>1) ,'ts_order',"order_id=$order_id");
		}
		if($res)
		{
			msg('修改成功', 'order.php');exit;
		}
	}
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单详情</title>
<base target="_self">
<link rel="stylesheet" type="text/css" href="skin/css/base.css" />
<link rel="stylesheet" type="text/css" href="skin/css/main.css" />
<style type="text/css">
a:link,a:visited{color:#3366ff;font-weight:bold}
a:hover,a:active{font-weight:bold;color:#ff9900}
</style>
</head>
<body leftmargin="8" topmargin='8'>
<table width="98%" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td background="skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' colspan="2"><span><img src='skin/images/frame/arr3.gif' style='margin-right:10px;'>订单详情</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>
	<form action="" method="post">
		<table style="margin-bottom:8px;margin-top:8px;margin-left:20px;"  border=0>
			 <tr>
				<th width="50px" align='right'>订单号：</th>
				<td><?=$order['order_sn']?></td>
			</tr>
			<tr>
				<th align='right'>下单时间：	</th>
				<td><?=date('Y-m-d H:i:s',$order['order_time'])?>	</td>
			</tr>	
			<tr>
				<th align='right'>购买者：</th>
				<td>
					<?php	
					$res = mysql_query('select username from ts_user where uid='.$order['user_id']);
					$arr = mysql_fetch_assoc($res);
					echo $arr['username'];
					?>
				</td>
			</tr>
			<tr>
				<th align='right'>收货人：</th>
				<td>
					<?php	
					$res = mysql_query('select consignee,address,mobile from ts_address where addr_id='.$order['addr_id']);
					$arr = mysql_fetch_assoc($res);
					echo $arr['consignee'];
					?>
				</td>
			</tr>
			<tr>
				<th align='right'>收货地址	：</th>
				<td><?= $arr['address'];	?></td>
			 </tr>
			 <tr>
				<th align='right'>联系方式	：</th>
				<td><?= $arr['mobile'];	?>	</td>
			 </tr>
			 <tr>
				<th align='right'>订单总额	：</th>
				<td>&yen;<?=$order['subtotal']?></td>
			 </tr>
			  <tr>
				<th align='right'>付款状态	：</th>
				<td>
					<?if($order['pay_status']==1){?>
						<font color='blue'>已付款</font>
					<?}else{?>
						<font color='red'>未付款</font>	
						<a href="order_detail.php?type=pay&order_id=<?=$order_id?>" class='pay'>去付款</a>
					<?}?>
				</td>
			 </tr>
			 <tr>
				<th align='right'>发货状态	：</th>
				<td>
					<?if($order['delivery_status']==1){?>
						<font color='blue'>已发货</font>
					<?}elseif($order['delivery_status']==2){?>
						<font color='green'>已收货</font>
					<?}else{?>
						<font color='red'>未发货</font>	
						<?if($order['pay_status']==1&&$order['delivery_status']==0){?>
						<a href="order_detail.php?type=delivery&order_id=<?=$order_id?>" class='delivery'>去发货</a>
						<?}?>
					<?}?>
				</td>
			 </tr>
		   <tr>
			 <th align='right'>商品信息：</th>
			 <td>
			 <table>
					<tr>
						<th>商品图片</th>
						<th>商品名称</th>
						<th>商品价格</th>
						<th>商品颜色</th>
						<th>商品尺寸</th>
						<th>商品数量</th>
					</tr>
					<?php
					$res = mysql_query('select goods_id from ts_order where order_id='.$order_id);
					if(is_resource($res) && mysql_num_rows($res)>0)
					{
						$arr = mysql_fetch_assoc($res);
						$goods_id = $arr['goods_id'];
						$sql = "select g.color,g.size,g.num,p.pname,p.thumb,p.sprice from ts_order_goods as g,ts_product as p where g.pid=p.pid  and  g.oid=$order_id and  g.pid  in($goods_id)";
						$goods = fetchAll($sql);
						foreach($goods as $v)
						{
					?>
					<tr>
						<td width='120px' align='center'><img src="<?=$v['thumb']?>" alt="" width='100px' /></td>
						<td valign="center" width="300px" align='center'><?=$v['pname']?></td>
						<td width="100px"align='center'><?=$v['sprice']?></td>
						<td width="100px"align='center'><?=$v['color']?></td>
						<td width="100px"align='center'><?=$v['size']?></td>
						<td width="100px"align='center'><?=$v['num']?></td>
					</tr>
				<?}}?>	
				</table>
			 </td>
		   </tr>
		</table>
	</form>
	</td>
  </tr>
</table>
</body>
</html>