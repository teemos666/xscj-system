<?php require_once('../Connections/is_login.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="style/style.css" rel="stylesheet" type="text/css">

</head>

<body>
<div id="box">
  <div id="left">
  <div class="anniu">
  	<a href="teacher/t_xs_msg.php" target="kuang">学生管理</a>
  </div>
  <div class="anniu">
  	<a href="teacher/t_xs_kc_mgr.php" target="kuang">课程管理</a>
  </div>
  <div class="anniu">
  	<a href="student/s_all_rank.php" target="kuang">各科成绩</a>
  </div>
   <div class="anniu">
  	<a href="teacher/t_one_key.php" target="kuang">一键管理</a>
  </div>
  
  </div>
  <div id="right">
    
    <div id="main-title">
    </div>
    <div id="main-bg">
    	<iframe src="teacher/t_xs_msg.php" scrolling="auto" name="kuang">
        </iframe>
      
      

    </div>
  </div>
</div>




</body>
</html>