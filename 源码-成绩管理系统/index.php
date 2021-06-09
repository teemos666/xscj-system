<?php require_once('Connections/login.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/index.css" rel="stylesheet" type="text/css">
<title>无标题文档</title>
</head>

<body>
<div id="top">
	<span id="times"></span>
	<span id="zhong">欢迎使用成绩管理系统</span>
    <a id="tuichu" href="Connections/exit.php">安全退出&nbsp;</a>
</div>
<!--<iframe src="Start/teacher.php" width="100%" scrolling="no"></iframe>-->

<div id="head">
</div>
<iframe id="kuang" src="" width="100%" height="80%" scrolling="auto" frameborder="0">
</iframe>
</body>
</html>

<?php
/*echo"<script>var link=document.getElementById(\"kuang\");</script>";
		echo"<script>link.src=\"Start/teacher.php\";</script>";*/
?>
<?php 
//检查是否已经登录，如果登录了就判断权限
$cookee=$_COOKIE["admin"];

if(!isset($_COOKIE['admin'])){
	echo "<script>alert(\"请先登录!\");window.location.href=\"login.php\";</script>";
}
else{
	$cookee=$_COOKIE["admin"];
	$sql="select power from user where username='$cookee'";
		
	mysql_select_db("marks",$login);
	$result = mysql_query($sql,$login);
	$row = mysql_fetch_assoc($result);
	if ($row['power']=='1') {
		//如果是老师
		echo"<script>var link=document.getElementById(\"kuang\");</script>";
		echo"<script>link.src=\"Start/teacher.php\";</script>";
		} 
	else{
		//如果是学生
		echo"<script>var link=document.getElementById(\"kuang\");</script>";
		echo"<script>link.src=\"Start/student.php\";</script>";
	}
}
?>
