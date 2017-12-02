<?php
require_once('../config.php');
$sql = "select * from ts_sysconfig order by sys_id desc";
$res = mysql_query($sql);//资源型
if(is_resource($res) && mysql_num_rows($res)>0)
{
	while(($arr = mysql_fetch_assoc($res)) != false)
	{
		$conf[] = $arr;
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
    <td background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"><span><img src='./skin/images/frame/arr3.gif' style='margin-right:10px;'>配置项管理</span></td>
	<td align="right" background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"></td>
	</tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="2">
		<?php  if(isset($conf)){ ?>
		<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
			<tr align="center" bgcolor="#FBFCE2" height="25">
				<td width="6%">ID</td>
				<td width="4%">选择</td>
				<td width="28%">配置项标题</td>
				<td width="10%">配置项名称</td>
				<td width="10%">配置项内容</td>
				<td width="8%">配置项类型</td>
				<td width="10%">操作</td>
			</tr>
  <!-- data start-->
  	<?php  foreach($conf as $k=>$v){ ?>
			<tr align='center' bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
				<td nowrap><?=$v['sys_id']?>	</td>
				<td>
					<input name="arcID" type="checkbox" value="<?=$v['sys_id']?>" class="np" />
				</td>
				<td align='left'><span id="arc179"><?=$v['sys_title']?></span></td>
				<td><?=$v['sys_name']?></td>
				<td><?=$v['sys_val']?></td>
				<td><?=$v['sys_type']?></td>
				<td>
					<a href='sys_conf_edit.php?id=<?=$v['sys_id']?>' target='main'><img src='./skin/images/frame/trun.gif' title="编辑" alt="编辑" onClick="QuickEdit(179, event, this);" style='cursor:pointer' border='0' width='16' height='16' /></a>
					<a href='sys_conf_del.php?id=<?=$v['sys_id']?>' target='main'><img src='./skin/images/frame/gtk-del.png' title="删除" alt="删除" onClick="editArc(179);" style='cursor:pointer' border='0' width='16' height='16' /></a>
				</td>
			</tr>	
			<?php	} ?>
	</table>
	<?php	} ?>
			</td>
		  </tr>
  <!-- data end-->
  <!-- select start-->
	  <tr bgcolor="#ffffff">
		<td height="36" colspan="10">
			<a href="javascript:selAll()" class="coolbg">全选</a>
			<a href="javascript:noSelAll()" class="coolbg">取消</a>
			<a href="javascript:updateArc()" class="coolbg">反选</a>
			<a href="javascript:selDel()" class="coolbg">删除</a><!--一次性删除选中的-->
		</td>
	  </tr>
  <!-- select end-->
  <tr>
	<td colspan="2"><input type='button' class="coolbg np" onClick="location='sys_conf_add.php';" value='添加配置项'/></td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
/*删除选中：id  */
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
				str += arr[i].value+','; //由选中id组成的字符串 str = 1,3,4,
			}
		}
	}
	if(str !='')
	{
		var res = confirm("确定删除？");
	}
	if(res)
	{
		location.href="sys_conf_del.php?ids="+str;
	}
}
</script>