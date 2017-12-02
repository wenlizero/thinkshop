<?php
require_once"../config.php";
//查询本条商品信息
if(isset($_GET['pid']))
{
	$pid = $_GET['pid'];
	$sql = "select * from ts_product where pid=$pid";
	$product = mysql_fetch_assoc(mysql_query($sql));
}
if(isset($_POST['edit']))
{
	//表单数据处理
	extract($_POST);
	$color = implode(',',$color);	
	$size = implode(',',$size);
	if(empty($sprice))$sprice=$price;//若无优惠价,则优惠价的值就是原价
	$array = array('pname'=>trim($pname),'p_c_id'=>trim($p_c_id),'pnums'=>trim($pnums),'price' =>$price,'sprice' =>$sprice,'keyword' =>$keyword,'addr' =>$addr,'snums' =>$snums,'ifshow' =>$ifshow,'color' =>$color,'size' =>$size,'descp'=>trim($descp),'pubtime'=>time());
	if(!empty($_FILES['thumb']['name']))
	{
		$dir = 'uploads/thumb/'.date('Ymd') .'/';
		$thumb = uploadFile($_FILES['thumb'],$dir);
		$array['thumb'] = $thumb;
		//从文件夹删除原图
		unlink($product['thumb']);
	}
	if(!empty(implode('',$_FILES['pimgs']['name'])))
	{
		$dir2 = 'uploads/pimgs/'.date('Ymd') .'/';
		$pimgs = rtrim(moreFiles($_FILES['pimgs'],$dir2),',');
		$array['pimgs'] = $pimgs;
		$arr = explode(',',$product['pimgs']);
		for($i=0;$i<count($arr);$i++)
		{
			unlink($arr[$i]);
		}
	}
	//商品修改入库
	if(update($array,'ts_product',"pid=$pid")>0)
	{
		msg('修改成功','product.php');
	}
	else
	{
		msg('修改失败','product_edit.php?pid='.$pid);
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
<body leftmargin="8" topmargin='8' id='bd'>
<table width="98%" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td background="skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' colspan="2"><span><img src='skin/images/frame/arr3.gif' style='margin-right:10px;'>添加商品</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>
	<?php if(isset($product)){?>
	<form name="form" action="" method="post" enctype="multipart/form-data" onsubmit="return check()">
		<table style="margin-bottom:8px;margin-top:8px;margin-left:20px;">
				<tr>
					<td>商品名称:</td>
					<td><input type="text" name="pname" value=<?=$product['pname']?> /><span class="sp_must">*</span><span id='tip1' class="sp_must"></span></td>
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
							<option <? if($vo['pc_id'] == $product['p_c_id']){echo "selected";}?> value=<?=$vo['pc_id']?>><?=str_repeat("&nbsp;",$vo['pc_level']).$vo['pc_name']?></option>
						<?php }}?>
						</select>
						<span class="sp_must">*</span>
					</td>
				</tr>
				<tr>
					<td>产地:</td>
					<td><input type="text" name="addr" value="<?=$product['addr']?>"/><span class="sp_must">*</span><span id='tip4' class="sp_must"></span></td>
				</tr>
				<tr>
					<td>商品价格:</td>
					<td><input type="text" name="price" value="<?=$product['price']?>"/><span class="sp_must">*</span><span id='tip2' class="sp_must"></span></td>
				</tr>
				<tr>
					<td>优惠价格:</td>
					<td><input type="text" name="sprice" placeholder="必须低于原价" value="<?=$product['sprice']?>"/><span id='tip3' class="sp_must"></span></td>
				</tr>
				<tr>
					<td>关键字:</td>
					<td><input type="text" name="keyword" value="<?=$product['keyword']?>"/></td>
				</tr>
				<tr>
					<td>商品编号:</td>
					<td><input type="text" name="pnums"  value="<?=$product['pnums']?>"/></td>
				</tr>
				<tr>
					<td>库存:</td>
					<td><input type="text" name="snums"  value="<?=$product['snums']?>" /><span id='tip5' class="sp_must"></span></td>
				</tr>
				<tr>
					<td>上架/下架</td>
					<td>
						<input type="radio" name="ifshow"id="yes"value=1 <? if($product['ifshow']==1){echo "checked";}?>/>
						<label for="yes">上架</label>
						<input type="radio" name="ifshow"id="no"value=0 <? if($product['ifshow']==0){echo "checked";}?>/>
						<label for="no">下架</label>
					</td>
				</tr>
				<tr>
					<td>商品颜色:</td>
					<td>
						<div id='parColor'>
						<?$color = explode(',',$product['color']);
						foreach($color as $k=>$c){?>
							<span>
							<?if($k==0){?>
								<a href="javascript:addColor(this)"> + </a>
								<input type="color" name="color[]" value="<?=$c?>"class="sp_color"/>
							<?}else{?>
								<a href="javascript:removeColor(this)">-</a>
								<input type="color" name="color[]" value="<?=$c?>"class="sp_color"/>
							<?}?>
							</span>
						<?}?>
						</div>
						<!--
						<?php $color = explode(',',$product['color']);?>
						<input type="checkbox" name="color[]" value="red" id="red"	<? if(in_array('red',$color)){echo 'checked';}?> />
						<label for="red"><span class="sp_color sp_c1"></span></label>
						<input type="checkbox" name="color[]" value="yellow" id="yellow" <? if(in_array('yellow',$color)){echo 'checked';}?>/>
						<label for="yellow"><span class="sp_color sp_c2"></span></label>
						<input type="checkbox" name="color[]" value="blue" id="blue" <? if(in_array('blue',$color)){echo 'checked';}?>/>
						<label for="blue"><span class="sp_color sp_c3"></span></label>
						<input type="checkbox" name="color[]" value="green" id="green" <? if(in_array('green',$color)){echo 'checked';}?>/>
						<label for="green"><span class="sp_color sp_c4"></span></label>
						<input type="checkbox" name="color[]" value="purple" id="purple" <? if(in_array('purple',$color)){echo 'checked';}?>/>
						<label for="purple"><span class="sp_color sp_c5"></span></label>
						<input type="checkbox" name="color[]" value="pink" id="pink" <? if(in_array('pink',$color)){echo 'checked';}?>/>
						<label for="pink"><span class="sp_color sp_c6"></span></label>
						-->
						<span class="sp_must">*</span>
					</td>
				</tr>
				<tr>
					<td>商品尺码:</td>
					<td>
						<?php $size = explode(',',$product['size']);?>
						<input type="checkbox" name="size[]" value="XS" id="XS" <? if(in_array('XS',$size)){echo 'checked';}?>/>
						<label for="XS"><span class="sp_size">XS</span></label>
						<input type="checkbox" name="size[]" value="S" id="S" <? if(in_array('S',$size)){echo 'checked';}?>/>
						<label for="S"><span class="sp_size">S</span></label>
						<input type="checkbox" name="size[]" value="M" id="M" <? if(in_array('M',$size)){echo 'checked';}?>/>
						<label for="M"><span class="sp_size">M</span></label>
						<input type="checkbox" name="size[]" value="L" id="L" <? if(in_array('L',$size)){echo 'checked';}?>/>
						<label for="L"><span class="sp_size">L</span></label>
						<input type="checkbox" name="size[]" value="XL" id="XL"<? if(in_array('XL',$size)){echo 'checked';}?> />
						<label for="XL"><span class="sp_size">XL</span></label>
						<input type="checkbox" name="size[]" value="XXL" id="XXL"<? if(in_array('XXL',$size)){echo 'checked';}?> />
						<label for="XXL"><span class="sp_size">XXL</span></label>
						<input type="checkbox" name="size[]" value="XXXL" id="XXXL" <? if(in_array('XXXL',$size)){echo 'checked';}?>/>
						<label for="XXXL"><span class="sp_size">XXXL</span></label>
					
					</td>
				</tr>
				<tr>
					<td>标题图片:</td>
					<td>
						<input type="hidden" name="MAX_FILE_SIZE" value=2000000 />
						<input type="file" name="thumb" style="margin-left:10px;"/>
						<? if(!empty($product['thumb'])){ ?>
						<img src="<?=$product['thumb']?>" alt="" height='20px' align="right" onclick='getBig(this)'/>
						<? }?>
					</td>
				</tr>
				<tr>
					<td valign='top'>商品图册:</td>
					<td>
						<input type="hidden" name="MAX_FILE_SIZE" value=2000000 />
						<div id='par' style="display:inline-block"><div><span class="sp_img" onclick="addImg(this)">+</span><input type="file" name="pimgs[]"/></div></div>
						<? if(!empty($product['pimgs'])){ $pimgs = explode(',',$product['pimgs']);foreach($pimgs as $v){?>
						<img src="<?=$v?>" alt="" height='20px' align='right' onclick='getBig(this)'/>
						<? }}?>
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
					$fckeditor->Value = $product['descp'];//定义默认值
					$fckeditor->BasePath='./fckeditor/';
					$fckeditor->ToolbarSet = "Basic";
					$fckeditor->Create();//创建编辑器
					?>
					</td>
				</tr>
			   <tr>
				 <td colspan="2" align="center" height="40px"><input type="submit" value=" 修改 " class="coolbt2" name="edit"></td>
			   </tr>
		</table>
		</form>
	<?php }?>
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
	if(form.pname.value == '' ||form.price == '' ||form.addr == '')
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
	obj_ipt.setAttribute('name','pimgs[]');
	obj_p.appendChild(obj_ipt);	
}
function removeImg()
{
	par.removeChild(par.lastChild);
}
//点击图片弹出大图
var bd = document.getElementById('bd');//捕获body元素
function getBig(picObj)
{
	obj_cover = document.createElement('div');//新增div节点当遮罩层 
	obj_cover.setAttribute('class','cover');
	bd.appendChild(obj_cover);
	obj_img = document.createElement('img') ;//新增图像节点
	obj_img.setAttribute('src',picObj.src);//将小图src给大图
	obj_img.setAttribute('class','bigimg');
	obj_img.setAttribute('onclick','getBack()');//设置返回事件
	bd.appendChild(obj_img);
}
//返回原图
function getBack()
{
	bd.removeChild(obj_img);//删除图像节点
	bd.removeChild(obj_cover);//删除遮罩层
}
</script>


