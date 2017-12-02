<?php
require_once"config.php";
$cart='';
if(isset($_COOKIE['username']))
{
	$user_id = $_COOKIE['user_id'];
	$cart = fetchAll("select * from ts_cart where user_id=$user_id order by cart_id desc");
}
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
        <!--位置导航 start-->
		<div class="position">
			<p>当前所在:<a href="index.php">商城</a>&gt;<a href="shopcar.php">购物车</a></p>
		</div>
		<!--位置导航 end-->
		<!--购物车列表 start-->
		<?if($cart){?>
		<div class="shop_car">
			<div class="car_bt">
				<div style="margin-left:30px;">图片</div>		
				<div style="margin-left:150px;">名称</div>		
				<div style="margin-left:200px;">属性</div>		
				<div style="margin-left:120px;">价格</div>
				<div style="margin-left:150px;">数量</div>			
				<div style="margin-left:100px;">操作</div>		
			</div>
			<?php 
				$subtotal=0;
				foreach($cart as $v){
				$pid = $v['pid'];
				$res = mysql_query("select pname, thumb,price,sprice,snums from ts_product where pid=$pid");
				if(is_resource($res) && mysql_num_rows($res)>0)
				{
					$pro = mysql_fetch_assoc($res);
					if($pro)
					{	$total = $v['num']*$pro['sprice'];
						$subtotal = $total+$subtotal;
			?>
			<form method="get" action="edit.php">
			<div class="car_list">
					<div class="pimg"><a href="product.php?pid=<?=$v['pid']?>"><img src="admin/<?=$pro['thumb']?>" alt="<?=$pro['pname']?>" title="<?=$pro['pname']?>" width='120px'></a></div>
					<div class="pname"><a href="product.php?pid=<?=$v['pid']?>" class="namea"><?=$pro['pname']?></a></div>
					<div class="pattr">
						<span>颜色 : </span><span class="pcolor" style="background:<?=$v['color']?>"></span><br />
						<span>尺寸 : <?=$v['size']?></span>
					</div>
					<div class="pprice"><span>&yen;<?=$pro['sprice']?></span></div>
	<div class="pnum">
		<span onclick="plus(<?=$v['cart_id']?>)">+</span>
		<input type="text" name="num" class="number" value="<?=$v['num']?>" id="num<?=$v['cart_id']?>" onblur="checkNum(this,<?=$v['cart_id']?>)">
		<span onclick="minus(<?=$v['cart_id']?>)">-</span>
		<br />&nbsp;&nbsp;
		<small class="kucun">库存<b id="snums<?=$v['cart_id']?>"><?=$pro['snums']?></b>件</small>
	</div>
					<div class="pmenu">
						<input type="hidden"name='cart_id' value="<?=$v['cart_id']?>"/>
						<input type="hidden"name='snums' value="<?=$pro['snums']?>"/>
						<input type="submit" name="edit" value="修改"class="pedit"/>
						<a href="edit.php?type=delete&cart_id=<?=$v['cart_id']?>" class="pdel">删除</a>
					</div>
					<span class="clear"></span>
			</div>
			</form>
			<?}}}?>
		</div>
		<!--购物车列表 end-->
		<!--更新购物车/商品总价/结算 start-->
		<div class="total">
			<a href="edit.php?type=empty" class="update">清空购物车</a>
			<font>商品总价：<span>&yen;<?=$subtotal?></span></font>
			<div class="clear"></div>
		</div>
		<div class="settle">
			<input type="button" name="set_js" class="set_jx" value="继续购物" onclick="location.href='index.php'">
			<input type="button" name="set_js" class="set_jx" value="去结算" onclick="location.href='order.php?type=2'">
			<div class="clear"></div>
		</div>
		<!--更新购物车/商品总价/结算 start-->
		<?}else{?>
			<h1 align="center">您的购物车是空的！</h1>
		<?}?>
		<!--底部代码  公用 start-->
		<?include_once"footer.php"?>
		<!--底部代码  公用 end-->
	</body>
</html>
<script type="text/javascript">
//数量的加
function plus(cart_id)
{
	var numobj = document.getElementById('num'+cart_id);
	var snums = document.getElementById('snums'+cart_id);
	var num = parseInt(numobj.value);
	var kucun = parseInt(snums.innerHTML);
	var num=num+1;
	if(num>kucun)
	{
		num = kucun;
	}
	if(num<1)
	{
		num = 1;
	}
	numobj.value = num;
}
//数量的减
function minus(cart_id)
{
	var numobj = document.getElementById('num'+cart_id);
	var snums = document.getElementById('snums'+cart_id);
	var num = parseInt(numobj.value);
	var kucun = parseInt(snums.innerHTML);
	var num=num-1;
	if(num>kucun)
	{
		num = kucun;
	}
	if(num<1)
	{
		num = 1;
	}
	numobj.value = num;
}
function checkNum(obj,pid)
{
	var snums = document.getElementById('snums'+pid);
	if(parseInt(obj.value)>parseInt(snums.innerHTML))
	{
		obj.value = snums.innerHTML;
	}
}

</script>