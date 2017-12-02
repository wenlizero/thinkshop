<?php
require_once "config.php";
//判断是否通过表单提交
if(!isset($_POST['login']))
{
	msg("请通过表单提交","login.php");exit;
}
//过滤数据
extract($_POST);
$username = trim($username);
$password_md5 = md5(trim($password));//对密码进行MD5加密
//查询是否有对应的登录信息,必需是通过审核的用户
$sql = "select uid ,ifshow from ts_user where username='$username' and password = '$password_md5' and ifshow=1";
$rec = mysql_query($sql);
if(is_resource($rec) && mysql_num_rows($rec)==1)//记录有且只有一条
{
	$info = mysql_fetch_assoc($rec);
	if($info['ifshow']==0)
	{
		msg("您未通过审核,请联系客服");exit;
	}
	//进行COOKIE
	$res1 = setCookie("username" , $username, time()+3600*24,"/");
	$res2 = setCookie("password" , $password, time()+3600*24,"/");
	$res1 = setCookie("user_id" , $info['uid'], time()+3600*24,"/");
	if($res1 && $res2)
	{
		msg("登录成功","index.php");exit;
	}
}
else
{
	msg("登录失败","login.php");exit;
}

?>