<?php
include_once("./fckeditor/fckeditor.php");
$fckeditor = new FCKeditor("introduce");//定义默认值 name
$fckeditor->Width = "300px";//定义编辑器的宽度
$fckeditor->Height = "200px";//定义编辑器的高度
$fckeditor->Value = "hello world";//定义默认值
$fckeditor->BasePath='./fckeditor/';
$fckeditor->ToolbarSet = "Basic";
$fckeditor->Create();//创建编辑器
?>
