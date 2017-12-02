<?php
require_once"../config.php";
if(isset($_GET['pc_id']))
{
	$pc_id = $_GET['pc_id'];
	//判断该分类下是否有子类:若有则不允许删除
	$sql = "select * from ts_product_cate where pc_fid=$pc_id";
	$res1 = fetchAll($sql);
	if(is_array($res1) && count($res1)>0)//存在子类
	{
		msg('不能删除','product_cate.php');exit;
	}
	//判断该分类下是否有产品:若有不允许删除



	$result = delete('ts_product_cate',"pc_id=$pc_id");
	if($result>0)
	{
		msg('删除成功','product_cate.php');exit;
	}
	else
	{
		msg('删除失败','product_cate.php');exit;
	}
}
?>