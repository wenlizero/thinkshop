<?php
require_once"config.php";
if(isset($_COOKIE['username']) &&  $_COOKIE['password'] &&$_COOKIE['user_id'])
{
	$res1 = setCookie("username" , $_COOKIE['username'] , time()-1, "/");
	$res2 = setCookie("password" , $_COOKIE['password'] , time()-1, "/");
	$res3 = setCookie("user_id" , $_COOKIE['user_id'] , time()-1, "/");
}
if($res1 && $res2 && $res3)
{
	msg("退出成功","index.php");
}
else
{
	msg("退出失败","index.php");
}
?>