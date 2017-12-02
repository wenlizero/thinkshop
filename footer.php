<?php
require_once"config.php";
$news_cate = fetchAll("select cname,cid from ts_news_cate where ifshow=1");
?>
		<!--底部代码  公用 start-->
		<div class="bottom">
			<div class="p-article">
			<?if($news_cate){$i=0;foreach($news_cate as $c){$i++;?>
				<div class='fl <?if ($i>1){echo 'p-ml250';}?>'>
					<h4 class='fl'><?=$c['cname']?></h4>	
					<?$news = fetchAll("select news_id,news_title from ts_news where news_cid=".$c['cid']);
					if($news){?>
					<ul style="clear:both">
						<?foreach($news as $n){?>
						<li><a href="news.php?nid=<?=$n['news_id']?>" class='p-art'><?=$n['news_title']?></a></li>
						<?}?>
					</ul>
					<?}?>
				</div>
			<?}}?>
			</div>
			<div class="foot">
				<ul>
					<li><a href="#">关于我们</a></li>
					<li>|<a href="#">法律声明</a></li>
					<li>|<a href="#">工作经验</a></li>
					<li>|<a href="#">联系我们</a></li>
				</ul>
				<div class="clear"></div>
				<p>Copyright©2008-2020 zendphp-edu.All Right Reserved 经营许可证编号：苏A-12345678</p>			
			</div>
		</div>
		<!--底部代码  公用 end-->