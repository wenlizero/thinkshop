<?php
require_once"config.php";
/*判断表单是否通过按钮提交*/
if(!isset($_POST['regist']))
{
	msg("请通过表单提交","zhuce.php");exit;
}
//过滤数据
extract($_POST);
if(empty($username) || empty($password) ||empty($repassword)|| empty($mobile)||empty($verify))
{
	msg("数据不允许为空","regist.php");exit;
}
//去空格
$username= trim($username);
$password= trim($password);
$repassword= trim($repassword);
$mobile= trim($mobile);
if(!empty($email))
{
	$email= trim($email);
}
else
{
	$email ='';
}
//用户名正则
$preg_u = "/^[a-zA-Z0-9]{6,14}$/";
if(preg_match($preg_u , $username) == 0)
{
	msg("用户名不正确", "regist.php");exit;
}
//密码是否一致
if($password  !== $repassword)
{
	msg("两次密码不一致", "regist.php");exit;
}
//密码正则
$preg_p = "/^[a-zA-Z0-9]{6,}$/";
if(preg_match($preg_p , $password) == 0)
{
	msg("密码不正确", "regist.php");exit;
}
//手机号正则
$preg_m = "/^1[3|4|5|7|8]\d{9}$/";
if(preg_match($preg_m , $mobile) == 0)
{
	msg("手机号不正确", "regist.php");exit;
}
//邮箱正则 : 没有长度限制 , 以数字字母开头 , 至少有一位 , @ ,必须有 , 字母 , .点号 ,字母,结束符
if(!empty($email))
{
	$preg_e = "/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/i";
	if(preg_match($preg_e , $email) == 0)
	{
		msg("邮箱不正确", "regist.php");exit;
	}
}
$password = md5($password);//32位加密
/*判断用户名或手机号是否已经被注册*/
$sql = "select id  from user  where username='$username' or  mobile=$mobile";
$rec = mysql_query($sql);
if(is_resource($rec) && mysql_num_rows($rec)>0)
{
	msg("用户名或手机号已存在","regist.php");exit;
}
/*执行语句*/
$sql = "insert into ts_user(username , password , mobile ,email) value('$username' , '$password' , $mobile , '$email')";
mysql_query($sql);
if(mysql_affected_rows()>0)
{
	msg("注册成功",'login.php');exit;
}
else
{
	msg("注册失败,请重新注册","regist.php");exit;
}
?>