<?php
require_once"../config.php";
if(isset($_GET['pid']))
{
	$pid = $_GET['pid'];
	//先删除文件夹中的图片
	$sql = "select thumb,pimgs from ts_product where pid=$pid";
	$product = mysql_fetch_assoc(mysql_query($sql));
	if(!empty($product['thumb']))
	{
		 unlink($product['thumb']);
	}
	if(!empty($product['pimgs']))
	{
		$arr = explode(',',$product['pimgs']);
		for($i=0;$i<count($arr);$i++)
		{
			unlink($arr[$i]);
		}
	}
	$res = delete('ts_product' , "pid=$pid");
	if($res)
	{
		msg('删除成功','product.php');exit;
	}
	else
	{
		msg('删除失败','product.php');exit;
	}
}
//多选删除
if(isset($_GET['ids']))
{
	$ids = rtrim($_GET['ids'],',');
	$sql = "select thumb,pimgs from ts_product where pid in ($ids)";
	$products = fetchAll($sql);
	foreach($products as $v)
	{
		if(!empty($v['thumb']))
		{
			 unlink($v['thumb']);
		}
		if(!empty($v['pimgs']))
		{
			$arr = explode(',',$v['pimgs']);
			for($i=0;$i<count($arr);$i++)
			{
				unlink($arr[$i]);
			}
		}
	}
	$res = delete('ts_product' , "pid in ($ids)");
	if($res)
	{
		msg('删除成功','product.php');exit;
	}
	else
	{
		msg('删除失败','product.php');exit;
	}
}
?>