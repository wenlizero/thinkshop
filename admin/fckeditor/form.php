<html>
<head>
<style type="text/css">
#submit{
font:18px "����";
color:white;
width:100px;
height:50px;
background:gray;
border:0px;
}
</style>
</head>
<body>
<form action="form.php" method="post" enctype="multipart/form-data">
<h4>�ؼ���<h4>
<input type="text" maxlength="14" size="14" style="width:200px;height:40px;" name="title" />
<br />
<?php  include_once('index.php'); ?>
<br />
&nbsp;<input type="submit" value="�ύ����" id="submit" />
</form>
<br />
<br />
<hr />
<?php
echo $_POST['content'];


?>
</body>
</html>