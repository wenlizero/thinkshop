<?php
require_once"config.php";
if(!isset($_COOKIE['username']))
{
	msg("请先登录","login.php");exit;
}
//新增收货地址
if(isset($_POST['addrSave']))
{	//print_r($_POST);DIE;
	extract($_POST);
	if(isset($_COOKIE['user_id']))
	{
		$u_id = $_COOKIE['user_id'];
		$array = array('consignee'=>trim($consignee),'address'=>trim($address),'mobile'=>trim($mobile),'u_id'=>$u_id);
		//判断是否设置为默认地址
		if(isset($addr_default) && $addr_default==1)
		{
			$array['addr_default']=1;
			//取消原本的默认地址
			$sql = "select addr_default,addr_id from ts_address where u_id=$u_id";
			$addr = fetchAll($sql);
			if(count($addr)>0)
			{
				foreach($addr as $v)
				{
					if($v['addr_default'] == 1)
					{ 
						update(array('addr_default'=>0) ,'ts_address' ,"addr_id=".$v['addr_id']);
					}
				}
			}
		}
		if($type=="addrEdit")
		{
			$res = update($array , 'ts_address' , "addr_id=$addr_id");
		}
		else
		{
			$res = insert($array , 'ts_address');
		}
		
		if($res)
		{
			if($type==1)
			{
				msg('保存成功','order.php?type='.$type);exit;
			}else{
				msg('保存成功','user.php?type=address');exit;
			}		
		}
	}
}
//删除收货地址
if(isset($_GET['id']))
{
	extract($_GET);
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
		msg('删除成功','order.php?type='.$type);exit;
	}
}


?>
