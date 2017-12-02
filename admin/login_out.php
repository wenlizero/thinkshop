<?php
if(extract($_COOKIE)>0	)
{
	$res = setCookie('admin_username', $_COOKIE['admin_username'] , time()-1,'/');
	if($res)
	{
		echo "<script>alert('退出成功');location.href='../index.php';</script>";
		//退出成功，跳转前台首页
	}
}

?>