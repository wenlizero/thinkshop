<?php
include_once("config.php");
$news_cate = fetchAll("select cname,cid from ts_news_cate where ifshow=1");
if(isset($_GET['nid']))
{	
	$nid = $_GET['nid'];
	//查询原点击量
	$sql = "select news_click from ts_news where news_id=$nid";
	$click = mysql_fetch_assoc(mysql_query($sql));
	//更新点击量
	update(array('news_click'=>$click['news_click']+1) , 'ts_news',"news_id=$nid");
	//查询新闻详情
	$sql = "select * from ts_news where news_id=$nid";
	$news = mysql_fetch_assoc(mysql_query($sql));
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
	<body id='bd'>
		<?php require_once("header.php");?>
		<!--产品展示 start-->
		<div class="main">
			<div class="menu">
				<ul>
					<li>当前:</li>
					<li><a href="user.php">新闻中心</a></li>
				</ul>
			</div>
			<div class="ts-user">
				<div class="u-l fl">
				<?if($news_cate){$i=0;foreach($news_cate as $c){?>
					<div class='u-div'><a href="javascript:onclick= show(<?=$c['cid']?>)"><?=$c['cname']?></a></div>
					<div id='news<?=$c['cid']?>' style="display:none;">
					<?$child = fetchAll("select news_id,news_title from ts_news where news_cid=".$c['cid']);
					if($child){?>
						<ul>
							<?foreach($child as $n){?>
							<li><a href="news.php?nid=<?=$n['news_id']?>" class='u-child'><?=$n['news_title']?></a></li>
							<?}?>
						</ul>
					<?}?>
					</div>
				<?}}?>
				</div>
				<div class='u-r fl' style="width:78%;padding:8px;">
				<?if($news){?>
					<h2 align='center' class='u-wel'><?=$news['news_title']?></h2>	
					<span>作者：<?=$news['news_author']?></span>
					<br /><br />
					<span>点击量：<?=$news['news_click']?>次</span>
					<br /><br />
					<div>
						<?=$news['news_content']?>
					</div>
					<br />
					<?}?>
				</div>
				</div>
			</div>
		</div>
		<!--产品展示 end-->
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
<script type="text/javascript">
function show(nid)
{
	news = document.getElementById('news'+nid);
	if(news.style.display == 'none')
	{
		news.style.display = 'block';
	}
	else
	{
		news.style.display = 'none';
	}
}
</script>