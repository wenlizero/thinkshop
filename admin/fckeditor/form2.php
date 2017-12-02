<?
include_once("../mysql/config.php");
//include_once("../mysql/tiaozhuan.php");
if(isset($_POST['message']) && !empty($_POST['message']) && isset($_POST['title']) && !empty($_POST['title'])){

// myTime('提交成功',"./form.php?message={$_GET['message']}",5);
$title=mysql_real_escape_string($_POST['title']);
$content=mysql_real_escape_string($_POST['message']);
$sql="insert into liuyan values(null,'aa',null,'{$_SERVER['REMOTE_ADDR']}','{$content}','{$title}')";
$result=mysql_query($sql));
}



?>