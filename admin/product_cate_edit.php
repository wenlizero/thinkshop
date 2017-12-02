<?php
require_once"../config.php";
if(isset($_GET['pc_id']))
{
		$pc_id1 = $_GET['pc_id'];
}
//判断该分类下是否有子类:若有则不允许更改父级
$child = 0;//设置初始值
$sql = "select * from ts_product_cate where pc_fid=$pc_id1";
$res1 = fetchAll($sql);
if(is_array($res1) && count($res1)>0)
{
	$child = 1;//存在子类；
}
//查询本类信息
$sql = "select pc_fid,pc_name,pc_level from ts_product_cate  where pc_id=$pc_id1";
$res = mysql_query($sql);
if(is_resource($res) && mysql_num_rows($res)>0)
{
	$f_arr = mysql_fetch_assoc($res);
	$pc_fid = $f_arr['pc_fid'];
	$pc_name = $f_arr['pc_name'];
}
/*查询父类信息
if(isset($pc_fid))
{
	$sql = "select * from ts_product_cate  where pc_id=$pc_fid";
	$rec = mysql_query($sql);
	if(is_resource($rec) && mysql_num_rows($rec)>0)
	{
		$father = mysql_fetch_assoc($rec);
	}
}
*/
/*表单数据处理*/
if(isset($_POST['edit']))
{
	extract($_POST);//$show  $pc_id  $pc_name 
	if(isset($pc_fid))
	{
		$pc_name = trim($pc_name);
		//查询父级level
		$sql = "select pc_level from ts_product_cate where pc_id=$pc_fid";
		$res = mysql_query($sql);
		if(is_resource($res) && mysql_num_rows($res)>0)
		{
			$father_new = mysql_fetch_assoc($res);
		}
		$pc_level = $father_new['pc_level']+1;
		$array = array('pc_fid'=>$pc_fid ,'pc_name'=>$pc_name,'pc_level'=>$pc_level ,'pc_ifshow'=>$show);
		$result = update($array , 'ts_product_cate' , "pc_id=$pc_id1");
		if($result>0)
		{
			msg('修改成功','product_cate.php');exit;
		}
		else
		{
			msg('修改失败','product_cate.php');exit;
		}
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改商品分类</title>
<base target="_self">
<link rel="stylesheet" type="text/css" href="skin/css/base.css" />
<link rel="stylesheet" type="text/css" href="skin/css/main.css" />
</head>
<body leftmargin="8" topmargin='8'>
<table width="98%" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td background="skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' colspan="2"><span><img src='skin/images/frame/arr3.gif' style='margin-right:10px;'>修改商品分类</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>
	<form action="" method="post">
		<table style="margin-bottom:8px;margin-top:8px;margin-left:20px;">
			 <tr>
				<td width="100px;">上级分类:</td>
				<td>
					<select name="pc_fid">
					<option value=0>顶级分类</option>
					<?php
					if(isset($product_cate))
					{
						foreach($product_cate as $v)
							{
					?>
						<option <?php if($v['pc_id']==$pc_fid){echo "selected";} if($child>0){echo ' disabled';}?>  value="<?=$v['pc_id']?>"><?=str_repeat("&nbsp;",$v['pc_level']).$v['pc_name']?></option>
					<?php }}?>	
					</select>
				</td>
			  </tr>
			   <tr>
				 <td>分类名称:</td>
				 <td><input type="text" name="pc_name" value="<?=$pc_name?>"/></td>
			   </tr>
			   <tr>
				 <td>首页是否显示</td>
				 <td><input type="radio" name="show" value=1 checked >显示 <input type="radio" name="show" value=0 <? if($child>0){echo ' disabled';}?>> 不显示</td>
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