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
    <td background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"><span><img src='./skin/images/frame/arr3.gif' style='margin-right:10px;'>添加新闻分类</span></td>
	<td align="right" background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="2">
		<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
			<tr align="center" bgcolor="#FBFCE2" height="25">
				<td width="6%">ID</td>
				<td width="4%">选择</td>
				<td width="28%">文章标题</td>
				<td width="10%">更新时间</td>
				<td width="10%">类目</td>
				<td width="8%">点击</td>
				<td width="8%">发布人</td>
				<td width="10%">操作</td>
			</tr>
  <!-- data start-->
			<tr align='center' bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
				<td nowrap>
					179	</td>
				<td>
					<input name="arcID" type="checkbox" id="arcID" value="179" class="np" />
				</td>
				<td align='left'>
					<span id="arc179">
						<a href='archives_do.php?aid=179&dopost=editArchives'>
							<u>“青春暖夕阳、关和谐”徐庄</u>
						</a>
					</span>
					[<font color='red'>图片</font>]	</td>
				<td>2014-05-05</td>
				<td><a href='content_list.php?cid=36'>园区新闻</a></td>
				<td>161</td>
				<td>xuzhuangadmin1</td>
				<td>
					<img src='./skin/images/frame/trun.gif' title="编辑" alt="编辑" onClick="QuickEdit(179, event, this);" style='cursor:pointer' border='0' width='16' height='16' />
					<img src='./skin/images/frame/gtk-del.png' title="删除" alt="删除" onClick="editArc(179);" style='cursor:pointer' border='0' width='16' height='16' />
					<img src='./skin/images/frame/part-list.gif' title="预览" alt="预览" onClick="viewArc(179);" style='cursor:pointer' border='0' width='16' height='16' />
				</td>
			</tr>
			<tr align='center' bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
				<td nowrap>
					179	</td>
				<td>
					<input name="arcID" type="checkbox" id="arcID" value="179" class="np" />
				</td>
				<td align='left'>
					<span id="arc179">
						<a href='archives_do.php?aid=179&dopost=editArchives'>
							“青春暖夕阳、关和谐”徐庄
						</a>
					</span>
					[<font color='red'>图片</font>]	</td>
				<td>2014-05-05</td>
				<td><a href='content_list.php?cid=36'>园区新闻</a></td>
				<td>161</td>
				<td>xuzhuangadmin1</td>
				<td>
						<img src='./skin/images/frame/trun.gif' title="编辑" alt="编辑" onClick="QuickEdit(179, event, this);" style='cursor:pointer' border='0' width='16' height='16' />
					<img src='./skin/images/frame/gtk-del.png' title="删除" alt="删除" onClick="editArc(179);" style='cursor:pointer' border='0' width='16' height='16' />
					<img src='./skin/images/frame/part-list.gif' title="预览" alt="预览" onClick="viewArc(179);" style='cursor:pointer' border='0' width='16' height='16' />
				</td>
			</tr>
			<tr align='center' bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
					<td nowrap>
						179	</td>
					<td>
						<input name="arcID" type="checkbox" id="arcID" value="179" class="np" />
					</td>
					<td align='left'>
						<span id="arc179">
							<a href='archives_do.php?aid=179&dopost=editArchives'>
							“青春暖夕阳、关和谐”徐庄
							</a>
						</span>
						[<font color='red'>图片</font>]	</td>
					<td>2014-05-05</td>
					<td><a href='content_list.php?cid=36'>园区新闻</a></td>
					<td>161</td>
					<td>xuzhuangadmin1</td>
					<td>
							<img src='./skin/images/frame/trun.gif' title="编辑" alt="编辑" onClick="QuickEdit(179, event, this);" style='cursor:pointer' border='0' width='16' height='16' />
					<img src='./skin/images/frame/gtk-del.png' title="删除" alt="删除" onClick="editArc(179);" style='cursor:pointer' border='0' width='16' height='16' />
					<img src='./skin/images/frame/part-list.gif' title="预览" alt="预览" onClick="viewArc(179);" style='cursor:pointer' border='0' width='16' height='16' />
					</td>
				</tr>
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
			<a href="" class="coolbg">删除</a>
		</td>
	  </tr>
  <!-- select end-->
  <!-- page start-->
	  <tr align="right" bgcolor="#F9FCEF">
		<td height="36" colspan="10" align="center">
			<div class="pagelistbox">
				<span>共 6 页/154条记录 </span><span class='indexPage'>首页 
				<a class='prevPage' href='#'>上页</a> 
				</span><strong>1</strong>
				<a href='#'>2</a>
				<a href='#'>3</a>
				<a href='#'>4</a>
				<a href='#'>5</a>
				<a href='#'>6</a>
				<a class='nextPage' href='#'>下页</a> 
				<a class='endPage' href='#'>末页</a> 
				</div>
			</td>
	  </tr>
  <!-- page end-->
  <tr>
	<td colspan="2"><input type='button' class="coolbg np" onClick="location='catalog_do.php?channelid=0&cid=0&dopost=addArchives';" value='添加文档'/></td>
  </tr>
</table>
</body>
</html>