<?php
require_once"config.php";
//判断登录
if(!isset($_COOKIE['username']))
{
	msg("请先登录","login.php");exit;
}
//获取当前用户的收货地址
if(isset($_COOKIE['user_id']))
{
	$user_id = $_COOKIE['user_id'];
	$addr = fetchAll("select * from ts_address where u_id=$user_id order by addr_id desc");
}
//立即购买:从商品详情页的表单获取购买信息
if($_GET['type']==1)
{
	extract($_POST);
	$sql = "select pid,pname ,thumb,sprice from ts_product where pid=$pid";
	$cart= mysql_fetch_assoc(mysql_query($sql));
	$cart['num'] = $num;
	$cart['color'] = $color;
	$cart['size'] = $size;
	//立即购买,单件商品,$cart是一维数组,商品信息不用遍历
}

//购物车购买:从ts_cart表中获取购物车信息,可能是多件商品,二维数组
if($_GET['type']==2)
{
	$cart = fetchAll("select * from ts_cart where user_id=$user_id order by cart_id desc");
	//购物车购买,可能是多件商品,$cart是二维数组,商品信息需要遍历
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
			<p>当前所在:<a href="index.php">商城</a>&gt;<a href="order.php">订单</a></p>
		</div>
		<!--位置导航 end-->
		<!--收货信息 start-->
		<div class="addr">
		<h4 class="addr-add">新增收货地址</h4>
		<div class="addr-form">
			<form action="address.php"method='post' name="addrForm" onsubmit='return check()'>
				<div class="addr-div"><span class="form-addr">收 货 人 ：</span><input type="text" name="consignee" class="addr-inp"/></div>
				<div class="addr-div"><span class="form-addr">详细地址：</span><input type="text" name="address" class="addr-inp"/></div>
				<div class="addr-div"><span class="form-addr">联系方式：</span><input type="text" name="mobile" class="addr-inp"/></div>
				<div class="addr-div"><input type="checkbox" name="addr_default" id="addr_default" value=1 checked class="addr-default"/><label for="addr_default">设为默认地址</label></div>
				<div class="addr-div">
					<input type="hidden" name="type" value=2/>
					<input type="submit" name="addrSave" value="保存" class="addr-save"/>
					<input type="reset" name="addrCancel" value="取消" class="addr-save cancel"/>
				</div>
			</form>
		</div>
		<h3 class="addr-info">收货信息</h3>
		<form  name="orderForm">
		<?if($addr){?>
		<ul class="addr-ul">
		<?foreach($addr as $vo){?>
			<li  class="addr-li">
				<input type="radio" name="addr_id"value="<?=$vo['addr_id']?>" id="<?=$vo['addr_id']?>" <?if($vo['addr_default']){echo 'checked';}?>/>
				<label for="<?=$vo['addr_id']?>" style="margin: 5px;">
					收货人：<?=$vo['consignee']?>；收货地址：<?=$vo['address']?>；手机：<?=$vo['mobile']?>
				</label>&nbsp;&nbsp;
				<div class="addrDel"><a href="address.php?type=del&id=<?=$vo['addr_id']?>" class="addr-del">删除</a></div>
			</li>
		<?}?>
		</ul>
		<?}?>
		</div>
		<!--收货信息 end-->
		<!--购物车列表 start-->
		<?if($cart){?>
		<div class="shop_car">
			<div class="car_bt">
				<div style="margin-left:30px;">图片</div>		
				<div style="margin-left:150px;">名称</div>		
				<div style="margin-left:200px;">属性</div>		
				<div style="margin-left:120px;">价格</div>
				<div style="margin-left:150px;">数量</div>			
				<div style="margin-left:100px;">小计</div>		
			</div>
			<?if($_GET['type']==2){
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
			<div class="car_list">
				<input type="hidden" name="subtotal" value="<?=$subtotal?>"/>
				<input type="hidden" name="type" value="<?=$_GET['type']?>"/>
				<div class="pimg"><a href="product.php?pid=<?=$v['pid']?>"><img src="admin/<?=$pro['thumb']?>" alt="<?=$pro['pname']?>" title="<?=$pro['pname']?>" width='120px'></a></div>
				<div class="pname"><a href="product.php?pid=<?=$v['pid']?>" class="namea"><?=$pro['pname']?></a></div>
				<div class="pattr">
					<span>颜色 : </span><span class="pcolor" style="background:<?=$v['color']?>"></span><br />
					<span>尺寸 : <?=$v['size']?></span>
				</div>
				<div class="pprice"><span>&yen;<?=$pro['sprice']?></span></div>
				<div class="pnum" style="left:75px;top:-70px;"><?=$v['num']?></div>
				<div class="pmenu">
					&yen;<?=$total?>
				</div>
				<span class="clear"></span>
			</div>
			<?}}}}elseif($_GET['type']==1){?>
			<div class="car_list">
				<input type="hidden" name="pid" value="<?=$cart['pid']?>"/>
				<input type="hidden" name="pname" value="<?=$cart['pname']?>"/>
				<input type="hidden" name="num" value="<?=$cart['num']?>"/>
				<input type="hidden" name="color" value="<?=$cart['color']?>"/>
				<input type="hidden" name="size" value="<?=$cart['size']?>"/>
				<input type="hidden" name="type" value="1"/>
				<input type="hidden" name="subtotal" value="<?php echo $subtotal = $cart['num']*$cart['sprice'];?>"/>
				<div class="pimg"><a href="product.php?pid=<?=$cart['pid']?>"><img src="admin/<?=$cart['thumb']?>" alt="<?=$cart['pname']?>" title="<?=$cart['pname']?>" width='120px'></a></div>
				<div class="pname"><a href="product.php?pid=<?=$cart['pid']?>" class="namea"><?=$cart['pname']?></a></div>
				<div class="pattr">
					<span>颜色 : </span><span class="pcolor" style="background:<?=$cart['color']?>"></span><br />
					<span>尺寸 : <?=$cart['size']?></span>
				</div>
				<div class="pprice"><span>&yen;<?=$cart['sprice']?></span></div>
				<div class="pnum" style="left:75px;top:-70px;width:90px;"><?=$cart['num']?></div>
				<div class="pmenu"style="width:50px">
					&yen;<?= $subtotal?>
				</div>
				<span class="clear"></span>
			</div>
			</form>
			<?}?>
		</div>
		<!--购物车列表 end-->
		<!--更新购物车/商品总价/结算 start-->
		<div class="total">
			<font>商品总价：<span>&yen;<?=$subtotal?></span></font>
			<div class="clear"></div>
		</div>
		<div class="settle">
			<input type="button" class="set_jx" value="继续购物" onclick="location.href='index.php'">
			<input type="button" class="set_jx" value="提交订单" onclick="getOrder()">
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
function check()
{
	var preg_m = /^1[3|4|5|7|8]\d{9}$/;
	//手机号正则验证
	var res = false;
	if(addrForm.mobile.value !='')
	{
		var res = preg_m.test(addrForm.mobile.value)
	}
	if(addrForm.consignee.value =='' || res == false || addForm.address.value== '')
	{
		return false;
	}
}
function getOrder()
{
	orderForm.action = 'do_order.php';
	orderForm.method = 'get';
	orderForm.submit();
}
</script>
