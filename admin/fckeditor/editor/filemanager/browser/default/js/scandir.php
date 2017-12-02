<?php

	header("content-type:text/html;charset=utf-8");

	$dir = "D:/wwwroot/2016117/php/php06";

	$files = scandir($dir);

	print_r($files);
?>