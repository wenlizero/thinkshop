<?php
require_once"../config.php";
if(isset($_GET['order_id']))
{
	extract($_GET);
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
//订单搜索
if(isset($_GET['search']))
{
print_r($_GET);



}
$page = 1;$num = 10;
$count = mysql_num_rows(mysql_query("select * from ts_news"));
$max = ceil($count/$num);
if(isset($_GET['page']))
{
	$page = $_GET['page'];
	if($page>$max)
	{
		$page = $max;
	}
	else if($page<1)
	{
		$page = 1;
	}
}
$start = ($page-1)*$num;
$order = fetchAll("select * from ts_order order by order_id desc limit $start,$num");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主体部分</title>
<base target="_self">
<link rel="stylesheet" type="text/css" href="skin/css/base.css" />
<link rel="stylesheet" type="text/css" href="skin/css/main.css" />
</head>
<body leftmargin="8" topmargin='8'>
<table width="98%" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"><span><img src='./skin/images/frame/arr3.gif' style='margin-right:10px;'>订单管理</span></td>
	<td align="right" background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="2">
	<?if($order){?>
		<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
			<tr align="center" bgcolor="#FBFCE2" height="25">
				<td width="6%">ID</td>
				<td width="16%">订单号</td>
				<td width="12	%">下单时间</td>
				<td width="10%">付款状态</td>
				<td width="10%">发货状态</td>
				<td width="8%">总金额</td>
				<td width="8%">收货人</td>
				<td width="8%">购买者</td>
				<td width="10%">操作</td>
			</tr>
  <!-- data start-->
			<?foreach($order as $v){?>
			<tr align='center' bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
				<td nowrap><?=$v['order_id']?></td>
				<td align='center'>
					<span id="arc<?=$v['order_id']?>">
							<?=$v['order_sn']?>
					</span>
				<td><?=date('Y-m-d H:i:s',$v['order_time'])?></td>
				<td>
					<?if($v['pay_status']==1){?>
						<font color='blue'>已付款</font>
					<?}else{?>
						<font color='red'>未付款</font>	
						<a href="order_detail.php?type=pay&order_id=<?=$v['order_id']?>" class='pay'>去付款</a>
					<?}?>
				</td>
				<td>
					<?if($v['delivery_status']==1){?>
						<font color='blue'>已发货</font>
					<?}elseif($v['delivery_status']==2){?>
						<font color='green'>已收货</font>
					<?}else{?>
						<font color='red'>未发货</font>	
						<?if($v['pay_status']==1 && $v['delivery_status']==0){?>
						<a href="order_detail.php?type=delivery&order_id=<?=$v['order_id']?>" class='delivery'>去发货</a>
						<?}?>
					<?}?>
				</td>
				<td><?=$v['subtotal']?>元</td>
				<td>
					<?php	
					$res = mysql_query('select consignee from ts_address where addr_id='.$v['addr_id']);
					$arr = mysql_fetch_assoc($res);
					echo $arr['consignee'];
					?>
				</td>
				<td>
					<?php	
					$res = mysql_query('select username from ts_user where uid='.$v['user_id']);
					$arr = mysql_fetch_assoc($res);
					echo $arr['username'];
					?>
				</td>
				<td>
					<a href="order_detail.php?order_id=<?=$v['order_id']?>" target='main'><img src='./skin/images/frame/menusearch.gif' title="查看" alt="查看"  style='cursor:pointer' border='0' width='16' height='16' /></a>
				</td>
			</tr>
			<?}?>
				</table>
				<?}?>
			</td>
		  </tr>
  <!-- data end-->
<!-- page start-->
  <? if(isset($page)){?>
  <tr align="right" bgcolor="#F9FCEF">
	<td height="36" colspan="10" align="center">
		<div class="pagelistbox">
			<span>共 <?=$max?> 页/<?=$count?>条记录 </span>
			<a class='indexPage' href="order.php?page=1">首页 </a>
			<? if($page>1){?>
			<a class='prevPage' href='order.php?page=<?=$page-1?>'>上页</a> 
			<? }?>
			<? 	for($i=1;$i<=$max;$i++){
				if($i==$page){
			?>
				<strong><?=$i?></strong>
			<? }else{?>	
				<a href="order.php?page=<?=$i?>"><?=$i?></a>
			
			<? }}if($page<$max){?>
			<a class='nextPage' href='order.php?page=<?=$page+1?>'>下页</a> 
			<? }?>
			<a class='endPage' href='order.php?page=<?=$max?>'>末页</a> 
			</div>
		</td>
  </tr>
  <? }?>
<!-- page end-->
</table>
</body>
</html>