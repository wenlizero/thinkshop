<?php
include_once("config.php");
if(!isset($_COOKIE['username']))
{
	msg('请先登录','index.php');exit;
}
extract($_GET);
$type = isset($type)?$type:'default';
//查找用户订单
if($type=='order')
{
	$handle = isset($handle)?$handle:'';//处理方式:收货、评论
	//确认收货
	if($handle=='receive'&&isset($order_id))
	{
		if(update(array('delivery_status'=>2),'ts_order',"order_id=$order_id"))
		{
			msg('操作成功','user.php?type=order');exit;
		}
	}
	//商品评价
	if($handle=='提交'&& isset($o_pid) && isset($gid))
	{
		$array=array('msg_content'=>trim($message),'msg_start'=>$start,'user_id'=>$_COOKIE['user_id'],'o_pid'=>$o_pid,'goods_id'=>$gid,'msg_time'=>time());
		$msg_id = insert($array,'ts_message'); 
		//将评论id更新到订单商品表中
		$res = update(array('msg_id'=>$msg_id),'ts_order_goods',"o_pid=$o_pid");
		if($msg_id && $res)
		{
			msg('评论成功','user.php?type=order');exit;
		}
	}
	//获取订单信息
	$sql = "select * from ts_order where user_id = ".$_COOKIE['user_id'];
	$order = fetchAll($sql);
}
//查找用户地址
if($type=='address')
{
	$handle = isset($handle)?$handle:"show";
	$sql = "select * from ts_address where u_id = ".$_COOKIE['user_id'];
	$address = fetchAll($sql);
	if($handle == "edit")
	{
		$address_info = mysql_fetch_assoc(mysql_query("select * from ts_address where addr_id=$id"));
		echo "<script>window.onload=function(){addForm = document.getElementById('addForm');addForm.style.display='block';}</script>";
		//print_r($address_info);
		//header("location.href:user.php?type=address");exit;
		
	}elseif($handle == "del")
	{
		$user_id = $_COOKIE['user_id'];
		//判断该条地址是否为默认地址，是：则将第一条设为默认
		$arr = mysql_fetch_assoc(mysql_query("select addr_default from ts_address where addr_id=$id"));
		$res = delete('ts_address',"addr_id=$id");//删除指定地址
		if($arr['addr_default']==1)
		{
			//查询所有记录取第一条id
			$addr = fetchAll("select * from ts_address where u_id=$user_id ");
			if(count($addr)>0)
			{
				$first_id = $addr[0]['addr_id'];
				update(array('addr_default'=>1) ,'ts_address' ,"addr_id=$first_id");
			}	
		}
		if($res)
		{
			msg('删除成功','user.php?type='.$type);exit;
		}
	}

}
//查找用户评论
if($type=='message')
{
	$sql = "select * from ts_message where user_id = ".$_COOKIE['user_id'];
	$message = fetchAll($sql);
	//print_r($message);
}
?>
<!doctype  html>
<html>
	<head>
		<meta charset="utf-8" />
		<?if($config){foreach($config as $k=>$v){if($v['sys_name']=='title'){?>
			<title><?=$v['sys_val']?></title>
			<?}else{?>
			<meta name="<?=$v['sys_name']?>" content="<?=$v['sys_val']?>" />
		<?}}}?>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/index.css">
	</head>
	<body id='bd'>
		<?php require_once("header.php");?>
		<!--产品展示 start-->
		<div class="main">
			<div class="menu">
				<ul>
					<li>当前:</li>
					<li><a href="user.php">用户中心</a></li>
				</ul>
			</div>
			<div class="ts-user">
				<div class="u-l fl">
					<div class='u-div'><a href="user.php?type=default">用户中心</a></div>
					<div class='u-div'><a href="user.php?type=order" >用户订单</a></div>
					<div class='u-div'><a href="user.php?type=address" >用户地址</a></div>
					<div class='u-div'><a href="user.php?type=message" >用户评论</a></div>
				</div>
				<div class='u-r fl'>
				<?if($type=='default'){?>
					<h2 align='center' class='u-wel'>欢迎来到用户中心</h2>	
					<img src="images/welcome.gif" alt="欢迎" width='500px' style='margin:50px'/>
				<?}elseif($type=='order'){?>
					<table border=0 cellspacing=0 class='u-order'>
						<tr valign='top' height='32px'>
							<th width="15%">订单编号</th>
							<th width="15%">订单时间</th>
							<th width="10%">订单总额</th>
							<th width="15%">付款状态</th>
							<th width="15%">收货状态</th>
							<th width="15%">操作</th>
						</tr>
						<tr>
							<td colspan=6><hr color='#ccc' size='1px'/></td>
						</tr>
						<?if($order){foreach($order as $o){?>
						<tr height="80px;	">
							<td align='center'><?=$o['order_sn']?></td>
							<td align='center'><?=date('Ymd',$o['order_time'])?></td>
							<td align='center'><?=$o['subtotal']?></td>
							<td align='center'>
							<?if($o['pay_status']==1){?>
								<font color='blue'>已付款</font>
							<?}else{?>
								<font color='red'>未付款</font>	
							<?}?>
							</td>
							<td align='center'>
							<?if($o['delivery_status']==1){?>
							<font color='blue'>已发货</font>
							<a href="user.php?type=order&handle=receive&order_id=<?=$o['order_id']?>" class='u-handle'>确认收货</a>
							<?}elseif($o['delivery_status']==2){?>
							<font color='green'>已收货</font>
							<?}else{?>
							<font color='red'>未发货</font>	
							<?}?>
							</td>
							<td align='center'>
								<a href="javascript:onclick=goodsInfo(<?=$o['order_id']?>)" class='u-handle'>订单详情</a>
							</td>
						</tr>
						<tr id='info<?=$o['order_id']?>' style='display:none'>
							<td colspan=6>
							<table>
								<tr bgcolor='#ccc' height='30px'>
									<th>商品图片</th>
									<th>商品名称</th>
									<th>商品价格</th>
									<th>商品颜色</th>
									<th>商品尺寸</th>
									<th>商品数量</th>
									<th>操作</th>
								</tr>
								<?php
								$res = mysql_query("select goods_id from ts_order where order_id=".$o['order_id']);
								if(is_resource($res) && mysql_num_rows($res)>0)
								{
									$arr = mysql_fetch_assoc($res);
									$goods_id = $arr['goods_id'];
									$sql = "select g.pid,g.color,g.size,g.num,p.pname,p.thumb,p.sprice from ts_order_goods as g,ts_product as p where g.pid=p.pid  and  g.oid=" . $o['order_id'] . " and  g.pid  in($goods_id)";
									$goods = fetchAll($sql);
									foreach($goods as $g)
									{
										//根据属性找出ts_order_goods表的主键
										$sql = "select o_pid from ts_order_goods where oid=".$o['order_id']." and pid=".$g['pid']." and color='".$g['color']."' and size='".$g['size']."'";
										$og = mysql_fetch_assoc(mysql_query($sql));
										$o_pid = $og['o_pid'];
										//根据$o_pid
										$rec = mysql_query("select msg_id from ts_message where o_pid=$o_pid");
										$mid = 0;
										if(is_resource($rec) && mysql_num_rows($rec)==1)
										{
											$marr =mysql_fetch_assoc($rec);
											$mid = $marr['msg_id'];
										}

								?>
								<tr>
									<td width='120px' align='center'><a href="product.php?pid=<?=$g['pid']?>"><img src="admin/<?=$g['thumb']?>" alt="" width='100px' /></a></td>
									<td valign="center" width="300px" align='center'><a href="product.php?pid=<?=$g['pid']?>" style='color:black'><?=$g['pname']?></a></td>
									<td width="100px"align='center'><?=$g['sprice']?></td>
									<td width="100px"align='center'><div style="width:15px;height:15px;background:<?=$g['color']?>"></div></td>
									<td width="100px"align='center'><?=$g['size']?></td>
									<td width="100px"align='center'><?=$g['num']?></td>
									<td width="100px"align='center'>
									<?if($mid){?>
										<a href="product.php?pid=<?=$g['pid']?>" class="u-handle">查看评论</a>
									<?}else{?>
										<?if($o['pay_status']==1 && $o['delivery_status']==2){?>
										<span class='u-msg'onclick="getMessage(<?=$o_pid?>,<?=$g['pid']?>)">评论</span>
										<?}else{echo '暂无操作';}?>
									<?}?>
									</td>
								</tr>
								<?}}?>
							</table>
							</td>
						</tr>
						<tr>
							<td colspan=6><hr color='#ccc' size='1px'/></td>
						</tr>
						<?}}else{?>
						<tr>
							<td colspan=6><h3 align='center'>暂无订单,请去 <a href="index.php" style="color:red">首页</a> 看看</h3></td>
						</tr>
						<?}?>
					</table>
				<?}elseif($type=='address'){?>
					<table border=0 cellspacing=0 class='u-order'>
						<tr>
							<th>收货人</th>
							<th>联系方式</th>
							<th>收货地址</th>
							<th>默认地址</th>
							<th>操作</th>
						</tr>
						<?if($address){
						foreach($address as $a){?>
						<tr>
							<td align="center"><?=$a['consignee']?></td>
							<td align="center"><?=$a['mobile']?></td>
							<td align="center"><?=$a['address']?></td>
							<td align="center"><span><?=$a['addr_default']==1? '是': '否'?></span></td>
							<td align="center"><a href="user.php?type=address&handle=edit&id=<?=$a['addr_id']?>"  style="color:peru">修改</a>&nbsp;<a  style="color:deeppink" href="javascript:void(0);"onclick="javascript:if(confirm('确认删除'))location='user.php?type=address&handle=del&id='+<?=$a['addr_id']?>" >删除</a></td>
						</tr>
						<?}}?>
					</table>
					<div style="margin-left:15px">
						<h4 class="addr-add" style="cursor:pointer;" onclick="addAddress()">新增收货地址</h4>
						<div class="addr-form" id="addForm" style="display:none;">
							<form action="address.php" method='post' name="addrForm" onsubmit='return check()'>
								<div class="addr-div"><span class="form-addr">收 货 人 ：</span><input type="text" name="consignee" class="addr-inp" value="<?=isset($address_info['consignee'])?$address_info['consignee']:''?>" /> </div>
								<div class="addr-div"><span class="form-addr">详细地址：</span><input type="text" name="address" class="addr-inp" value="<?=isset($address_info['address'])?$address_info['address']:''?>"/></div>
								<div class="addr-div"><span class="form-addr">联系方式：</span><input type="text" name="mobile" class="addr-inp" value="<?=isset($address_info['mobile'])?$address_info['mobile']:''?>"/></div>
								<div class="addr-div"><input type="checkbox" name="addr_default" id="addr_default" value=1 <?=isset($address_info['addr_default'])&&$address_info['addr_default']==1?'checked':''?> class="addr-default"/><label for="addr_default">设为默认地址</label></div>
								<div class="addr-div">
									<?if(isset($address_info['addr_id'])){?>
									<input type="hidden" name="type" value='addrEdit'/>
									<input type="hidden" name="addr_id" value='<?=$address_info['addr_id']?>'/>
									<?}else{?>
									<input type="hidden" name="type" value='address'/>
									<?}?>
									<input type="submit" name="addrSave" value="保存" class="addr-save"/>
									<input type="reset" name="addrCancel" value="取消" class="addr-save cancel"/>
								</div>
							</form>
						</div>
					</div>
				<?}else if($type=='message'){?>
					<table border=0 cellspacing=0 class='u-order'>
						<tr>
							<th>评论等级</th>
							<th>评论内容</th>
							<th>评论时间</th>
							<th>操作</th>
						</tr>
						<?if($message){
						foreach($message as $m){ 
							if($m['msg_start']==1)
							{$star="差评";}
							elseif($m['msg_start']==2){$star="中评";}
							else{$star="好评";}
							?>
							<tr>
								<td align="center"><font color="#dc143c"><?=$star?></font></td>
								<td align="center"><a href="product.php?pid=<?=$m['goods_id']?>" alt="查看商品" title="查看商品" style="color:black"><?=$m['msg_content']?></a></td>
								<td align="center"><?=date('Y-m-d',$m['msg_time'])?></td>
								<td align="center"><a style="color:deeppink" href="<?=$m['msg_id']?>">删除</a></td>
							</tr>
						<?}}else{?>
						<tr>
							<td colspan=6><h3 align='center'>暂无评论,请去 <a href="index.php" style="color:red">首页</a> 看看</h3></td>
						</tr>
						<?}?>
					</table>
				<?}?>
				</div>
				</div>
			</div>
		</div>
		<!--产品展示 end-->
		<!--配送方式 start-->
		<div class="state">
				<div class="state_l">
					<ul>
						<li><span>7</span>日免费退货</li>
						<li><span>15</span>日免费更换</li>
						<li><span>全场</span>包邮</li>
						<li><span>全国</span>范围均可配送</li>					
					</ul>
				</div>
				<div class="state_r">
					<ul>
						<li><a href="#">支付方式</a></li>
						<li>|<a href="#">配送说明</a></li>
						<li>|<a href="#">售后服务</a></li>					
					</ul>
				</div>
				<div class="clear"></div>
			</div>
		<!--配送方式 end-->
		<?php require_once("footer.php");?>
	</body>
</html>
<script type="text/javascript">
//弹出评论表单
function getMessage(o_pid,gid)
{
	//遮罩层
	var bd = document.getElementById('bd');
	obj_cover = document.createElement('div') ;
	obj_cover.setAttribute('class','cover');
	bd.appendChild(obj_cover);
	//div
	obj_div = document.createElement('div') ;
	obj_div.setAttribute('class','UMsg');
	bd.appendChild(obj_div);
	//表单
	obj_form = document.createElement('form') ;
	obj_form.setAttribute('action','user.php');
	obj_form.setAttribute('method','get');
	obj_div.appendChild(obj_form);
	//评论等级-好评
	 obj_radio1 = document.createElement('input') ;
	 obj_radio1.setAttribute('type','radio');
	 obj_radio1.setAttribute('name','start');
	 obj_radio1.setAttribute('class','URadio');
	 obj_radio1.setAttribute('checked','checked');
	 obj_radio1.setAttribute('value','3');
	 obj_radio1.setAttribute('id','3');
	 obj_form.appendChild(obj_radio1)
	//label标签-好评
	 obj_label1 = document.createElement('label') ;
	 obj_label1.setAttribute('class','ULabel');
	 obj_label1.setAttribute('for','3');
	 obj_label1.innerHTML='好评';
	obj_form.appendChild(obj_label1)
	//评论等级-中评
	 obj_radio2 = document.createElement('input') ;
	 obj_radio2.setAttribute('type','radio');
	 obj_radio2.setAttribute('name','start');
	 obj_radio2.setAttribute('class','URadio');
	 obj_radio2.setAttribute('value','2');
	 obj_radio2.setAttribute('id','2');
	obj_form.appendChild(obj_radio2)
	//label标签-中评
	 obj_label2 = document.createElement('label') ;
	 obj_label2.setAttribute('for','2');
	 obj_label2.setAttribute('class','ULabel');
	 obj_label2.innerHTML='中评';
	obj_form.appendChild(obj_label2)
	//评论等级-差评
	 obj_radio3 = document.createElement('input') ;
	 obj_radio3.setAttribute('type','radio');
	 obj_radio3.setAttribute('class','URadio');
	 obj_radio3.setAttribute('name','start');
	 obj_radio3.setAttribute('value','1');
	 obj_radio3.setAttribute('id','1');
	obj_form.appendChild(obj_radio3)
	//label标签-差评
	 obj_label3 = document.createElement('label') ;
	 obj_label3.setAttribute('for','1');
	 obj_label3.setAttribute('class','ULabel');
	 obj_label3.innerHTML='差评';
	obj_form.appendChild(obj_label3)
	//br标签
	obj_br = document.createElement('br') ;
	obj_form.appendChild(obj_br);
	//文本域
	obj_textarea = document.createElement('textarea') ;
	obj_textarea.setAttribute('name','message');
	obj_textarea.setAttribute('name','message');
	obj_textarea.setAttribute('class','UTextarea');
	obj_form.appendChild(obj_textarea);
	//br标签
	obj_form.appendChild(obj_br);
	//隐藏域-订单商品o_pid
	obj_hidden1 = document.createElement('input') ;
	obj_hidden1.setAttribute('type','hidden');
	obj_hidden1.setAttribute('name','o_pid');
	obj_hidden1.setAttribute('value',o_pid);
	obj_form.appendChild(obj_hidden1);
	//隐藏域-商品gid
	obj_hidden2 = document.createElement('input') ;
	obj_hidden2.setAttribute('type','hidden');
	obj_hidden2.setAttribute('name','gid');
	obj_hidden2.setAttribute('value',gid);
	obj_form.appendChild(obj_hidden2);
	//隐藏域-type=order
	obj_hidden3 = document.createElement('input') ;
	obj_hidden3.setAttribute('type','hidden');
	obj_hidden3.setAttribute('name','type');
	obj_hidden3.setAttribute('value','order');
	obj_form.appendChild(obj_hidden3);
	//提交按钮
	obj_submit = document.createElement('input') ;
	obj_submit.setAttribute('type','submit');
	obj_submit.setAttribute('class','USubmit');
	obj_submit.setAttribute('name','handle');
	obj_submit.setAttribute('value','提交');
	obj_form.appendChild(obj_submit)
	//取消按钮
	obj_button = document.createElement('input') ;
	obj_button.setAttribute('type','button');
	obj_button.setAttribute('class','UButton');
	obj_button.setAttribute('name','close');
	obj_button.setAttribute('onclick','closeMsg()');
	obj_button.setAttribute('value','取消');
	obj_form.appendChild(obj_button)
}
//关闭评论窗口
function closeMsg()
{
	bd.removeChild(obj_div);
	bd.removeChild(obj_cover);
}
//订单详情
function goodsInfo(oid)
{
	info = document.getElementById('info'+oid);
	if(info.style.display == 'none')
	{
		info.style.display = 'table-row';
	}
	else
	{
		info.style.display = 'none';
	}
}
//新增收货地址
function addAddress()
{
	addForm = document.getElementById('addForm');
	if(addForm.style.display == "none")
	{
		addForm.style.display="block";
	}else
	{
		addForm.style.display="none";
	}
}
//收货地址表单检查
function check()
{
	var preg_m = /^1[3|4|5|7|8]\d{9}$/;
	//手机号正则验证
	var res = false;
	if(addrForm.mobile.value !='')
	{
		var res = preg_m.test(addrForm.mobile.value)
	}
	if(addrForm.consignee.value =='' || res == false || addForm.address.value== '')
	{
		return false;
	}
}
</script>