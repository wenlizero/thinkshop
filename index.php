<?php
include_once("config.php");
//初始化执行语句
$sql = "select * from ts_product where ifshow=1 ";
//关键字搜索
if(isset($_GET['search']) && !empty(trim($_GET['keywords'])))
{
	$keywords = trim($_GET['keywords']);
	$sql.=" and pname like '%$keywords%'  ";
}
//分类搜索：
if(isset($_GET['pc_id']))
{
	$pc_id = $_GET['pc_id'];
	$ids = getChildCate($pc_id);//4,10,11,13,7,8,9,
	$ids =  $ids . $pc_id ;
	$sql .= " and p_c_id in ($ids) ";//散列查询
}	
//分页
$page = 1;$num = 8;
$count = mysql_num_rows(mysql_query($sql));
$max = ceil($count/$num);
if(isset($_GET['page']))
{
	$page = $_GET['page'];
	if($page>$max)
	{
		$page = $max;
	}
	else if($page<1)
	{
		$page = 1;
	}
}
$start = ($page-1)*$num;
$sql .= " order by pid desc limit $start,$num ";
$goods_arr = fetchAll($sql);

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
		<?php require_once("header.php");?>
		<!--产品展示 start-->
		<div class="main">
			<div class="menu">
			<?if(isset($product_cate)){?>
				<ul>
					<li>分  类:</li>
					<?foreach($product_cate as $v){if($v['pc_ifshow']==1){?>
					<li><a href="index.php?pc_id=<?=$v['pc_id']?>"><?=$v['pc_name']?></a></li>
					<?}}?>
				</ul>
			<?}?>
			</div>
			<div class="product">
			<?php 
			if($goods_arr)
			{
				foreach($goods_arr  as $v)
				{
			?>
				<div class="pro">
					<a href="product.php?pid=<?=$v['pid']?>"><img src="admin/<?=$v['thumb']?>" alt="<?=$v['pname']?>" title="<?=$v['pname']?>"></a>
					<div class="pn"><a href="product.php?pid=<?=$v['pid']?>" class="pname"><?=$v['pname']?></a></div>
					<div class="price">
						<strike> &yen; <?=$v['price']?></strike>
						<span> &yen; <?=$v['sprice']?></span>
					</div>
				</div>
			<?php  }}   ?>
				<div class="clear"></div>
			</div>
		</div>
		<!--产品展示 end-->
		<!--页面列表 start-->
		<?if(isset($page)){?>
		<div class="pages">
			<div class="page">
				<ul>
				<!--组装查询条件-->
				<?php
				if(isset($_GET))
				{
					extract($_GET);$str ='';
					if(isset($keywords))
					{
						$str .= "&keywords=$keywords";
					}
					if(isset($pc_id))
					{
						$str .= "&pc_id=$pc_id";
					}
				}
				?>
					<?if($page>1){?>
					<li><a class='p-prev' href="index.php?page=<?=$page-1 .$str?>">上一页</a></li>
					<?}?>
					<?for($i=1;$i<=$max;$i++){if($i==$page){?>
					<li ><a  class='page-on'><?=$i?></a></li>
					<?}else{?>
					<li ><a  class='p-prev' href="index.php?page=<?=$i.$str?>"><?=$i?></a></li>
					<?}}if($page<$max){?>
					<li><a class='p-prev'  href="index.php?page=<?=$page+1 .$str?>">下一页</a></li>
					<?}?>
				</ul>			
			</div>
			<!-- <div class="clear"></div> -->
		</div>
		<?}?>
		<!--页面列表 end-->
		<!--配送方式 start-->
		<div class="state">
				<div class="state_l">
					<ul>
						<li><span>7</span>日免费退货</li>
						<li><span>15</span>日免费更换</li>
						<li><span>全场</span>包邮</li>
						<li><span>全国</span>范围均可配送</li>					
					</ul>
				</div>
				<div class="state_r">
					<ul>
						<li><a href="#">支付方式</a></li>
						<li>|<a href="#">配送说明</a></li>
						<li>|<a href="#">售后服务</a></li>					
					</ul>
				</div>
				<div class="clear"></div>
			</div>
		<!--配送方式 end-->
		<?php require_once("footer.php");?>
	</body>
</html>