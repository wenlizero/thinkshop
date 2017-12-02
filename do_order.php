<?php
require_once"config.php";
//判断是否登录
if(!isset($_COOKIE['username']))
{
	msg("请先登录","login.php");exit;
}

//判断是否有收获地址
if(!isset($_GET['addr_id']))
{
	msg('请先填写收货地址','order.php?type='.$_GET['type']);exit;
}

//过滤数据
extract($_GET);
$user_id = $_COOKIE['user_id'];

//若购物车购买，商品 id 可能是多个值
if($type==2)
{
	//购物车商品信息
	$cart = fetchAll("select * from ts_cart where user_id=$user_id order by cart_id desc");
	if($cart)
	{
		$pid='';
		foreach($cart as $v)
		{
			$pid .=$v['pid'].',';
		}
		$pid = rtrim($pid , ','); //将购物车中多个商品 id 连接成字符串
	}	
}
//将数据组合成数组,方便入库
$array = ['addr_id'=>$addr_id,'user_id'=>$user_id ,'goods_id'=>$pid,'subtotal'=>$subtotal,'order_time'=>time(),'order_sn'=>date('YmdHis').rand(1000,9999)];
$order_id = insert($array , 'ts_order');//新增订单的id
//订单商品表的入库
if($type==1)
{	
	//修改被购买商品的库存
	$sql = "select snums from ts_product where pid=$pid";
	$arr = mysql_fetch_assoc(mysql_query($sql));
	$snums = $arr['snums']-$num;
	update(array('snums'=>$snums),"ts_product","pid=$pid");
	//订单商品信息
	$result=insert(array('oid'=>$order_id,'uid'=>$user_id,'pid'=>$pid,'color'=>$color,'size'=>$size,'num'=>$num) , 'ts_order_goods');
}
if($type==2)
{
	foreach($cart as $vo)//逐个修改购物车商品的库存
	{	
		$sql = "select snums from ts_product where pid=".$vo['pid'];
		$arr = mysql_fetch_assoc(mysql_query($sql));
		$snums = $arr['snums']-$vo['num'];
		update(array('snums'=>$snums),"ts_product","pid=".$vo['pid']);
		//订单商品信息
		$result=insert(array('oid'=>$order_id,'uid'=>$user_id,'pid'=>$vo['pid'],'color'=>$vo['color'],'size'=>$vo['size'],'num'=>$vo['num']) , 'ts_order_goods');
		//删除购物车记录
		delete('ts_cart',"user_id=$user_id");
	}
}
if($order_id > 0 && $result==true)
{
	msg('订单提交成功','done.php?order_id='.$order_id);
}
?>