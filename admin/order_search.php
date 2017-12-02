<?php
require_once"../config.php";


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主体部分</title>
<base target="_self">
<link rel="stylesheet" type="text/css" href="skin/css/base.css" />
<link rel="stylesheet" type="text/css" href="skin/css/main.css" />
</head>
<body>
<table width="98%" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"><span><img src='./skin/images/frame/arr3.gif' style='margin-right:10px;'>订单搜索</span></td>
	<td align="right" background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="2">
	<form action="order.php" method="get" name="frm" onsubmit="return check()">
		<table width="50%" border="0" cellpadding="2" cellspacing="0" bgcolor="#CFCFCF" align="left" style="margin-top:8px">
			<tr bgcolor="#FFFFFF">
				<td width="50px" align="center">订单号:</td>
				<td><input type="text"name="order_sn"/></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td align="center">订单时间:</td>
				<td>
					<input type="date"name="time_start" />
					~
					<input type="date"name="time_end" />
				</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td align="center">购买者:</td>
				<td><input type="text"name="buyer"/></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td align="center">收货人:</td>
				<td><input type="text"name="consignee"/></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td align="center">联系方式:</td>
				<td><input type="text"name="mobile"/></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td align="center">收货地址:</td>
				<td><input type="text"name="address"/></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td align="center">付款状态:</td>
				<td>
					<select name="pay_status">
						<option value="0">未付款</option>
						<option value="1">已付款</option>
					</select>
				</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td align="center">发货状态:</td>
				<td>
					<select name="delivery_status">
						<option value="0">未发货</option>
						<option value="1">已发货</option>
						<option value="2">已收货</option>
					</select>
				</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td align='right'>
					<input type="submit" name="search"class="coolbt2"value="立即搜索"/>
				</td>
				<td></td>
			</tr>
		</table>
	</form>
	</td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
//定义变量
var order_sn = frm.order_sn.value;
var time_start = frm.time_start.value;
var time_end = frm.time_end.value;
var buyer = frm.buyer.value;
var consignee = frm.consignee.value;
var mobile = frm.mobile.value;
var address = frm.address.value;

function check()
{
	//订单号必需是数字
	if(isNaN(order_sn))
	{
		alert('订单号必须是数字');
		return false;
	}
	//订单时间
	alert(parseInt(time_end));
	alert(parseInt(time_start));
	if((parseInt(time_end) - parseInt(time_start))<0)
	{
		alert('时间不合理');
		return false;
	}

	return false;
}
</script>