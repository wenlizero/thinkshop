<?php
require_once"../config.php";
if(isset($_POST['add']))
{
	//表单数据处理
	extract($_POST);//var_dump($color);
	$color = implode(',',$color);//或者json_encode($color);
	if(!empty($size))
	{
		$size = implode(',',$size);
	}
	if(empty($sprice))
	{
		$sprice = null;
	}
	$array = array('pname'=>trim($pname),'p_c_id'=>trim($p_c_id),'pnums'=>trim($pnums),'price' =>$price,'sprice' =>$sprice,'keyword' =>$keyword,'addr' =>$addr,'price' =>$price,'snums' =>$snums,'ifshow' =>$ifshow,'color' =>$color,'size' =>$size,'descp'=>trim($descp),'pubtime'=>time());
	if(!empty($_FILES['thumb']['name']))
	{
		$dir = 'uploads/thumb/'.date('Ymd') .'/';
		$thumb = uploadFile($_FILES['thumb'],$dir);
		$array['thumb'] = $thumb;
	}
	if(!empty(implode('',$_FILES['pimgs']['name'])))
	{
		$dir2 = 'uploads/pimgs/'.date('Ymd') .'/';
		$pimgs = rtrim(moreFiles($_FILES['pimgs'],$dir2),',');
		$array['pimgs'] = $pimgs;
	}
	//商品新增入库
	if(insert($array,'ts_product')>0)
	{
		msg('新增成功','product.php');
	}
	else
	{
		msg('新增失败,请重新添加','product_add.php');
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
<body leftmargin="8" topmargin='8'>
<table width="98%" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td background="skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' colspan="2"><span><img src='skin/images/frame/arr3.gif' style='margin-right:10px;'>添加商品</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>
	<form name="form" action="" method="post" enctype="multipart/form-data" onsubmit="return check()">
		<table style="margin-bottom:8px;margin-top:8px;margin-left:20px;">
				<tr>
					<td>商品名称:</td>
					<td><input type="text" name="pname"/><span class="sp_must">*</span><span id='tip1' class="sp_must"></span></td>
				</tr>
			   <tr>
					<td width="100px;">商品分类:</td>
					<td>
						<select name="p_c_id">
						<option value=0>顶级分类</option>
						<?php
						if(isset($product_cate))
						{
							foreach($product_cate as $vo)
							{
						?>
							<option value=<?=$vo['pc_id']?>><?=str_repeat("&nbsp;",$vo['pc_level']).$vo['pc_name']?></option>
						<?php }}?>
						</select>
						<span class="sp_must">*</span>
					</td>
				</tr>
				<tr>
					<td>产地:</td>
					<td><input type="text" name="addr"/><span class="sp_must">*</span><span id='tip4' class="sp_must"></span></td>
				</tr>
				<tr>
					<td>商品价格:</td>
					<td><input type="text" name="price"/><span class="sp_must">*</span><span id='tip2' class="sp_must"></span></td>
				</tr>
				<tr>
					<td>优惠价格:</td>
					<td><input type="text" name="sprice" placeholder="必须低于原价"/><span id='tip3' class="sp_must"></span></td>
				</tr>
				<tr>
					<td>关键字:</td>
					<td><input type="text" name="keyword"/></td>
				</tr>
				<tr>
					<td>商品编号:</td>
					<td><input type="text" name="pnums" placeholder="ts_20170327114012"/></td>
				</tr>
				<tr>
					<td>库存:</td>
					<td><input type="text" name="snums" value=100 /><span id='tip5' class="sp_must"></span></td>
				</tr>
				<tr>
					<td>上架/下架</td>
					<td>
						<input type="radio" name="ifshow"id="yes"value=1 checked/>
						<label for="yes">上架</label>
						<input type="radio" name="ifshow"id="no"value=0/>
						<label for="no">下架</label>
					</td>
				</tr>
				<tr>
					<td>商品颜色:</td>
					<td>
						<div id='parColor'>
							<span>
								<a href="javascript:addColor(this)">+</a>
								<input type="color" name="color[]"class="sp_color"/>
							</span>
						</div>
						<!--
						<input type="checkbox" name="color[]" value="red" id="red" checked/>
						<label for="red"><span class="sp_color sp_c1"></span></label>
						<input type="checkbox" name="color[]" value="yellow" id="yellow"/>
						<label for="yellow"><span class="sp_color sp_c2"></span></label>
						<input type="checkbox" name="color[]" value="blue" id="blue"/>
						<label for="blue"><span class="sp_color sp_c3"></span></label>
						<input type="checkbox" name="color[]" value="green" id="green"/>
						<label for="green"><span class="sp_color sp_c4"></span></label>
						<input type="checkbox" name="color[]" value="purple" id="purple"/>
						<label for="purple"><span class="sp_color sp_c5"></span></label>
						<input type="checkbox" name="color[]" value="pink" id="pink"/>
						<label for="pink"><span class="sp_color sp_c6"></span></label>
						-->
						<span class="sp_must">*</span>
					</td>
				</tr>
				<tr>
					<td>商品尺码:</td>
					<td>
						<input type="checkbox" name="size[]" value="XS" id="XS" checked/>
						<label for="XS"><span class="sp_size">XS</span></label>
						<input type="checkbox" name="size[]" value="S" id="S" checked/>
						<label for="S"><span class="sp_size">S</span></label>
						<input type="checkbox" name="size[]" value="M" id="M" checked/>
						<label for="M"><span class="sp_size">M</span></label>
						<input type="checkbox" name="size[]" value="L" id="L" />
						<label for="L"><span class="sp_size">L</span></label>
						<input type="checkbox" name="size[]" value="XL" id="XL" />
						<label for="XL"><span class="sp_size">XL</span></label>
						<input type="checkbox" name="size[]" value="XXL" id="XXL" />
						<label for="XXL"><span class="sp_size">XXL</span></label>
						<input type="checkbox" name="size[]" value="XXXL" id="XXXL" />
						<label for="XXXL"><span class="sp_size">XXXL</span></label>
					</td>
				</tr>
				<tr>
					<td>标题图片:</td>
					<td>
						<input type="hidden" name="MAX_FILE_SIZE" value=2000000 />
						<input type="file" name="thumb" style="margin-left:10px;"/>
					</td>
				</tr>
				<tr>
					<td valign='top'>商品图册:</td>
					<td>
						<input type="hidden" name="MAX_FILE_SIZE" value=2000000 />
						<div id='par'><div><span class="sp_img" onclick="addImg(this)">+</span><input type="file" name="pimgs[]"/></div></div>
					</td>
				</tr>
				<tr>
					<td>商品描述:</td>
					<td>
					<?php
					include_once("./fckeditor/fckeditor.php");
					$fckeditor = new FCKeditor("descp");//定义默认值 name
					$fckeditor->Width = "300px";//定义编辑器的宽度
					$fckeditor->Height = "200px";//定义编辑器的高度
					$fckeditor->Value = "";//定义默认值
					$fckeditor->BasePath='./fckeditor/';
					$fckeditor->ToolbarSet = "Basic";
					$fckeditor->Create();//创建编辑器
					?>
					</td>
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
<script type="text/javascript">
//商品名称判断
form.pname.onblur = function()
{
	if(this.value == '')
		tip1.innerHTML = '不能为空';
	else
		tip1.innerHTML ='';
}
//商品价格判断
form.price.onblur = function()
{
	if(this.value == ''|| isNaN(this.value))//isNaN 判断是否为数值型
		tip2.innerHTML = '请输入正确价格';
	else
		tip2.innerHTML ='';
}
//商品优惠价格判断
form.sprice.onblur = function()
{
	if(this.value == ''&& isNaN(this.value))//isNaN 判断是否为数值型
		tip3.innerHTML = '请输入正确价格';
	else
		tip3.innerHTML ='';
	if(parseInt(this.value)>parseInt(form.price.value))
		tip3.innerHTML = '优惠价不得高于原价';
}
//产地判断
form.addr.onblur = function()
{
	if(this.value == '')
		tip4.innerHTML = '不能为空';
	else
		tip4.innerHTML ='';
}
//库存判断
form.snums.onblur = function()
{
	if(this.value != '' && isNaN(this.value))
		tip5.innerHTML = '必须是数字';
	else
		tip5.innerHTML ='';
}
//表单数据过滤
function check()
{
	//商品名称、价格、地址不允许为空
	if(form.pname.value == '' ||form.price.value == '' ||form.addr.value == '')
	{
		alert('请填写必填项');
		return false;
	}
	//判断价格和优惠价
	if(form.price.value==''||isNaN(form.price.value))
	{
		alert('价格有误');
		return false;
	}
	if(form.sprice.value !='' && isNaN(form.sprice.value))
	{
		alert('优惠价格有误');
		return false;
	}
	if(form.sprice.value>form.price.value)
	{
		alert('优惠价不能高于原价');
		return false;
	}
	//判断库存是否合法
	if(form.snums.value !='' && isNaN(form.snums.value))
	{
		alert('库存必须是数字');
		return false;
	}
	/*
	//至少选择一个颜色
	arr = document.getElementsByName('color[]');
	var i = 0;var choose = 0;
	for(i;i<arr.length;i++)
	{
		if(arr[i].type=='checkbox')
		{
			if(arr[i].checked == true)
			{
				choose++;
			}
		}
	}
	if(choose == 0)
	{
		alert('至少选择一个颜色');
		return false;
	}
	*/
}
//颜色节点的增删
function addColor()
{
	//增加span标签
	var obj_sp = document.createElement('sp') ; 
	parColor.appendChild(obj_sp);//par是指父级div对象
	//增加a标签
	var obj_a = document.createElement('a') ; 
	obj_a.setAttribute('href','javascript:removeColor()');
	obj_a.innerHTML= ' - ';
	obj_sp.appendChild(obj_a);
	//增加input标签
	var obj_ipt = document.createElement('input') ; 
	obj_ipt.setAttribute('type','color');
	obj_ipt.setAttribute('name','color[]');
	obj_ipt.setAttribute('class','sp_color');
	obj_sp.appendChild(obj_ipt);	
}
function removeColor()
{
	parColor.removeChild(parColor.lastChild);
}
//商品图册节点的增删
function addImg()
{
	//增加p标签
	var obj_p = document.createElement('p') ; 
	par.appendChild(obj_p);//par是指父级div对象
	//增加span标签
	var obj_sp = document.createElement('span') ; 
	obj_sp.setAttribute('class','sp_img');
	obj_sp.setAttribute('onclick','removeImg()');
	obj_sp.innerHTML= '-';
	obj_p.appendChild(obj_sp);
	//增加input标签
	var obj_ipt = document.createElement('input') ; 
	obj_ipt.setAttribute('type','file');
	obj_ipt.setAttribute('name','pimgs[]');
	obj_p.appendChild(obj_ipt);	
}
function removeImg()
{
	par.removeChild(par.lastChild);
}
</script>