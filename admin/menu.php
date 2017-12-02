<html>
<head>
<title>menu</title>
<link rel="stylesheet" href="skin/css/base.css" type="text/css" />
<link rel="stylesheet" href="skin/css/menu.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language='javascript'>var curopenItem = '1';</script>
<script language="javascript" type="text/javascript" src="skin/js/frame/menu.js"></script>
<base target="main" />
</head>
<body target="main">
<table width='99%' height="100%" border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td style='padding-left:3px;padding-top:8px' valign="top">
	<!-- Item 1 Strat -->
      <dl class='bitem'>
        <dt onClick='showHide("items1_1")'><b>常用操作</b></dt>
        <dd style='display:block' class='sitem' id='items1_1'>
          <ul class='sitemu'>
			<!-- <li><a href='test_cate.php' target='main'>分类内页测试</a></li> -->
			<!-- <li><a href='test_list.php' target='main'>列表内页测试</a></li> -->
			<li><a href='sys_conf.php' target='main'>网站配置管理</a></li>
			<li><a href='news.php' target='main'>新闻管理</a></li>
			<li><a href='product.php' target='main'>商品管理</a></li>
			<!-- <li><a href='act_select.php' target='main'>活动管理</a></li> -->
			<li><a href='order.php' target='main'>订单管理</a></li>
			<li><a href='login_out.php' target='_top'>退出</a></li>
          </ul>
        </dd>
      </dl>
      <!-- Item 1 End -->
      <!-- Item 2 Strat -->
      <dl class='bitem'>
        <dt onClick='showHide("items2_1")'><b>新闻管理</b></dt>
        <dd style='display:block' class='sitem' id='items2_1'>
          <ul class='sitemu'>
            <li><a href='news_cate.php'  target='main'>新闻分类管理</a></li>
            <li><a href='news_cate_add.php' target='main'>添加新闻分类</a></li>
			<li><a href='news.php' target='main'>新闻管理</a></li>
			<li><a href='news_add.php' target='main'>添加新闻</a></li>
			<!-- <li><a href='help.php' target='main'>网站帮助</a></li> -->
          </ul>
        </dd>
      </dl>
      <!-- Item 2 End -->
	  <!-- Item 3 Strat -->
      <dl class='bitem'>
        <dt onClick='showHide("items3_1")'><b>商品管理</b></dt>
        <dd style='display:block' class='sitem' id='items3_1'>
          <ul class='sitemu'>
            <li><a href='product_cate.php' target='main'>商品分类管理</a></li>
            <li><a href='product_cate_add.php' target='main'>添加商品分类</a></li>
			<li><a href='product.php' target='main'>商品管理</a></li>
			<li><a href='product_add.php' target='main'>添加商品</a></li>
			<li><a href='comment.php' target='main'>评论管理</a></li>
          </ul>
        </dd>
      </dl>
      <!-- Item 3 End -->

	  <!-- Item 4 Strat -->
      <dl class='bitem'>
        <dt onClick='showHide("items4_1")'><b>订单管理</b></dt>
        <dd style='display:block' class='sitem' id='items4_1'>
          <ul class='sitemu'>
            <li><a href='order.php' target='main'>订单管理</a></li>
            <li><a href='order_search.php' target='main'>订单搜索</a></li>
			<li><a href='deliver.php' target='main'>发货管理</a></li>
          </ul>
        </dd>
      </dl>
      <!-- Item 4 End -->
     
	  <!-- Item 5 Strat -->
	  <dl class='bitem'>
        <dt onClick='showHide("items5_1")'><b>用户管理</b></dt>
        <dd style='display:block' class='sitem' id='items5_1'>
          <ul class='sitemu'>
            <li><a href='user.php' target='main'>用户管理</a></li>
          </ul>
        </dd>
      </dl>
      <!-- Item 4 End -->

	  </td>
  </tr>
</table>
</body>
</html>