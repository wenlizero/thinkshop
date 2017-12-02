<?php
require_once"../config.php";
if(isset($_GET['cid']))
{
		$cid1 = $_GET['cid'];
}
//判断该分类下是否有子类:若有则不允许更改父级以及不显示
$child = 0;
$sql = "select * from ts_news_cate where fid=$cid1";
$res1 = fetchAll($sql);
if(is_array($res1) && count($res1)>0)
{
	$child = 1;//存在子类；
}
//查询本类信息
$sql = "select fid,cname,level from ts_news_cate  where cid=$cid1";
$res = mysql_query($sql);
if(is_resource($res) && mysql_num_rows($res)>0)
{
	$f_arr = mysql_fetch_assoc($res);
	$fid = $f_arr['fid'];
	$cname = $f_arr['cname'];
}
//查询父类信息
if(isset($fid))
{
	$sql = "select * from ts_news_cate  where cid=$fid";
	$rec = mysql_query($sql);
	if(is_resource($rec) && mysql_num_rows($rec)>0)
	{
		$father = mysql_fetch_assoc($rec);
	}
}
/*表单数据处理*/
if(isset($_POST['edit']))
{
	extract($_POST);//$ifshow  $cid  $cname 
	if(isset($fid))
	{
		$cname = trim($cname);
		if($fid>0)
		{
			//查询父级level
			$sql = "select level from ts_news_cate where cid=$fid";
			$res = mysql_query($sql);
			if(is_resource($res) && mysql_num_rows($res)>0)
			{
				$father_new = mysql_fetch_assoc($res);
			}
			$level = $father_new['level']+1;
		}elseif($fid == 0){
			$level = 1;
		}
		$array = array('fid'=>$fid ,'cname'=>$cname,'level'=>$level ,'ifshow'=>$ifshow);
		$result = update($array , 'ts_news_cate' , "cid=$cid1");
		if($result>0)
		{
			msg('修改成功','news_cate.php');exit;
		}
		else
		{
			msg('修改失败','news_cate.php');exit;
		}
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改新闻分类</title>
<base target="_self">
<link rel="stylesheet" type="text/css" href="skin/css/base.css" />
<link rel="stylesheet" type="text/css" href="skin/css/main.css" />
</head>
<body leftmargin="8" topmargin='8'>
<table width="98%" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td background="skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' colspan="2"><span><img src='skin/images/frame/arr3.gif' style='margin-right:10px;'>修改新闻分类</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>
	<form action="" method="post">
		<table style="margin-bottom:8px;margin-top:8px;margin-left:20px;">
			 <tr>
				<td width="100px;">上级分类:</td>
				<td>
					<select name="fid">
					<option value=0>顶级分类</option>
					<?php
					if(isset($news_cate))
					{
						foreach($news_cate as $v)
							{
					?>
						<option <?php if($v['cid']==$fid){echo "selected";} if($child>0){echo ' disabled';}?>  value="<?=$v['cid']?>"><?=str_repeat("&nbsp;",$v['level']).$v['cname']?></option>
					<?php }}?>	
					</select>
				</td>
			  </tr>
			   <tr>
				 <td>分类名称:</td>
				 <td><input type="text" name="cname" value="<?=$cname?>"/></td>
			   </tr>
			   <tr>
				 <td>首页是否显示</td>
				 <td><input type="radio" name="ifshow" value=1 <? if($v['ifshow']==1){echo 'checked';}?> >显示 <input type="radio" name="ifshow" value=0  <? if($v['ifshow']==0){echo 'checked';} if($child>0){echo ' disabled';}?>> 不显示</td>
			   </tr>
			   <tr>
				 <td colspan="2" align="center" height="40px"><input type="submit" value=" 修改 " class="coolbt2" name="edit"></td>
			   </tr>
		</table>
	</form>
	</td>
  </tr>
</table>
</body>
</html>