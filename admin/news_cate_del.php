<?php
require_once"../config.php";
if(isset($_GET['cid']))
{
	$cid = $_GET['cid'];
	//判断该分类下是否有子类:若有则不允许删除
	$sql = "select * from ts_news_cate where fid=$cid";
	$res1 = fetchAll($sql);
	if(is_array($res1) && count($res1)>0)//存在子类
	{
		msg('不能删除','news_cate.php');exit;
	}
	$result = delete('ts_news_cate',"cid=$cid");
	if($result>0)
	{
		msg('删除成功','news_cate.php');exit;
	}
	else
	{
		msg('删除失败','news_cate.php');exit;
	}
}
?>