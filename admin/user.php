<?php
require_once"../config.php";
if(isset($_GET['uid']))
{
	extract($_GET);
	$sql ="select ifshow,admin from ts_user where uid=$uid";
	$arr = mysql_fetch_assoc(mysql_query($sql));
	$admin = $arr['admin'];
	$ifshow = $arr['ifshow'];

	if(isset($type))
	{
		if($type == 'ifshow')
		{
			if($ifshow==1)
			{
				$res =update(array('ifshow'=>0) ,'ts_user',"uid=$uid");
			}else if($ifshow == 0)
			{
				$res =update(array('ifshow'=>1) ,'ts_user',"uid=$uid");
			}
		}
		if($type == 'admin')
		{
			if($admin==1)
			{
				$res =update(array('admin'=>0) ,'ts_user',"uid=$uid");
			}else if($admin == 0)
			{
				$res =update(array('admin'=>1) ,'ts_user',"uid=$uid");
			}
		}
		if($res)
		{
			msg('修改成功', 'user.php');exit;
		}
	}
}
$page = 1;$num = 10;
$count = mysql_num_rows(mysql_query("select * from ts_user"));
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
$user = fetchAll("select * from ts_user order by uid desc limit $start,$num");
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
    <td background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"><span><img src='./skin/images/frame/arr3.gif' style='margin-right:10px;'>用户管理</span></td>
	<td align="right" background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="2">
	<?if($user){?>
		<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
			<tr align="center" bgcolor="#FBFCE2" height="25">
				<td width="6%">ID</td>
				<td width="25%">用户名</td>
				<td width="25	%">手机号</td>
				<td width="15%">邮箱</td>
				<td width="15%">启用/禁用</td>
				<td width="20%">管理员</td>
			</tr>
  <!-- data start-->
			<?foreach($user as $v){?>
			<tr align='center' bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
				<td nowrap><?=$v['uid']?></td>
				<td align='center'>
					<span id="arc<?=$v['uid']?>">
							<?=$v['username']?>
					</span>
				<td><?=$v['mobile']?></td>
				<td>
					<?=empty($v['email'])?  '暂无' : $v['email'];?>
				</td>
				<td>
					<a href="user.php?type=ifshow&uid=<?=$v['uid']?>">
						<?if($v['ifshow']==1){?>
							<font color='green'>启用</font>
						<?}else{?>
							<font color='blue'>禁用</font>
						<?}?>
					</a>
				</td>
				<td>
					<a href="user.php?type=admin&uid=<?=$v['uid']?>">
						<?if($v['admin']==1){?>
							<font color='red'>管理员</font>
						<?}else{?>
							普通用户
						<?}?>
					</a>
				</td>
			</tr>
			<?}?>
				</table>
				<?}?>
			</td>
		  </tr>
  <!-- data end-->
<!-- page start-->
  <? if(isset($page)){?>
  <tr align="right" bgcolor="#F9FCEF">
	<td height="36" colspan="10" align="center">
		<div class="pagelistbox">
			<span>共 <?=$max?> 页/<?=$count?>条记录 </span>
			<a class='indexPage' href="order.php?page=1">首页 </a>
			<? if($page>1){?>
			<a class='prevPage' href='order.php?page=<?=$page-1?>'>上页</a> 
			<? }?>
			<? 	for($i=1;$i<=$max;$i++){
				if($i==$page){
			?>
				<strong><?=$i?></strong>
			<? }else{?>	
				<a href="order.php?page=<?=$i?>"><?=$i?></a>
			
			<? }}if($page<$max){?>
			<a class='nextPage' href='order.php?page=<?=$page+1?>'>下页</a> 
			<? }?>
			<a class='endPage' href='order.php?page=<?=$max?>'>末页</a> 
			</div>
		</td>
  </tr>
  <? }?>
<!-- page end-->
</table>
</body>
</html>