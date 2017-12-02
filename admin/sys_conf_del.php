<?php
require_once('../config.php');
if( isset($_GET['id']))
{
	$id = $_GET['id'];
	$sql = "delete from ts_sysconfig where sys_id = $id";
	$res = mysql_query($sql);
	if( mysql_affected_rows()==1 )
	{
		msg('删除成功','sys_conf.php');
	}
	else
	{
		msg('删除失败','sys_conf.php');
	}
}
//复选框多选删除
if(isset($_GET['ids']))
{
	$ids = rtrim($_GET['ids'] , ',');
	$sql = "delete from ts_sysconfig where sys_id in ({$ids})";
	$res = mysql_query($sql);
	if( mysql_affected_rows()>0 )
	{
		msg('删除成功','sys_conf.php');
	}
	else
	{
		msg('删除失败','sys_conf.php');
	}
}
?>