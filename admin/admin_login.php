<?php
require_once"../config.php";
if(isset($_POST['admin_log']))
{
	extract($_POST);
	$username = trim($username);
	$password = md5(trim($password));
	$sql = "select * from ts_user where admin=1 and username='$username' and password='$password' ";
	$rec = mysql_query($sql);
	if(is_resource($rec) && mysql_num_rows($rec))
	{
		$result = setCookie('admin_username',$username,time()+3600*7*24,'/');
		if($result)
		{
			msg('登录成功','index.php');exit;
		}
	}
}
?>
<!doctype html>
<html>
	<head>
		<title></title>
		<meta  charset="utf-8"/>
		<style type="text/css">
		body{background:#fff;opacity:0.8;}
		.welcome{font-size:80px;font-family:'楷体'}
		.ad-lo{width:600px;height:400px;background:#e1feba;margin:100px auto;border-radius:5px}
		.ad-u{width:500px;height:300px;border:0px solid ;margin:0px auto;position:relative;top:60px}
		.ad-u span{font-size:30px;font-weight:bold;margin:10px;}
		.ad-inp{width:330px;height:30px;margin-left:15px;border-radius:5px;border:0px;margin:20px;font-size:28px;}
		.ad-sub{width:400px;height:50px;line-height:50px;text-align:center;font-size:30px;margin:50px;background:#009933;border-radius:5px;border:0px;font-weight:bold;letter-spacing:20px;cursor:pointer;}
		</style>
	</head>
	<body>
		<h1 align='center' class='welcome'>welcome  to thinksite</h1>
		<div class='ad-lo'>
			<form action="" method='post' onsubmit='return check()' name='adminForm'>
				<div class='ad-u'>
					<span>用户名</span><input type="text" name='username' class='ad-inp'/>
					<br />
					<span>密&nbsp;码</span><input type="password" name='password' class='ad-inp'/>
					<br />
					<input type="submit" name='admin_log' value='登录' class='ad-sub'/>
				</div>
			</form>
		</div>
	</body>
</html>
<script type="text/javascript">
function check()
{
	if(adminForm.username.value=='' || adminForm.password.value=='')
	{
		alert('请输入用户名和密码');
		return false;
	}
	else
	{
		return true;
	}
}
</script>