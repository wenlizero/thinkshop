<?php
require_once"config.php";
?>
<!doctype  html>
<html>
	<head>
		<meta charset="utf-8" />
		<?if($config){foreach($config as $k=>$v){if($v['sys_name']=='title'){?>
			<title><?=$v['sys_val']?></title>
			<?}else{?>
			<meta name="<?=$v['sys_name']?>" content="<?=$v['sys_val']?>" />
		<?}}}?>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/index.css">
	</head>

	<body>
		<!--头部代码  公用 start-->
		<?include_once"header.php"?>
		<!--头部代码  公用 end-->
		<div class="reg"><p>欣才商城账号登录</p></div>
		<!--产品展示 start-->
		<div class="reg_p">
			<div class="reg_pl">
				<img src="images/xcsc.jpg" alt="图片展示" title="图片展示">
			</div>
			<div class="reg_pr">
				<form action="do_login.php" method="post" name="form" onsubmit="return check()">
					<div class="reg_prd">
						<div>
							<span class='mname'>账户:</span>
							<input type="text" name="username" class="username" placeholder="6-14位英文数字"value="<?if(isset($_COOKIE['username'])){echo $_COOKIE['username'];}?>">&nbsp;&nbsp;<span id="tip_u"class='tip'></span>
						</div>
						<div>
							<span class='mname'>密码:</span>
							<input type="password" name="password" class="username" placeholder="至少6位密码"value="<?if(isset($_COOKIE['password'])){echo $_COOKIE['password'];}?>">&nbsp;&nbsp;<span id="tip_p"class='tip'></span>
						</div>
						<div>
							<input type="checkbox"  name="recept" value=1 checked class="recept"id="recept"><label for="recept">下 次 自 动 登 录</label>
						</div>
					</div>
					<input type="submit" name="login" class="register" value="登录">
				</form>
			</div>
			<div class="clear"></div>
		</div>
		<!--产品展示 end-->
		<!--底部代码  公用 start-->
		<?include_once"footer.php"?>
		<!--底部代码  公用 end-->
	</body>
</html>
<script type="text/javascript">
	var user = form.username;
	var pwd = form.password;
	var tip_u = document.getElementById('tip_u');
	var tip_p = document.getElementById('tip_p');
	var preg_u = /^[a-zA-Z0-9]{6,14}$/;
	var preg_p = /^[a-zA-Z0-9]{6,}$/ ;
	//用户名正则验证
	user.onblur = function(){
		get_preg( preg_u, this , tip_u);
	}
	//密码的正则验证
	pwd.onblur = function(){
		get_preg(preg_p, this , tip_p);
	}
	function check()
{
	// 用户名密码都不允许为空 ，且每一个都满足正则验证
	if(user.value =='' || pwd.value == '' )
	{
		alert("用户名密码不允许为空")
		return false;
	}
	var res_u = preg_u.test(user.value);
	var res_p = preg_p.test(pwd.value);
	if(res_u &&res_p)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function get_preg(preg , obj , tip)
{
	if(preg.test(obj.value))
	{
		tip.style.backgroundPosition="-80px 0px";
	}
	else
	{
		tip.style.backgroundPosition="-80px -24px";
	}
}
</script>