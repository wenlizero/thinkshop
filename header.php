	<!--头部代码  公用 start-->
		<div class="header">
			<div class="top">
				<div class="top_l">
					<ul>
						<li><a href="index.php">网站首页</a></li>
						<li><a href="user.php">用户中心</a></li>
						<?php
						$cartNum = 0;$orderNum = 0;
						if(isset($_COOKIE['username']))
						{
							//购物车数量
							$res = mysql_query('select * from ts_cart where user_id='.$_COOKIE['user_id']);
							if(is_resource($res))
							{
								$cartNum = mysql_num_rows($res);
							}
							//订单数量
							$res = mysql_query('select * from ts_order where user_id='.$_COOKIE['user_id']);
							if(is_resource($res))
							{
								$orderNum = mysql_num_rows($res);
							}
						}
						?>
						<li><a href="shopcar.php">我的购物车(<?=$cartNum?>)</a></li>
						<li><a href="user.php?type=order">我的订单(<?=$orderNum?>)</a></li>
					</ul>
				</div>
				<div class="top_r">
					欢迎来到欣才商城！
					<?if(isset($_COOKIE['username'])){?>
					<a href="user.php">您好，<?=$_COOKIE['username']?></a>&nbsp;&nbsp;<a href="loginout.php">|退出</a>
					<?}else{?>
					&nbsp;|&nbsp;<a href="login.php">登陆</a>&nbsp;|&nbsp;<a href="regist.php">免费注册</a>
					<?}?>
				</div>
			</div>
			<div class="logo">
				<div class="logo_main">
					<div class="logo_font">
						<font class="logo_x">欣才</font>
						<font>商城</font>
					</div>
					<div class="logo_ss">
						<form action="" method="get" name="searchForm">
						<input type="text" name="keywords" class="search" value="">
						<input type="submit" name="search" class="sou" value="搜索">
						</form>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="nav">
				<ul>
					<li><a href="index.php">首页</a></li>
					<li>|<a href="index.php">商城</a></li>
					<li>|<a href="news.php?nid=12">新闻</a></li>
					<li>|<a href="#">活动</a></li>
					<li>|<a href="#">论坛</a></li>
					<div class="clear"></div>
				</ul>
			</div>
		</div>
		<!--头部代码  公用 end-->