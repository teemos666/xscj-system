<?php require_once('../../Connections/login.php'); ?>
<?php require_once('../../Connections/is_login.php'); ?>
<?php
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
$name=$_COOKIE["admin"];
mysql_select_db($database_login, $login);
$query_cj_msg = "SELECT 姓名,学号,课程号,课程名,kc.学分,成绩,my_cj_one('$name',课程名) as 排名 FROM cj join kc using(课程号) join student using(学号) WHERE 学号='$name'";
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="style/style.css" rel="stylesheet" type="text/css">

</head>

<body>
<div id="box">

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




</body>
</html>
<?php
mysql_free_result($cj_msg);
?>
