<?php
session_start();
require_once"config.php";
//登录后才允许购买
if(!isset($_COOKIE['username']))//登录界面必需进行存储cookie的过程
{
	msg("请先登录","login.php");exit;
}
if(isset($_POST['pid']))
{
	extract($_POST);//$color   $size   $num    $pid
	$user_id = $_COOKIE['user_id'];
	//判断该商品是否已经加入购物车了
	$rec = mysql_query("select cart_id,num from ts_cart where user_id=$user_id and pid=$pid and color='$color' and size='$size'");
	if(is_resource($rec) && mysql_num_rows($rec)>0)
	{
		$arr = mysql_fetch_assoc($rec);
		$cart_id = $arr['cart_id'];
		$num = $num+$arr['num'];
		$res = update(array('num'=>$num),'ts_cart', "cart_id=$cart_id");//修改数量
	}
	else
	{
		$array = array('color'=> trim($color) ,'size'=>trim($size),'num'=>trim($num),'user_id'=>$user_id,'pid'=>$pid) ;//否则新增
		$res = insert($array,"ts_cart");
	}
	if($res)
	{
		msg('成功加入购物车', 'shopcar.php');
	}
}
?>