<?php
require_once"../config.php";
$page = 1;$num = 10;
$count = mysql_num_rows(mysql_query("select * from ts_news"));
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
$news = fetchAll("select * from ts_news order by news_id desc limit $start,$num");
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
    <td background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"><span><img src='./skin/images/frame/arr3.gif' style='margin-right:10px;'>新闻管理</span></td>
	<td align="right" background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="2">
	<?if($news){?>
		<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
			<tr align="center" bgcolor="#FBFCE2" height="25">
				<td width="6%">ID</td>
				<td width="4%">选择</td>
				<td width="28%">文章标题</td>
				<td width="10%">更新时间</td>
				<td width="10%">类目</td>
				<td width="8%">点击量</td>
				<td width="8%">发布人</td>
				<td width="10%">操作</td>
			</tr>
  <!-- data start-->
  <?foreach($news as $v){?>
			<tr align='center' bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
				<td nowrap><?=$v['news_id']?></td>
				<td>
					<input name="arcID" type="checkbox" id="arcID" value="<?=$v['news_id']?>" class="np" />
				</td>
				<td align='left'>
					<span id="arc<?=$v['news_id']?>">
						<a href=''>
							<u><?=$v['news_title']?></u>
						</a>
					</span>
					<?if(!empty($v['news_img'])){?>
					[<font color='red'>图片</font>]		
					<?}?>
				</td>
				<td><?=date('Y-m-d H:m:s',$v['news_pubtime'])?></td>
				<td><a href=''><?php
				$sql='select cname from ts_news_cate where cid='.$v['news_cid'];
				$ress = mysql_fetch_assoc(mysql_query($sql));
				echo $ress['cname'];
				?></a></td>
				<td><?=$v['news_click']?></td>
				<td><?=$v['news_author']?></td>
				<td>
					<a href='news_edit.php?news_id=<?=$v['news_id']?>' target='main'><img src='./skin/images/frame/trun.gif' title="编辑" alt="编辑"  style='cursor:pointer' border='0' width='16' height='16' /></a>
					<a href='news_del.php?news_id=<?=$v['news_id']?>' target='main'><img src='./skin/images/frame/gtk-del.png' title="删除" alt="删除"  style='cursor:pointer' border='0' width='16' height='16' /></a>
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
				<a class='indexPage' href="news.php?page=1">首页 </a>
				<? if($page>1){?>
				<a class='prevPage' href='news.php?page=<?=$page-1?>'>上页</a> 
				<? }?>
				<? 	for($i=1;$i<=$max;$i++){
					if($i==$page){
				?>
					<strong><?=$i?></strong>
				<? }else{?>	
					<a href="news.php?page=<?=$i?>"><?=$i?></a>
				
				<? }}if($page<$max){?>
				<a class='nextPage' href='news.php?page=<?=$page+1?>'>下页</a> 
				<? }?>
				<a class='endPage' href='news.php?page=<?=$max?>'>末页</a> 
				</div>
			</td>
	  </tr>
	  <? }?>
  <!-- page end-->
  <?}?>
  <tr>
	<td colspan="2"><input type='button' class="coolbg np" onClick="location='news_add.php';" value='添加新闻'/></td>
  </tr>
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
		location.href="news_del.php?ids="+str;
	}
}
</script>