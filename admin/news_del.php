<?php
require_once"../config.php";
if(isset($_GET['news_id']))
{
	$news_id = $_GET['news_id'];
	//先删除文件夹中的图片
	$sql = "select news_img from ts_news where news_id=$news_id";
	$news = mysql_fetch_assoc(mysql_query($sql));echo $news['news_img'];
	if(!empty($news['news_img']))
	{
		$arr = explode(',',$news['news_img']);
		for($i=0;$i<count($arr);$i++)
		{
			var_dump(unlink($arr[$i]));
		}
	}
	$res = delete('ts_news' , "news_id=$news_id");
	if($res)
	{
		msg('删除成功','news.php');exit;
	}
	else
	{
		msg('删除失败','news.php');exit;
	}
}
//多选删除
if(isset($_GET['ids']))
{
	$ids = rtrim($_GET['ids'],',');
	$sql = "select news_img from ts_news where news_id in ($ids)";
	$news = fetchAll($sql);
	foreach($news as $v)
	{
		if(!empty($v['news_img']))
		{
			$arr = explode(',',$v['news_img']);
			for($i=0;$i<count($arr);$i++)
			{
				unlink($arr[$i]);
			}
		}
	}
	$res = delete('ts_news' , "news_id in ($ids)");
	if($res)
	{
		msg('删除成功','news.php');exit;
	}
	else
	{
		msg('删除失败','news.php');exit;
	}
}
?>