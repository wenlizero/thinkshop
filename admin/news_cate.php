<?php
require_once"../config.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主体部分</title>
<base target="_self">
<link rel="stylesheet" type="text/css" href="skin/css/base.css" />
<link rel="stylesheet" type="text/css" href="skin/css/main.css" />
</head>
<body leftmargin="8" topmargin='8'>
<table width="98%" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"><span><img src='./skin/images/frame/arr3.gif' style='margin-right:10px;'>新闻分类管理</span></td>
	<td align="right" background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"><a href="news_cate_add.php">添加新闻分类</a>&nbsp;&nbsp;</td>
  </tr>
  <? if(isset($news_cate)){?>
  <tr bgcolor="#FFFFFF">
    <td colspan="2">
		<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
			<tr align="center" bgcolor="#FBFCE2" height="25">
				<td width="6%">ID</td>
				<td width="28%">分类名</td>
				<td width="28%">分类等级</td>
				<td width="28%">是否显示</td>
				<td width="10%">操作</td>
			</tr>
  <!-- data start-->
			<? foreach($news_cate as $v){?>
			<tr align='center' bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
				<td nowrap><?=$v['cid']?></td>
				<td align='left'>
					<span id="arc<?=$v['cid']?>"><?=str_repeat("&nbsp;&nbsp;",$v['level']).$v['cname']?></span>
				</td>
				<td><?=$v['level']?></td>
				<td><a href="javascript:changeStatus(<?=$v['cid'].','.$v['ifshow']?>)"><?= $v['ifshow']==1 ? '显示' : '隐藏'?></a></td>
				<td>
					<?if($v['cid']>1){?>
					<a href='news_cate_edit.php?cid=<?=$v['cid']?>' target='main'><img src='./skin/images/frame/trun.gif' title="编辑" alt="编辑" style='cursor:pointer' border='0' width='16' height='16' /></a>
					<a href='news_cate_del.php?cid=<?=$v['cid']?>' target='main'><img src='./skin/images/frame/gtk-del.png' title="删除" alt="删除" style='cursor:pointer' border='0' width='16' height='16' /></a>
					<?}?>
					<a href='news_cate_add.php?cid=<?=$v['cid']?>' target='main'><img src='./skin/images/frame/gtk-sadd.png' title="添加" alt="添加" style='cursor:pointer' border='0' width='16' height='16' /></a>
				</td>
			</tr>
			<? }?>
			</table>
			</td>
		  </tr>
  <!-- data end-->
  <? }?>
</table>
</body>
</html>
<script type="text/javascript">
/*修改显示状态*/
function changeStatus(id,ifshow)
{
	var table = 'ts_news_cate';
	location.href = 'change.php?id='+id+'&ifshow='+ifshow+'&table='+table;
}
</script>