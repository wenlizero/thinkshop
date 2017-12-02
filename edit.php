<?php
require_once"config.php";
	/*修改商品数量*/
	if(isset($_GET['edit']))
	{
		extract($_GET);
		if($num>$snums || $num<1)
		{
			msg('购买数量不合法',"shopcar.php");exit;
		}
		$res = update(array('num'=>$num) , "ts_cart" ,"cart_id=$cart_id");
		if($res)
		{
			msg('修改成功','shopcar.php');exit;
		}else{
			msg('修改失败','shopcar.php');exit;
		}
	}
	//购物车记录的删除
	if(isset($_GET['type']) )
	{
		extract($_GET);
		if($type == 'delete' && isset($cart_id))/*删除指定商品*/
		{
			$res = delete("ts_cart","cart_id=$cart_id");
		}
		else if($type == 'empty')	/*清空购物车*/
		{
			$res = delete("ts_cart");
		}
		if($res)
		{
			msg('成功','shopcar.php');exit;
		}else{
			msg('失败','shopcar.php');exit;
		}
	}


?>