<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>顶部</title>
<link href="skin/css/base.css" rel="stylesheet" type="text/css">
<script language='javascript'>
var preFrameW = '206,*';
var FrameHide = 0;
var curStyle = 1;
var totalItem = 5;
function ChangeMenu(way){
	var addwidth = 10;
	var fcol = top.document.all.btFrame.cols;
	if(way==1) addwidth = 10;
	else if(way==-1) addwidth = -10;
	else if(way==0){
		if(FrameHide == 0){
			preFrameW = top.document.all.btFrame.cols;
			top.document.all.btFrame.cols = '0,*';
			FrameHide = 1;
			return;
		}else{
			top.document.all.btFrame.cols = preFrameW;
			FrameHide = 0;
			return;
		}
	}
	fcols = fcol.split(',');
	fcols[0] = parseInt(fcols[0]) + addwidth;
	top.document.all.btFrame.cols = fcols[0]+',*';
}


function mv(selobj,moveout,itemnum)
{
   if(itemnum==curStyle) return false;
   if(moveout=='m') selobj.className = 'itemsel';
   if(moveout=='o') selobj.className = 'item';
   return true;
}

function changeSel(itemnum)
{
  curStyle = itemnum;
  for(i=1;i<=totalItem;i++)
  {
     if(document.getElementById('item'+i)) document.getElementById('item'+i).className='item';
  }
  document.getElementById('item'+itemnum).className='itemsel';
}

</script>
<style>
body { padding:0px; margin:0px;}
#tpa {
	color: #009933;
	margin:0px;
	padding:0px;
	float:right;
	padding-right:10px;
}

#tpa dd {
	margin:0px;
	padding:0px;
	float:left;
	margin-right:2px;
}

#tpa dd.ditem {
	margin-right:8px;
}

#tpa dd.img {
  padding-top:6px;
}

div.item
{
  text-align:center;
	background:url(skin/images/frame/topitembg.gif) 0px 3px no-repeat;
	width:82px;
	height:26px;
	line-height:28px;
}

.itemsel {
  width:80px;
  text-align:center;
  background:#226411;
	border-left:1px solid #c5f097;
	border-right:1px solid #c5f097;
	border-top:1px solid #c5f097;
	height:26px;
	line-height:28px;
}

*html .itemsel {
	height:26px;
	line-height:26px;
}

a:link,a:visited {
 text-decoration: underline;
}

.item a:link, .item a:visited {
	font-size: 12px;
	color: #ffffff;
	text-decoration: none;
	font-weight: bold;
}

.itemsel a:hover {
	color: #ffffff;
	font-weight: bold;
	border-bottom:2px solid #E9FC65;
}

.itemsel a:link, .itemsel a:visited {
	font-size: 12px;
	color: #ffffff;
	text-decoration: none;
	font-weight: bold;
}

.itemsel a:hover {
	color: #ffffff;
	border-bottom:2px solid #E9FC65;
}

.rmain {
  padding-left:10px;
  padding-right:50px;
  /* background:url(skin/images/frame/toprightbg.gif) no-repeat; */
}
</style>
</head>
<body bgColor='#ffffff'>
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="skin/images/frame/topbg.gif">
  <tr>
    <td width='20%' height="60"><img src="skin/images/frame/logo.gif" /></td>
    <td width='80%' align="right" valign="bottom">
    	<table width="1000" border="0" cellspacing="0" cellpadding="0">
      <tr>
      <td align="right" height="26" style="padding-right:60px;line-height:26px;">
			<?if(isset($_COOKIE['admin_username'])){?>
        	您好：<span class="username" style="color:red;"><?=$_COOKIE['admin_username']?></span>，欢迎进入欣才商城后台管理系统
        	[<a href="../index.php" target="_blank">网站主页</a>]
        	[<a href="login_out.php" target="_top">退出</a>]&nbsp;
			<?}else{?>
			[<a href="admin_login.php" target="_blank">登录</a>]
			<?}?>
      </td>
      </tr>
      <tr>
        <td align="right" height="34" class="rmain">
		<dl id="tpa">
		<dd class='img'><a href="javascript:ChangeMenu(-1);"><img vspace="5" src="skin/images/frame/arrl.gif" border="0" width="5" height="8" alt="缩小左框架"  title="缩小左框架" /></a></dd>
		<dd class='img'><a href="javascript:ChangeMenu(0);"><img vspace="3" src="skin/images/frame/arrfc.gif" border="0" width="12" height="12" alt="显示/隐藏左框架" title="显示/隐藏左框架" /></a></dd>
		<dd class='img' style="margin-right:10px;"><a href="javascript:ChangeMenu(1);"><img vspace="5" src="skin/images/frame/arrr.gif" border="0" width="5" height="8" alt="增大左框架" title="增大左框架" /></a></dd>
		<dd><div class='itemsel' id='item1' onMouseMove="mv(this,'move',1);" onMouseOut="mv(this,'o',1);"><a href="main.php" onclick="changeSel(1)" target="main">主菜单</a></div></dd>
		<dd><div class='item' id='item2' onMouseMove="mv(this,'m',2);" onMouseOut="mv(this,'o',2);"><a href="news.php" onclick="changeSel(2)" target="main">新闻管理</a></div></dd>
		<dd><div class='item' id='item3' onMouseMove="mv(this,'m',3);" onMouseOut="mv(this,'o',3);"><a href="product.php" onclick="changeSel(3)" target="main">商品管理</a></div></dd>
		<dd><div class='item' id='item4' onMouseMove="mv(this,'m',4);" onMouseOut="mv(this,'o',4);"><a href="order.php" onclick="changeSel(4)" target="main">订单管理</a></div></dd>
		<dd><div class='item' id='item5' onMouseMove="mv(this,'m',5);" onMouseOut="mv(this,'o',5);"><a href="comment.php" onclick="changeSel(5)" target="main">评论管理</a></div></dd>
		</dl>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>