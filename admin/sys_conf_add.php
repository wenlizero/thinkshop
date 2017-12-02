<?php
require_once('../config.php');
//通过表单提交数据
if(isset($_POST['add']))
{
	extract($_POST);
	$sys_title = trim($sys_title);
	$sys_name = trim($sys_name);
	$sys_val = trim($sys_val);
	$sys_type = trim($sys_type);
	//先判断该配置项名称是否已存在,若存在则不许添加,否则配置项重复
	$sql = "select * from ts_sysconfig where sys_name='$sys_name' or sys_title='$sys_title'" ;
	$res = mysql_query($sql);
	if(is_resource($res) && mysql_num_rows($res)>0)
	{
		msg('该配置项名称已存在' , "sys_conf_add.php");
	}
	else
	{
		$sql = "insert into ts_sysconfig(sys_title,sys_name,sys_val,sys_type)value('$sys_title','$sys_name','$sys_val' , '$sys_type')";
		mysql_query($sql);
		if(mysql_affected_rows() ==1 )
		{
			msg('添加成功','sys_conf.php');
		}
		else
		{
			msg('添加失败','sys_conf_add.php');
		}
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
    <td background="skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' colspan="2"><span><img src='skin/images/frame/arr3.gif' style='margin-right:10px;'>添加配置项</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>
		<form action="" method="post">
		<table style="margin-bottom:8px;margin-top:8px;margin-left:20px;">
			 <tr>
				<td width="100px;">配置项标题:</td>
				<td><input type="text" name="sys_title" value="" placeholder="如: 网站名称"/></td>
			  </tr>
			   <tr>
				 <td>配置项名称:</td>
				 <td><input type="text"name="sys_name" value="" placeholder="请输入英文名称"/></td>
			   </tr>
			   <tr>
				 <td>配置项内容:</td>
				 <td><input type="text"name="sys_val" value="" placeholder="如:欣才商城"/></td>
			   </tr>
			   <tr>
				 <td>配置项类型:</td>
				 <td>
					<input type="radio" name="sys_type" value="text" id="txt" checked/><label for="txt">文本框</label>
					<input type="radio" name="sys_type" value="textarea" id="area"/><label for="area">文本域</label>
				 </td>
			   </tr>
			   <tr>
				 <td colspan="2" align="center" height="40px"><input type="submit" name="add" value=" 添加 " class="coolbt2"></td>
			   </tr>
		</table>
		</form>
	</td>
  </tr>
</table>
</body>
</html>