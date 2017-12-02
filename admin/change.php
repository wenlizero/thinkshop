<?php
require_once"../config.php";
if(isset($_GET['id']) && isset($_GET['ifshow']))
{
	extract($_GET);
	$url = '' ;
	$where = '';
	if($ifshow == 1)
	{
		$arr = array('ifshow'=>0);
	}
	else
	{
		$arr = array('ifshow'=>1);
	}
	if($table == 'ts_product')
	{
		$where ="pid=$id";
		$url = 'product.php';
	}
	if($table =='ts_news_cate')
	{
		$where ="cid=$id";
		$url = 'news_cate.php';
	}
	if($table =='ts_product_cate')
	{
		$where ="pc_id=$id";
		$url = 'product_cate.php';
		$arr = array();
		if($ifshow == 1)
		{
			$arr = array('pc_ifshow'=>0);
		}
		else
		{
			$arr = array('pc_ifshow'=>1);
		}
	}
	$res = update($arr, $table, $where);
	if($res)
	{
		echo "<script>location.href='$url';</script>";
	}
}
?>