<?php
require_once"../config.php";
//删除评论
if(isset($_GET['type']))
{
	extract($_GET);
	//单个删除
	if($type == 'del' && isset($msg_id))
	{
		$res = delete('ts_message' ,"msg_id=$msg_id");
	}
	//多选删除
	if($type == 'delSel' && isset($ids))
	{
		$res = delete('ts_message' ,"msg_id in ($ids)");
	}
	if($res)
	{
		msg('删除成功','comment.php');exit;
	}
}
//展示所有评论
$page = 1;$num = 10;
$count = mysql_num_rows(mysql_query("select * from ts_message "));
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
$message = fetchAll("select m.*,u.username from ts_message as m,ts_user as u where m.user_id=u.uid order by  msg_id desc limit $start,$num");
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
    <td background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"><span><img src='./skin/images/frame/arr3.gif' style='margin-right:10px;'>评论管理</span></td>
	<td align="right" background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="2">
	<?if($message){?>
		<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
			<tr align="center" bgcolor="#FBFCE2" height="25">
				<td width="6%">ID</td>
				<td width="4%">选择</td>
				<td width="8%">评论等级</td>
				<td width="10%">评论时间</td>
				<td width="28%">评论内容</td>
				<td width="8%">评论人</td>
				<td width="10%">操作</td>
			</tr>
  <!-- data start-->
  <?foreach($message as $v){?>
			<tr align='center' bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
				<td nowrap><?=$v['msg_id']?></td>
				<td>
					<input name="arcID" type="checkbox" id="arcID" value="<?=$v['msg_id']?>" class="np" />
				</td>
				<td align='center'>
					<span id="arc<?=$v['msg_id']?>">
						<a href=''>
							<font color='red'><?if($v['msg_start']==1){echo '差评';}elseif($v['msg_start']==2){echo '中评';}else{echo '好评';}?></font>
						</a>
					</span>
				</td>
				<td><?=date('Y-m-d H:m:s',$v['msg_time'])?></td>
				<td><?=$v['msg_content']?></td>
				<td><?=$v['username']?></td>
				<td>
				<a href='comment.php?type=del&msg_id=<?=$v['msg_id']?>' target='main'><img src='./skin/images/frame/gtk-del.png' title="删除" alt="删除"  style='cursor:pointer' border='0' width='16' height='16' /></a>
				</td>
			</tr>  <?}?>
				</table>
			</td>
		  </tr>

  <!-- data end-->
  <!-- select start-->
	  <tr bgcolor="#ffffff">
		<td height="36" colspan="10">
			<a href="javascript:selAll()" class="coolbg">全选</a>
			<a href="javascript:noSelAll()" class="coolbg">取消</a>
			<a href="javascript:updateArc(0)" class="coolbg">反选</a>
			<a href="javascript:selDel()" class="coolbg">删除</a><!--一次性删除选中的-->
		</td>
	  </tr>
  <!-- select end-->
  <!-- page start-->
	  <? if(isset($page)){?>
	  <tr align="right" bgcolor="#F9FCEF">
		<td height="36" colspan="10" align="center">
			<div class="pagelistbox">
				<span>共 <?=$max?> 页/<?=$count?>条记录 </span>
				<a class='indexPage' href="comment.php?page=1">首页 </a>
				<? if($page>1){?>
				<a class='prevPage' href='comment.php?page=<?=$page-1?>'>上页</a> 
				<? }?>
				<? 	for($i=1;$i<=$max;$i++){
					if($i==$page){
				?>
					<strong><?=$i?></strong>
				<? }else{?>	
					<a href="comment.php?page=<?=$i?>"><?=$i?></a>
				
				<? }}if($page<$max){?>
				<a class='nextPage' href='comment.php?page=<?=$page+1?>'>下页</a> 
				<? }?>
				<a class='endPage' href='comment.php?page=<?=$max?>'>末页</a> 
				</div>
			</td>
	  </tr>
	  <? }?>
  <!-- page end-->
  <?}?>
</table>
</body>
</html>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
/*删除选中：id   :   1,2,3,4  */
arr = document.getElementsByName('arcID');
function selDel()
{
	str = '';
	for(var i=0;i<arr.length;i++)
	{
		if(arr[i].type == 'checkbox')
		{
			if(arr[i].checked == true)
			{
				str += arr[i].value+','; //由选中id组成的字符串
			}
		}
	}
	if(str !='')
	{
		var res = confirm("确定删除？");
	}
	if(res)
	{
		location.href="comment.php?type=delSel&ids="+str;
	}
}
</script>