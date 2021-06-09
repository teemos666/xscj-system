<?php require_once('login.php'); ?>
<?php
header("Content-Type:text/html;charset=utf-8");

	//error_reporting(0);//关闭所有报告错误
if(!isset($_COOKIE['admin'])){
	//没有cookie登录
	if(isset($_POST['username']) && isset($_POST['password'])){
		$uname=$_POST["username"];
		$password=$_POST["password"];
		$sql="select username,password from user where username='$uname' and password='$password'";
		
		mysql_select_db($database_login, $login);
		$result = mysql_query($sql,$login);
		$row = mysql_fetch_assoc($result);
		$cookee=$row["username"];
		if ($row) {
			
			echo "成功";
			setcookie("admin",$cookee,time()+3600,'/');
			echo"<script>url=\"../index.php\";window.location.href=url;</script>";
			
		} else {
			echo "登录失败!<br>";
			echo"<script>alert(\"登录失败！\");</script>";
			echo"<script>url=\"../login.php\";window.location.href=url;</script>";
		}
		//echo "没有cookie登录<br>";
	}
}
else
{
//有cookies
echo "有<br>";
	if(!isset($_POST['exit']))
		{
	//没有点退出
			$cookee = $_COOKIE['admin'];
			echo "cookie:",$cookee;
			echo"<script>url=\"../index.php\";window.location.href=url;</script>";
		}	
	else
		{
			//点了退出
		
				setcookie('admin', $row1['username'], time()-3600,'/');
				//header ('Location: index.php');
				echo "已经退出\n";
		}		
}
?>
<form id="user" name="user" method="POST" action="cookies.php">
  
  <p>
    <input type="submit" name="exit" id="exit" value="退出"/>
  </p>
</form>