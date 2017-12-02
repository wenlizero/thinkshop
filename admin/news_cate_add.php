<?php
require_once"../config.php";
//添加子类：
$cid1=0;
if(isset($_GET['cid']))
{
	$cid1 = $_GET['cid'];
}
//数据的添加
if(isset($_POST['add']))
{
	extract($_POST);//$ifshow  $cid  $cname $add
	if(isset($cid))
	{
		if($cid >0)
		{
			$sql = "select level from ts_news_cate where cid=$cid";
			$res = mysql_query($sql);
			if(is_resource($res) && mysql_num_rows($res)>0)
			{
				$arr1 = mysql_fetch_assoc($res);
				$level_f = $arr1['level'];
				$level = $level_f+1;
			}
		}
		else
		{
			$level = 1;
		}
		//level  cfid  ifshow cname
		$cname = trim($cname);
		$array = array('fid'=>$cid ,'cname'=>$cname,'level'=>$level ,'ifshow'=>$ifshow);
		$result = insert($array , 'ts_news_cate');
		if($result>0)
		{
			msg('添加成功','news_cate.php');exit;
		}
		else
		{
			msg('添加失败','news_cate.php');exit;
		}
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加新闻分类</title>
<base target="_self">
<link rel="stylesheet" type="text/css" href="skin/css/base.css" />
<link rel="stylesheet" type="text/css" href="skin/css/main.css" />
</head>
<body leftmargin="8" topmargin='8'>
<table width="98%" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td background="skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' colspan="2"><span><img src='skin/images/frame/arr3.gif' style='margin-right:10px;'>添加新闻分类</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>
	<form action="" method="post">
		<table style="margin-bottom:8px;margin-top:8px;margin-left:20px;">
			 <tr>
				<td width="100px;">上级分类:</td>
				<td>
					<select name="cid">
					<option value=0>顶级分类</option>
					<?php
						if(isset($news_cate))
						{
							foreach($news_cate as $v)
							{
					?>
						<option <?php if($v['cid']==$cid1){echo "selected";}?>  value="<?=$v['cid']?>">
						<?=str_repeat("&nbsp;",$v['level']).$v['cname']?>
						</option>
						<?php }}?>
					</select>
				</td>
			  </tr>
			   <tr>
				 <td>分类名称:</td>
				 <td><input type="text" name="cname"/></td>
			   </tr>
			   <tr>
				 <td>首页是否显示</td>
				 <td><input type="radio" name="ifshow" value="1" checked>显示 <input type="radio" name="ifshow" value="0"> 不显示</td>
			   </tr>
			   <tr>
				 <td colspan="2" align="center" height="40px"><input type="submit" value=" 添加 " class="coolbt2" name="add"></td>
			   </tr>
		</table>
	</form>
	</td>
  </tr>
</table>
</body>
</html>