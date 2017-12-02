<?include_once"config.php";?>
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
		<div class="reg"><p>注册欣才商城账号</p></div>
		<!--产品展示 start-->
		<div class="reg_p">
			<div class="reg_pl">
				<img src="images/xcsc.jpg" alt="图片展示" title="图片展示">
				<p>知其然知其所以然</p>
				<p>通过我们的实战项目，您可以更全面的理解软件工程</p>
			</div>
			<div class="reg_pr">
				<form action="do_regist.php" method="post" name="form" onsubmit = "return check();">
					<div class="reg_prd">
						<div>
							<span class='mname'>账户:</span>
							<input type="text" name="username" class="username"placeholder="6-14位英文数字">&nbsp;&nbsp;<span id="tip_u"class='tip'></span>
						</div>
					</div>
					<div class="reg_prd">
						<div>
							<span class='mname'>密码:</span>
							<input type="password" name="password" class="username"placeholder="至少6位密码">&nbsp;&nbsp;<span id="tip_p"class='tip'></span>
						</div>
						<div>
							<span class='mname'>确认密码:</span>
							<input type="password" name="repassword" class="username" placeholder="请在再次输入">&nbsp;&nbsp;<span id="tip_r"class='tip'></span>
						</div>
					</div>
					<div class="reg_prd">
						<div>
							<span class='mname'>手机号:</span>
							<input type="text" name="mobile" class="username" placeholder="请输入大陆手机号">&nbsp;&nbsp;<span id="tip_m"class='tip'></span>
						</div>
						<div>
							<span class='mname'>邮箱:</span>
							<input type="email" name="email" class="username" placeholder="选填">&nbsp;&nbsp;<span id="tip_e"class='tip'></span>
						</div>
						<div>
						<span class='mname'>验证码:</span>
						<input type="text" name="verify" class="verify"><span id="yzm">w9d3</span>&nbsp;&nbsp;<span id="tip_v" class='tip'></span>
						</div>
						<div>
							<input type="checkbox"  name="recept" value=1 checked class="recept">
							<font>接&nbsp;受&nbsp;<a href="#" class='center'>欣才商城服务条款</a></font>
						</div>
					</div>
					<input type="submit" name="regist" class="register" value="注册">
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
	var repwd = form.repassword;
	var mobile = form.mobile;
	var email = form.email;
	var tip_u = document.getElementById('tip_u');
	var tip_p = document.getElementById('tip_p');
	var tip_r= document.getElementById('tip_r');
	var tip_m = document.getElementById('tip_m');
	var tip_e = document.getElementById('tip_e');
	var tip_v = document.getElementById('tip_v');
	var preg_u = /^[a-zA-Z0-9]{6,14}$/;
	var preg_p = /^[a-zA-Z0-9]{6,}$/ ;
	var preg_m = /^1[3|4|5|7|8]\d{9}$/;
	var preg_e = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/i;
	var  yzm = document.getElementById('yzm');
	//用户名正则验证
	user.onblur = function(){
		get_preg( preg_u, this , tip_u);
	}
	//密码的正则验证
	pwd.onblur = function(){
		get_preg(preg_p, this , tip_p);
	}
	//密码是否一致
	repwd.onblur = function(){
		if(this.value == pwd.value)
		{
			tip_r.style.backgroundPosition="-80px 0px";
		}
		else
		{
			tip_r.style.backgroundPosition="-80px -24px";
		}
	}
	//手机号正则验证
	mobile.onblur = function(){
		get_preg(preg_m , this , tip_m);
	}

//生成验证码		
function get_verify()
{
	var arr = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	var i=1;//验证码个数
	var max = arr.length-1;//最大下标
	var verify='';//验证码初始化
	for(i;i<=4;i++)
	{
		//随机下标的范围：0~最大下标
		key = Math.round(Math.random()*max);
		verify += arr[key];
	}
	return verify;
}
yzm.innerHTML = get_verify();//初始验证码
//点击事件刷新验证码
yzm.onclick = function (){
	yzm.innerHTML = get_verify();
}
//验证码失去焦点则判断是否正确
form.verify.onblur = function(){
	if(this.value. toLowerCase()== yzm.innerHTML.toLowerCase())
	{
		tip_v.style.backgroundPosition="-80px 0px";
	}
	else
	{
		tip_v.style.backgroundPosition="-80px -24px";
	}
}
function check()
{
	// 用户名手机号密码都不允许为空 ，且每一个都满足正则验证
	if(user.value =='' || pwd.value == '' || repwd.value =='' || mobile=='')
	{
		alert("用户名密码手机号不允许为空")
		return false;
	}
	var res_u = preg_u.test(user.value);
	var res_p = preg_p.test(pwd.value);
	var res_m = preg_m.test(mobile.value);
	var res_e = preg_e.test(email.value);
	var recept = form.recept.value;
	//用户名过滤
	if(!res_u)
	{
		return false;
	}
	//密码过滤
	if(!res_p)
	{
		return false;
	}
	//手机号过滤
	if(!res_m)
	{
		return false;
	}
	//邮箱过滤
	if(email.value != '' && !res_e)
	{
		return false;
	}
	//验证码过滤
	if(form.verify.value == '' || form.verify.value.toLowerCase() !=yzm.innerHTML.toLowerCase())
	{
		return false;
	}
	else
	{
		verify_result = true;
	}
	//用户协议
	if(recept != '1')
	{
		return false;
	}
	//表单提交通过的判断条件
	if(email.value != '')
	{
		if(res_u && res_p && res_m && res_e && verify_result)
		{
			return true;
		}
	}
	else
	{
		if(res_u && res_p && res_m && verify_result)
		{
			return true;
		}
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