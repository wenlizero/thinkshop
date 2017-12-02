<?php
require_once('../config.php');
if( isset($_GET['id']))
{
	$id = $_GET['id'];
	$sql = "select * from ts_sysconfig where sys_id = $id";
	$res = mysql_query($sql);
	if(is_resource($res) && mysql_num_rows($res)==1 )
	{
		$arr = mysql_fetch_assoc($res);
	}
	else
	{
		echo mysql_error();
	}
}
//print_r($arr);
//数据修改入库
if( isset($_POST['edit']))
{
	extract($_POST);
	$sys_title = trim($sys_title);
	$sys_name = trim($sys_name);
	$sys_val = trim($sys_val);
	$sys_type = trim($sys_type);
	$sql = "update ts_sysconfig set sys_title='$sys_title',sys_name='$sys_name',sys_val ='$sys_val', sys_type='$sys_type' where sys_id = $id";

	mysql_query($sql);
	if(mysql_affected_rows() == 1)
	{
		msg('修改成功','sys_conf.php');
	}
	else
	{
		msg('修改失败','sys_conf.php');
	}
}

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
    <td background="skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' colspan="2"><span><img src='skin/images/frame/arr3.gif' style='margin-right:10px;'>修改配置项</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>
	<?php if( isset($_GET['id']) && isset($arr)){ ?>
		<form action="" method="post">
		<table style="margin-bottom:8px;margin-top:8px;margin-left:20px;">
			 <tr>
				<td width="100px;">配置项标题:</td>
				<td><input type="text" name="sys_title" value="<?=$arr['sys_title']?>" placeholder="如: 网站名称"/></td>
			  </tr>
			   <tr>
				 <td>配置项名称:</td>
				 <td><input type="text"name="sys_name" value="<?=$arr['sys_name']?>" placeholder="请输入英文名称"/></td>
			   </tr>
			   <tr>
				 <td>配置项内容:</td>
				 <td>
				 <?if($arr['sys_type']=='text'){?>
				 <input type="text"name="sys_val" value="<?=$arr['sys_val']?>" placeholder="如:欣才商城"/>
				 <?}else{?>
				 <textarea name="sys_val" id="" cols="30" rows="10"><?=$arr['sys_val']?></textarea>
				 <?}?>
				 </td>
			   </tr>
			   <tr>
				 <td>配置项类型:</td>
				 <td>
					<input type="radio" name="sys_type" value="text" id="txt" <?= $arr['sys_type']=='text' ? 'checked' : '';?>/>
					<label for="txt">文本框</label>

					<input type="radio" name="sys_type" value="textarea" id="area"<?php echo $arr['sys_type']=='textarea' ? 'checked' : '';?>/>
					<label for="area">文本域</label>
				 </td>
			   </tr>
			   <tr>
				 <td colspan="2" align="center" height="40px"><input type="submit" name="edit" value=" 修改 " class="coolbt2"></td>
			   </tr>
		</table>
		</form>
		<?php } ?>
	</td>
  </tr>
</table>
</body>
</html>