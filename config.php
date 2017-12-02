<?php
const HOST = 'localhost:3306';
const USER = 'root';
const PWD  = '123';
const DB   = 'thinkshop';
const CHAR = 'set names utf8';

$link =@mysql_connect(HOST,USER,PWD);
if(!is_resource($link))
{
	error();exit;
}
if(!mysql_select_db(DB))
{
	error();exit;
}
if(!mysql_query(CHAR))
{
	error();exit;
}

/*数据库报错函数*/
function error()
{
	echo mysql_errno().':'.mysql_error();
}
/*提示信息*/
function msg($tip,$url)
{
	echo "<script>alert('$tip');location.href='$url';</script>";
}
/*增删改查函数*/
//增加
function insert($array,$table)
{
    $keys=join(',',array_keys($array));
    $values="'".join("','", array_values($array))."'"; 
	$sql="INSERT INTO {$table} ({$keys}) VALUES ({$values})";
	echo mysql_error();
    $res=mysql_query($sql);
    if($res)
	{
        return mysql_insert_id();
    }
	else
	{
        return false;
    }
}
//修改
function update($array,$table,$where='1=1')
{
	$sets='';
    foreach ($array as $key=>$val)
	{
        $sets.=$key."='".$val."',";
    }
    $sets=rtrim($sets,','); //去除右边的逗号
    $sql="UPDATE {$table} SET {$sets} WHERE {$where}";
    $res=mysql_query($sql);
    if ($res)
	{
        return mysql_affected_rows();
    }
	else 
	{
        return false;
    }
}
//删除
function delete($table,$where=null)
{
    $where=$where==null?'':' WHERE '.$where;
    $sql="DELETE FROM {$table} {$where}";
    $res=mysql_query($sql);
    if ($res)
	{
        return mysql_affected_rows();
    }
	else 
	{
        return false;
    }
}
//查询
function fetchAll($sql,$result_type=MYSQL_ASSOC)
{
    $result=mysql_query($sql);
	$array = array();
    if (is_resource($result) && mysql_num_rows($result)>0)
	{
        while(($arr = mysql_fetch_array($result , $result_type)) !==false)
		{
			$array[] = $arr;
		}
		return $array;
    }
	else 
	{
        return false;
    }
}
/*获取产品分类*/
function  getCate($cate, $fid=0)
{
	static $arr = array();
	foreach($cate as $vo)
	{
		if($vo['pc_fid'] == $fid)
		{
			$arr[] = $vo;
			getCate($cate,$vo['pc_id']);
		}
	}
	return $arr;
}
$sql = "select * from ts_product_cate";
$arr = fetchAll($sql);
$product_cate = getCate($arr);
/*获取新闻分类*/
function  getCate1($cate1, $fid1=0)
{
	static $arr1 = array();
	foreach($cate1 as $vo1)
	{
		if($vo1['fid'] == $fid1)
		{
			$arr1[] = $vo1;
			getCate1($cate1,$vo1['cid']);
		}
	}
	return $arr1;
}
$sql1 = "select * from ts_news_cate";
$arr1 = fetchAll($sql1);
$news_cate = getCate1($arr1);
/*
功能：单文件上传
参数：文件预定义变量$_FILES['value'] , 上传目录$dir , 类型数组$arr_type
返回值：成功path文件路径  失败false
*/
function  uploadFile($file , $dir="uploads/" , $arr_type=array("jpg" , "jpeg" , "png" , "bmp" , "gif" ))
{
	extract($file);//$name , $tmp_name, $error
	/*1判断是否有文件上传*/
	if(empty($name))
	{
		return false;
	}
	/*2判断目录*/
	if(!is_dir($dir))
	{
		mkdir($dir , 0777 , true);
	}
	/*3判断类型*/
	$type=substr(strrchr($name , ".") , 1);
	if(!in_array($type , $arr_type))
	{
		return false;
	}
	/*4判断是否出错*/
	if($error != 0)
	{
		return false;
	}
	/*5临时文件是否存在*/
	if(!is_uploaded_file($tmp_name))
	{
		return false;
	}
	/*6判断写入是否成功*/
	$path = $dir . date("YmdHis").rand(1000,9999) . ".". $type;
	if(!move_uploaded_file($tmp_name, $path))
	{
		return false;
	}
	else
	{
		return $path;
	}
}
/*
功能：多文件上传
参数：文件预定义变量$_FILES['value'] , 上传目录$dir , 类型数组$arr_type
返回值：成功path路径  失败false
*/
function moreFiles($files,$dir = 'uploads/',$arr_type = array("jpg" , "jpeg" ,"png" ,"gif" , "bmp"))
{
	/*第一步：判断是否有文件上传*/
	$path_str=''; //用于保存所有文件路径
	$name_arr = $files['name'];
	$name_str = implode("", $name_arr);
	if(empty($name_str))
	{
		return false;
	}
	/*第二步：判断上传目录是否存在，不存在则创建*/
	if( ! is_dir($dir))
	{
		mkdir($dir , 0777 , true);
	}
	/*循环判断*/
	for($i = 0 ; $i<count($name_arr) ; $i++)
	{
		if(empty($name_arr[$i]))
		{
			continue;
		}
		/*第三步：判断文件类型*/
		$res  = explode(".",$name_arr[$i]);
		$type = end($res);
		if( ! in_array(strtolower($type) , $arr_type))
		{
			continue;
		}
		/*第四步：判断error*/
		$error_arr = $files['error'];
		if($error_arr[$i] !=0)
		{
			continue;
		}
		/*第五步：判断临时文件是否存在*/
		$tmp_name_arr = $files['tmp_name'];
		if( ! is_uploaded_file($tmp_name_arr[$i]))
		{
			continue;
		}
		/*第六步：判断文件上传是否成功*/
		$path = $dir . date("YmdHis").rand(100,99999).".".$type;
		if(move_uploaded_file($tmp_name_arr[$i] , $path))
		{
			$path_str = $path_str.$path.',';
		}
		else
		{
			continue;
		}
	}
	//最终的文件路径不是空则正确
	if(!empty($path_str))
	{
		return $path_str;
	}
	else
	{
		return false;
	}
}
/*
	查出该类的所有子类，子子类
*/
function getChildCate($pc_id)
{
	static $str_id = "";
	if($pc_id)
	{
		$sql = "select pc_id from ts_product_cate where pc_fid =".$pc_id;
		$result = fetchAll($sql);
		if($result !=false)
		{	
			foreach($result as $v)
			{
				$str_id .=$v['pc_id'].',';
				getChildCate($v['pc_id']);	
			}
		}
	}
	return $str_id;
}
/*
获取网站配置项
*/
$config = array();
$config = fetchAll( "select * from ts_sysconfig");
?>