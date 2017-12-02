<?php

	header("content-type:text/html;charset=utf-8");


	$dir = "D:/wwwroot/2016117/php/php06";
	if(!is_dir($dir))
		exit("目标目录不存在");
	$re = @opendir($dir);
	if(!is_resource($re))
		exit("目标目录打开失败");
	echo readdir($dir)."<br/>";

	closedir($re);
?>