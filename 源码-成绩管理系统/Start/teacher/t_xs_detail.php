<?php require_once('../../Connections/login.php'); ?>
<?php require_once('../../Connections/is_login.php'); ?>
<?php
$num=$_GET['num'];
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_cj_msg = 10;
$pageNum_cj_msg = 0;
if (isset($_GET['pageNum_cj_msg'])) {
  $pageNum_cj_msg = $_GET['pageNum_cj_msg'];
}
$startRow_cj_msg = $pageNum_cj_msg * $maxRows_cj_msg;

mysql_select_db($database_login, $login);
$query_cj_msg = "SELECT 姓名,学号,课程号,课程名,kc.学分,成绩,my_cj_one('$num',课程名) as 排名 FROM cj join kc using(课程号) join student using(学号) WHERE 学号='$num'";
$query_limit_cj_msg = sprintf("%s LIMIT %d, %d", $query_cj_msg, $startRow_cj_msg, $maxRows_cj_msg);
$cj_msg = mysql_query($query_limit_cj_msg, $login) or die(mysql_error());
$row_cj_msg = mysql_fetch_assoc($cj_msg);

if (isset($_GET['totalRows_cj_msg'])) {
  $totalRows_cj_msg = $_GET['totalRows_cj_msg'];
} else {
  $all_cj_msg = mysql_query($query_cj_msg);
  $totalRows_cj_msg = mysql_num_rows($all_cj_msg);
}
$totalPages_cj_msg = ceil($totalRows_cj_msg/$maxRows_cj_msg)-1;

$queryString_cj_msg = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cj_msg") == false && 
        stristr($param, "totalRows_cj_msg") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cj_msg = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cj_msg = sprintf("&totalRows_cj_msg=%d%s", $totalRows_cj_msg, $queryString_cj_msg);
?>

<?php
$num=$_GET['num'];
mysql_select_db($database_login, $login);
$query_stu_msg = "SELECT * FROM student WHERE 学号='$num'";

$stu_msg = mysql_query($query_stu_msg, $login) or die(mysql_error());
$row_stu_msg = mysql_fetch_assoc($stu_msg);

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
<table width="660">
    <tr>
        <td width="105">姓名：</td>
        <td width="550"><?php echo $row_stu_msg['姓名']; ?></td>
        <td rowspan="4"><img id="zp" src="<?php echo $row_stu_msg['照片'];?>" width=90 height=120 /></td>
    </tr>
    <tr>
        <td>学号：</td>
        <td><?php echo $row_stu_msg['学号']; ?></td>
      </tr>
    <tr>
        <td>性别：</td>
        <td><?php echo $row_stu_msg['性别']; ?></td>
      </tr>
    <tr>
        <td>专业名：</td>
        <td><?php echo $row_stu_msg['专业名']; ?></td>
      </tr>
    <tr>
        <td>备注：</td>
        <td><?php echo $row_stu_msg['备注']; ?></td>
      </tr>
    
</table>

</div>
<div id="kecheng">
  <div id="jishu">共有 <?php echo $totalRows_cj_msg ?> 条记录，目前显示第<?php echo ($startRow_cj_msg + 1) ?>条至第<?php echo min($startRow_cj_msg + $maxRows_cj_msg, $totalRows_cj_msg) ?>条</div>
  <div id="title1">
        <ul>
          <li>姓名</li>
          <li>学号</li>
          <li>课程号</li>
          <li>课程名</li>
          <li>课程学分</li>
          <li>成绩</li>
          <li>该科排名</li>
    </ul>
  </div>
  <div id="查询框">
  <?php do { ?>
    <div class="list1">
      <ul>
        <li><?php echo $row_cj_msg['姓名']; ?></li>
        <li><?php echo $row_cj_msg['学号']; ?></li>
        <li><?php echo $row_cj_msg['课程号']; ?></li>
        <li><?php echo $row_cj_msg['课程名']; ?></li>
        <li><?php echo $row_cj_msg['学分']; ?></li>
        <li><?php echo $row_cj_msg['成绩']; ?></li>
        <li><?php echo $row_cj_msg['排名']; ?></li>
      </ul>
    </div>
    <?php } while ($row_cj_msg = mysql_fetch_assoc($cj_msg)); ?>
    </div>
  <?php if ($totalRows_cj_msg == 0) { // Show if recordset empty ?>
    <div class="list2" style="text-align:center;">目前还没有添加任何信息</div>
  <?php } // Show if recordset empty ?>
<div id="menu">
  <?php if ($pageNum_cj_msg > 0) { // Show if not first page ?>
    <a href="<?php printf("%s?pageNum_cj_msg=%d%s", $currentPage, 0, $queryString_cj_msg); ?>">第一页</a>
    <?php } // Show if not first page ?>
　
<?php if ($pageNum_cj_msg > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_cj_msg=%d%s", $currentPage, max(0, $pageNum_cj_msg - 1), $queryString_cj_msg); ?>">上一页</a>
  <?php } // Show if not first page ?>
　
<?php if ($pageNum_cj_msg < $totalPages_cj_msg) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_cj_msg=%d%s", $currentPage, min($totalPages_cj_msg, $pageNum_cj_msg + 1), $queryString_cj_msg); ?>">下一页</a>
  <?php } // Show if not last page ?>
　
<?php if ($pageNum_cj_msg < $totalPages_cj_msg) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_cj_msg=%d%s", $currentPage, $totalPages_cj_msg, $queryString_cj_msg); ?>">最后一页</a>
  <?php } // Show if not last page ?>
</div>
</div>
<button onclick="tiao()">修改信息</button>
<button onclick="tiao1()">删除该学生</button>
<form action="t_xs_detail.php" method="post" hidden="">
    <input type="text" id="num" name="num" required />
    <input type="submit" name="shanchu" id="shanchu" value="删除该学生" />
</form>
</div>




</body>
</html>
<script>
function tiao(){
	var url="t_xs_mgr2.php?num=<?php echo "$num";?>";
	window.location.href=url;
}
function tiao1(){
	var text="<?php echo $num;?>";
	  document.getElementById('num').setAttribute("value",text);
		var r=confirm("确定删除？");
		if (r == true) {
			document.getElementById('shanchu').click();
			} 
}  
</script>
<?php
if ((isset($_POST["shanchu"])) && ($_POST["shanchu"] == "删除该学生")){
	$SQL = sprintf("DELETE FROM student WHERE 学号=%s",
					   GetSQLValueString($_POST["num"], "text"));
  mysql_select_db($database_login, $login);
  $Result1 = mysql_query($SQL, $login) or die(mysql_error());
  /*echo"<script>alert(\"";
  echo $_POST["num"];
  echo "\");</script>";*/
  echo"<script>alert(\"删除成功！\");url=\"t_xs_msg.php";
  echo "\";window.location.href=url;</script>";
}
?>
<?php
mysql_free_result($cj_msg);
?>
