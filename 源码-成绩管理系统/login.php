<?php
if(isset($_COOKIE['admin'])){
	echo "<script>window.location.href=\"index.php\";</script>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>成绩管理系统</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="header" id="head">
	<div class="tittle"><br />学生成绩管理系统</div>
</div>
<div id="wrap">
    <form id="user" name="user" method="POST" action="Connections/cookies.php">
        <div class="logGet">
            <!-- 头部提示信息 -->
            <div class="logDtip">
                <p class="p1">&nbsp;&nbsp;登录</p>
            </div>
            <!-- 输入框 -->
            <div class="lgD">
            
            <label for="username"></label>
            <span class="u_user"></span>
            <input type="text" name="username" id="username" maxlength="16" placeholder="请输入用户名" required/>
            </div>
            
            <div class="lgD">
            <label for="password"></label>
            <span class="us_uer"></span>
            <input type="password" name="password" id="password" maxlength="16" placeholder="请输入密码" required/>
            </div>
          <div class="logC">
            <input type="submit" name="submit" id="submit" value="登录" />
          </div>
        </div>
    </form>
</div>


<div id="foot">
<br />
Copyright © 2020 Silly Bear，All Rights Reserved.
<br />
联系邮箱：zzxxccsung@qq.com
</div>

</body>
</html>