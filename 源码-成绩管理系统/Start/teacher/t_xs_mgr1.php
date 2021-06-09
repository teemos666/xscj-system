<?php require_once('../../Connections/login.php'); ?>
<?php require_once('../../Connections/is_login.php'); ?>
<?php
// 允许上传的图片后缀
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
//echo $_FILES["file"]["size"];
$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2048000)   // 小于 2000 kb
&& in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        // 判断当前目录下的 upload 目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        if (file_exists("../../upload/" . $_FILES["file"]["name"]))
        {
            //echo $_FILES["file"]["name"] . " 文件已经存在。 ";
        }
        else
        {
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            move_uploaded_file($_FILES["file"]["tmp_name"], "../../upload/" . $_FILES["file"]["name"]);
            //echo "文件存储在: " . "../../upload/" . $_FILES["file"]["name"];
        }
    }
}
else
{
    
}
?>

<?php
if(isset($_POST['submit'])&&$_POST['submit']=="确定添加"){
	
	
	$num=$_POST['num'];
	$xm=$_POST['xm'];
	$sex=$_POST['sex'];
	$zym=$_POST['zym'];
	$note=$_POST['note'];
	//echo "<script>alert();";
	$zpn=$_FILES["file"]["name"];
	/*echo "<script>alert(\"";
	echo $zpn;
	echo "\");</script>";*/
	$zp=sprintf("%s%s/%s",dirname(dirname(dirname($_SERVER["PHP_SELF"]))),"/upload",$zpn); 
	$insertSQL = "INSERT INTO student (学号, 姓名, 性别, 专业名,总学分, 备注,照片) VALUES ('$num','$xm',\"$sex\",'$zym',55,'$note','$zp')";
	//echo $insertSQL;
  mysql_select_db($database_login, $login);
  $Result1 = mysql_query($insertSQL, $login) or die(mysql_error());
  echo "<script>alert(\"添加成功\");</script>";
  echo"<script>url=\"t_xs_msg.php";
  echo "\";window.location.href=url;</script>";
}

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="style/style.css" rel="stylesheet" type="text/css">

</head>

<body>
<div id="box">
<div id="xxi">
<form action="t_xs_mgr1.php" method="post" enctype="multipart/form-data">
<table width="670">
    <tr>
        <td width="250">姓名：</td>
        <td width="560">
        <input type="text" name="xm" placeholder="请输入姓名" required/>
        </td>
        <td rowspan="4">
        <img id="o_photo_img" src="" width=90 height=120 />
        </td>
    </tr>
    <tr>
        <td>学号：</td>
        <td><input type="text" name="num" placeholder="请输入学号" required/></td>
      </tr>
    <tr>
        <td>性别：</td>
        <td><select name="sex">
        <option value="男">男</option>
        <option value="女">女</option>
        </select></td>
      </tr>
    <tr>
        <td>专业名：</td>
        <td>
        <input type="text" name="zym" placeholder="请输入专业名" required/></td>
      </tr>
    <tr>
        <td>备注：</td>
        <td>
        <input type="text" name="note" placeholder="请输入备注"/></td>
        <td><input type="file" name="file" onchange="uploader(this.files)" accept="image/jpeg" />
        </td>
      </tr>
    <tr>
    <td></td>
    <td><input type="submit" name="submit" value="确定添加"/></td>
    
    </tr>
</table>


</form>
</div>

</div>


</div>

</body>
</html>

<script src="js/public.js"></script>

<?php
$sql1="select 照片 from student where 学号='s'";
 mysql_select_db($database_login, $login);
  $Result1 = mysql_query($sql1, $login) or die(mysql_error());
  $row = mysql_fetch_assoc($Result1);
  //echo "?????????:";
  //echo $row['照片'];
  //$ss=$row['照片'];
  //echo "::<br>";
  
  //o_photo_img
  
  
?>
<?php
echo "<script>document.getElementById('o_photo_img').setAttribute(\"src\",\"$ss\");</script>";
?>

