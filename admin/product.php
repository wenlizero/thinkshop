<?php
require_once"../config.php";
$page = 1;$num = 10;
$count = mysql_num_rows(mysql_query("select * from ts_product"));
$max = ceil($count/$num);
if(isset($_GET['page']))
{
	$page = $_GET['page'];
	if($page>$max)
	{
		$page = $max;
	}
	else if($page<1)
	{
		$page = 1;
	}
}
$start = ($page-1)*$num;
$product = fetchAll("select * from ts_product order by pid desc limit $start,$num");
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
    <td background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"><span><img src='./skin/images/frame/arr3.gif' style='margin-right:10px;'>商品管理</span></td>
	<td align="center" background="./skin/images/frame/wbg.gif" bgcolor="#EEF4EA" class='title' border="0px"width="100px"><a href="product_add.php">新增商品</a></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="2">
	<?php if($product){?>
		<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
			<tr align="center" bgcolor="#FBFCE2" height="25">
				<td width="6%">ID</td>
				<td width="4%">选择</td>
				<td width="28%">商品名称</td>
				<td width="10%">商品序列号</td>
				<td width="10%">商品分类</td>
				<td width="8%">发表时间</td>
				<td width="8%">是否上架</td>
				<td width="10%">操作</td>
			</tr>
  <!-- data start-->
  <?php
  foreach($product as $v){
  ?>
			<tr align='center' bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
				<td nowrap><?=$v['pid']?></td>
				<td>
					<input name="arcID" type="checkbox" value="<?=$v['pid']?>" class="np" />
				</td>
				<td align='left'>
					<span id="arc<?=$v['pid']?>">
						<a href='../product.php?pid=<?=$v['pid']?>' target="_blank">
							<u><?=$v['pname']?></u>
						</a>
					</span>
					<?php if($v['thumb'] !='' || $v['pimgs'] != ''){?>
					[<font color='red'>图片</font>]
					<?php }?>
				</td>
				<td><?=$v['pnums']?></td>
				<td><a href=''><?php 
				$sql='select pc_name from ts_product_cate where pc_id='.$v['p_c_id'];
				$ress = mysql_fetch_assoc(mysql_query($sql));
				echo $ress['pc_name'];?></a></td>
				<td><?=date('Y-m-d',$v['pubtime'])?></td>
				<td><a href="javascript:changeStatus(<?=$v['pid'].','.$v['ifshow']?>)"><?= $v['ifshow']==1 ? '上架' : '下架'?></a></td>
				<td>
					<a href="product_edit.php?pid=<?=$v['pid']?>"><img src='./skin/images/frame/trun.gif' title="编辑" alt="编辑" style='cursor:pointer' border='0' width='16' height='16' /></a>
					<a href="product_del.php?pid=<?=$v['pid']?>"><img src='./skin/images/frame/gtk-del.png' title="删除" alt="删除" style='cursor:pointer' border='0' width='16' height='16' /></a>
				</td>
			</tr>
  <?php }?>
  <!-- data end-->
  <!-- select start-->
	  <tr bgcolor="#ffffff">
		<td height="36" colspan="10">
			<a href="javascript:selAll()" class="coolbg">全选</a>
			<a href="javascript:noSelAll()" class="coolbg">取消</a>
			<a href="javascript:updateArc(0)" class="coolbg">反选</a>
			<a href="javascript:selDel()" class="coolbg">删除</a><!-- 一次性删除选中 -->
		</td>
	  </tr>
  <!-- select end-->
  <!-- page start-->
      <? if(isset($page)){?>
	  <tr align="right" bgcolor="#F9FCEF">
		<td height="36" colspan="10" align="center">
			<div class="pagelistbox">
				<span>共 <?=$max?> 页/<?=$count?>条记录 </span>
				<a class='indexPage' href="product.php?page=1">首页 </a>
				<? if($page>1){?>
				<a class='prevPage' href='product.php?page=<?=$page-1?>'>上页</a> 
				<? }?>
				<? 	for($i=1;$i<=$max;$i++){
					if($i==$page){
				?>
					<strong><?=$i?></strong>
				<? }else{?>	
					<a href="product.php?page=<?=$i?>"><?=$i?></a>
				
				<? }}if($page<$max){?>
				<a class='nextPage' href='product.php?page=<?=$page+1?>'>下页</a> 
				<? }?>
				<a class='endPage' href='product.php?page=<?=$max?>'>末页</a> 
				</div>
			</td>
	  </tr>
	  <? }?>
  <!-- page end-->
  <tr>
	<td colspan="2"><input type='button' class="coolbg np" onClick="location='product_add.php?';" value='新增商品'/></td>
  </tr>
</table>
<?php }else{echo "<b>暂无商品</b>";}?>
</body>
</html>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
/*删除选中：id   :   1,2,3,4  */
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
				str += arr[i].value+','; //由选中id组成的字符串
			}
		}
	}
	alert(str)
	if(str !='')
	{
		var res = confirm("确定删除？");
	}
	if(res)
	{
		location.href="product_del.php?ids="+str;
	}
}
/*修改上架下架状态*/
function changeStatus(id,ifshow)
{
	var table = 'ts_product';
	location.href = 'change.php?id='+id+'&ifshow='+ifshow+'&table='+table;
}
</script>