<?php
require_once"config.php";
if(isset($_GET['pid']))
{
	$pid = $_GET['pid'];
	$product = mysql_fetch_assoc(mysql_query("select * from ts_product where pid=$pid"));
	$p_c_id = $product['p_c_id'];
	$pc_name = mysql_fetch_assoc(mysql_query("select pc_name from ts_product_cate where pc_id=$p_c_id"));
	$pc_name = $pc_name['pc_name'];
	//商品评论
	$message = fetchAll("select m.*,u.username from ts_message as m,ts_user as u where m.user_id=u.uid and m.goods_id=$pid");
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
			<p>当前所在:
				<a href="index.php">商城</a>&gt;
				<a href="index.php?pc_id=<?=$p_c_id?>"><?=$pc_name?></a>
			</p>
		</div>
		<!--位置导航 end-->
		<!--产品展示 start-->
		<?if($product){?>
		<div class="proIntro">
			<div class="proIntro_l">
					<img src="admin/<?=$product['thumb']?>" class="picshow" alt="<?=$product['pname']?>" title="<?=$product['pname']?>" id='bim'>
				<div class="picshowed">
					<ul>
					<?if(!empty($product['pimgs'])){$pimgs = explode(',' ,$product['pimgs'] );for($i=0;$i<count($pimgs);$i++){ ?>
						<li><img src="admin/<?=$pimgs[$i]?>" onclick	="changeImg(this)"></li>
						<?}}?>
					</ul>
					<div class="clear"></div>
				</div>
			</div>
			<div class="proIntro_r">
				<h3><?=mb_substr($product['pname'],0,25);?></h3>
				<div class="keyword"><?=$product['keyword']?></div>
				<div class="pinfo">
					<div>
						<span>商品编号：</span>
						<span><?=$product['pnums']?></span>
					</div>
					<div>
						<span>商品原价：</span>
						<strike> &yen; <?=$product['price']?></strike>
					</div>
					<div>
						<span>特价优惠：</span>
						<strong style='color:#ff9933'> &yen; <?=$product['sprice']?></strong>
					</div>
					<div>
						<span>商品产地：</span>
						<span><?=$product['addr']?></span>
					</div>
					<form name='form' method='post'>
					<div>
						<span>商品颜色：</span>
						<span>
							<?if(!empty($product['color'])){$color = explode(',' ,$product['color'] );for($i=0;$i<count($color);$i++){ ?>
							<input type="radio" name="color" value="<?=$color[$i]?>" id="<?=$color[$i]?>" <?if($i==0){echo "checked";}?>/>
								<label for="<?=$color[$i]?>"> <span class="sp_col"style="background:<?=$color[$i]?>"></span></label>
							<?}}?>	
						</span>
					</div>
					<div>
						<span>商品尺码：</span>
							<?if(!empty($product['size'])){$size = explode(',' ,$product['size'] );for($i=0;$i<count($size);$i++){ ?>
							<input type="radio" name="size" value="<?=$size[$i]?>" id="<?=$size[$i]?>" <?if($i==0){echo "checked";}?>/>
								<label for="<?=$size[$i]?>"><?=$size[$i]?></label>
							<?}}?>	
					</div>
					<div>
						<span>购买数量：</span>
						<span class="num_change" onclick="plus()">+</span>
						<input type="text" name="num" class="num" value="1"onblur = "checkNum(this)">
						<span class="num_change" onclick="minus()">-</span>&nbsp;&nbsp;
						<small>库存<span id="snums"><?=$product['snums']?></span>件</small>
					</div>
					<p class="go dobuy" onclick="dobuy()">立即购买</p>
					<p class="go docart" onclick="docart()">加入购物车</p>
					<input type="hidden" name="pid" value="<?=$pid?>"/>
				</div>
				</form>
			</div>
			<div class="clear"></div>
		</div>
		
		<!--产品展示 end-->
		<!--商品描述 start-->
		<div class="describe">
			<p>商品描述：</p>
		</div>
		<div class="pro_des">
			<?=$product['descp']?>
		</div>
		<?}?>
		<!--商品描述 end-->
		<!--用户评论 start-->
		<?if($message){?>
		<div class="comment">
			<p>用户评论：</p>
		</div>
		<?foreach($message as $m){?>
		<div class="comment_p">
			<div class="users">
				<p style="color:red"><?php if($m['msg_start']==1){echo'差评';}elseif($m['msg_start']==2){echo '中评';}else{echo '好评';}?></p>
				<p><?=$m['msg_content']?></p>
				<p><?=$m['username']?><span><?=date('Y-m-d H:i:s',$m['msg_time'])?></span></p>
			</div>
		</div>
		<?}}?>
		<!--用户评论 end-->	
		<!--页面列表 start-->
		<!-- <div class="pages">
			<div class="page">
				<ul>
					<li>1</li>
					<li><a href="#">2</a></li>
					<li><a href="#">下一页</a></li>
				</ul>				
			</div>
			<div class="clear"></div>
		</div> -->
		<!--页面列表 end-->
		<!--底部代码  公用 start-->
		<?include_once"footer.php"?>
		<!--底部代码  公用 end-->
	</body>
</html>
<script type="text/javascript">
//图片切换
function changeImg(obj)
{
	var bim = document.getElementById('bim');
	bim.src = obj.src;
}

//数量的修改
function plus()
{
	num = parseInt(form.num.value);
	kucun = parseInt(snums.innerHTML);
	num=num+1;
	if(num>kucun)
	{
		num = kucun;
	}
	if(num<1)
	{
		num = 1;
	}
	form.num.value = num;
}
function minus()
{
	num = parseInt(form.num.value);
	kucun = parseInt(snums.innerHTML);
	num=num-1;
	if(num>kucun)
	{
		num = kucun;
	}
	if(num<1)
	{
		num = 1;
	}
	form.num.value = num;
}
function checkNum(obj)
{
	if(parseInt(obj.value)>parseInt(snums.innerHTML))
	{
		obj.value = snums.innerHTML;
	}
}
//立即购买
function dobuy()
{
	form.action = "order.php?type=1";
	form.submit();
}
//加入购物车
function docart()
{
	form.action = "do_shop.php";
	form.submit();
}
</script>