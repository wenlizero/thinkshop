<?php
require_once"../config.php";
//添加子类：
$pc_id1=0;
if(isset($_GET['pc_id']))
{
	$pc_id1 = $_GET['pc_id'];
}
//数据的添加
if(isset($_POST['add']))
{
	extract($_POST);//$show  $pc_id  $pc_name $add
	if(isset($pc_id))
	{
		$sql = "select pc_level from ts_product_cate where pc_id=$pc_id";
		$res = mysql_query($sql);
		if(is_resource($res) && mysql_num_rows($res)>0)
		{
			$arr1 = mysql_fetch_assoc($res);
			$level = $arr1['pc_level'];
			$pc_level = $level+1;
		}
		//pc_level  pc_fid  show pc_name
		$pc_name = trim($pc_name);
		$array = array('pc_fid'=>$pc_id ,'pc_name'=>$pc_name,'pc_level'=>$pc_level ,'pc_ifshow'=>$show);
		$result = insert($array , 'ts_product_cate');
		if($result>0)
		{
			msg('添加成功','product_cate.php');exit;
		}
		else
		{
			msg('添加失败','product_cate_add.php');exit;
		}
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加商品分类</title>
<base target="_self">
<link rel="stylesheet" type="text/css" href="skin/css/base.css" />
<link rel="stylesheet" type="text/css" href="skin/css/main.css" />
</head>
<body leftmargin="8" topmargin='8'>
<table width="98%" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td background="skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' colspan="2"><span><img src='skin/images/frame/arr3.gif' style='margin-right:10px;'>添加商品分类</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>
	<form action="" method="post">
		<table style="margin-bottom:8px;margin-top:8px;margin-left:20px;">
			 <tr>
				<td width="100px;">上级分类:</td>
				<td>
					<select name="pc_id">
					<option value=0>顶级分类</option>
					<?php
						if(isset($product_cate))
						{
							foreach($product_cate as $v)
							{
					?>
						<option <?php if($v['pc_id']==$pc_id1){echo "selected";}?>  value="<?=$v['pc_id']?>">
						<?=str_repeat("&nbsp;",$v['pc_level']).$v['pc_name']?>
						</option>
						<?php }}?>
					</select>
				</td>
			  </tr>
			   <tr>
				 <td>分类名称:</td>
				 <td><input type="text" name="pc_name"/></td>
			   </tr>
			   <tr>
				 <td>首页是否显示</td>
				 <td><input type="radio" name="show" value="1" checked>显示 <input type="radio" name="show" value="0"> 不显示</td>
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