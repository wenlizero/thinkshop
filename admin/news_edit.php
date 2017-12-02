<?php
require_once"../config.php";
//查询本条新闻信息
if(isset($_GET['news_id']))
{
	$news_id = $_GET['news_id'];
	$sql = "select * from ts_news where news_id=$news_id";
	$news = mysql_fetch_assoc(mysql_query($sql));
}
if(isset($_POST['edit']))
{
	//表单数据处理
	extract($_POST);
	$array = array('news_title'=>trim($news_title),'news_cid'=>trim($news_cid),'news_content'=>trim($news_content),'news_pubtime'=>time());
	if(!empty($news_author))
	{
		$array['news_author'] = trim($news_author); 
	}
	if(!empty($news_keyword))
	{
		$array['news_keyword'] = trim($news_keyword); 
	}
	if(!empty($news_descp))
	{
		$array['news_descp'] = trim($news_descp); 
	}
	if(!empty(implode('',$_FILES['news_img']['name'])))
	{
		$dir = 'uploads/news_img/'.date('Ymd') .'/';
		$news_img = rtrim(moreFiles($_FILES['news_img'],$dir),',');
		$array['news_img'] = $news_img;
		if(!empty($news['news_img']))//删除原图
		{
			$arr = explode(',',$news['news_img']);
			for($i=0;$i<count($arr);$i++)
			{
				unlink($arr[$i]);
			}
		}
	}
	//新闻修改
	if(update($array,'ts_news' ,"news_id=$news_id"))
	{
		msg('修改成功','news.php');
	}
	else
	{
		msg('修改成功','news.php');
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
<link rel="stylesheet" type="text/css" href="skin/css/product.css" />
</head>
<body leftmargin="8" topmargin='8' id="bd">
<table width="98%" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td background="skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' colspan="2"><span><img src='skin/images/frame/arr3.gif' style='margin-right:10px;'>修改新闻</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>
	<form name="form" action="" method="post" enctype="multipart/form-data" onsubmit="return check()">
		<table style="margin-bottom:8px;margin-top:8px;margin-left:20px;">
				<tr>
					<td>新闻标题:</td>
					<td><input type="text" name="news_title" value="<?=$news['news_title']?>"/><span class="sp_must">*</span><span id='tip1' class="sp_must"></span></td>
				</tr>
			   <tr>
					<td width="100px;">新闻分类:</td>
					<td>
						<select name="news_cid">
						<option value=0>顶级分类</option>
						<?php
						if(isset($news_cate))
						{
							foreach($news_cate as $vo)
							{
						?>
							<option  <? if($vo['cid'] == $news['news_cid']){echo "selected";}?>  value=<?=$vo['cid']?>><?=str_repeat("&nbsp;",$vo['level']).$vo['cname']?></option>
						<?php }}?>
						</select>
						<span class="sp_must">*</span>
					</td>
				</tr>
				<tr>
					<td>作者</td>
					<td><input type="text" name="news_author" value="<?=$news['news_author']?>"/></td>
				</tr>
				<tr>
					<td>关键字:</td>
					<td><input type="text" name="news_keyword"value="<?=$news['news_keyword']?>"/></td>
				</tr>
				<tr>
					<td>描述:</td>
					<td><input type="text" name="news_descp"value="<?=$news['news_descp']?>"/></td>
				</tr>
				<tr>
					<td valign='top'>新闻配图:</td>
					<td>
						<input type="hidden" name="MAX_FILE_SIZE" value=2000000 />
						<div id='par' style="display:inline-block"><div><span class="sp_img" onclick="addImg(this)">+</span><input type="file" name="news_img[]"/></div></div>
						<? if(!empty($news['news_img'])){ $news_img = explode(',',$news['news_img']);foreach($news_img as $v){?>
						<img src="<?=$v?>" alt="" height='20px' align='right' onclick='getBig(this)'/>
						<? }}?>
					</td>
				</tr>
				<tr>
					<td>新闻内容:</td>
					<td>
					<textarea name="news_content" id="" cols="33" rows="10" ><?=$news['news_content']?></textarea>
					<span class="sp_must">*</span><span id='tip2' class="sp_must"></span>
					</td>
				</tr>
			   <tr>
				 <td colspan="2" align="center" height="40px"><input type="submit" value="修改 " class="coolbt2" name="edit"></td>
			   </tr>
		</table>
		</form>
	</td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
//新闻标题判断
form.news_title.onblur = function()
{
	if(this.value == '')
		tip1.innerHTML = '不能为空';
	else
		tip1.innerHTML ='';
}
//新闻内容判断
form.news_content.onblur = function()
{
	if(this.value == '')
		tip2.innerHTML = '不能为空';
	else
		tip2.innerHTML ='';
}
//表单数据过滤
function check()
{
	//新闻标题和内容不允许为空
	if(form.news_title.value == '' ||form.news_content.value == '' )
	{
		alert('请填写必填项');
		return false;
	}
	else
	{
		return true;
	}
}
//新闻配图节点的增删
function addImg()
{
	//增加p标签
	obj_p = document.createElement('p') ; 
	par.appendChild(obj_p);//par是指父级div对象
	//增加span标签
	obj_sp = document.createElement('span') ; 
	obj_sp.setAttribute('class','sp_img');
	obj_sp.setAttribute('onclick','removeImg()');
	obj_sp.innerHTML= '-';
	obj_p.appendChild(obj_sp);
	//增加input标签
	obj_ipt = document.createElement('input') ; 
	obj_ipt.setAttribute('type','file');
	obj_ipt.setAttribute('name','news_img[]');
	obj_p.appendChild(obj_ipt);	
}
function removeImg()
{
	par.removeChild(par.lastChild);
}
//双击图片放大
var bd = document.getElementById('bd');
function getBig(picObj)
{
	obj_cover = document.createElement('div') ; 
	obj_cover.setAttribute('class','cover');
	bd.appendChild(obj_cover);
	obj_img = document.createElement('img') ;
	obj_img.setAttribute('src',picObj.src);
	obj_img.setAttribute('class','bigimg');
	obj_img.setAttribute('onclick','getBack()');
	bd.appendChild(obj_img);
}
//返回原图
function getBack()
{
	bd.removeChild(obj_img);
	bd.removeChild(obj_cover);
}
</script>