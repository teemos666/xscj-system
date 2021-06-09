<?php 
if(isset($_COOKIE['admin'])){
	//防止用户查看页面各个子页面
	$headers = apache_request_headers();
	if(strstr($_SERVER["PHP_SELF"],"t_") or strstr($_SERVER["PHP_SELF"],"s_")){
		if(!strstr($headers["Referer"],$_SERVER['HTTP_HOST'])){
			echo "<script>
		window.location.href=\"../../index.php\";</script>";
		}
	}
	elseif (strstr($_SERVER["PHP_SELF"],"teacher.php") or strstr($_SERVER["PHP_SELF"],"student.php")){
		if(!strstr($headers["Referer"],$_SERVER['HTTP_HOST'])){
			echo "<script>
		window.location.href=\"../index.php\";</script>";
		}
	}
}
else{
	//防止用户未登录则使用该系统
	if(strstr($_SERVER["PHP_SELF"],"t_") or strstr($_SERVER["PHP_SELF"],"s_")){
		echo "<script>alert(\"请先登录!\");
		window.location.href=\"../../login.php\";</script>";	
	}
	elseif (strstr($_SERVER["PHP_SELF"],"teacher.php") or strstr($_SERVER["PHP_SELF"],"student.php")){
		echo "<script>alert(\"请先登录!\");
		window.location.href=\"../login.php\";</script>";	
	}
	else {
		echo "<script>alert(\"请先登录!\");
		window.location.href=\"login.php\";</script>";	
	}
}
?>