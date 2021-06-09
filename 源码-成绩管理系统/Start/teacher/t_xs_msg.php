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



$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_login, $login);
$query_Recordset1 = "SELECT * FROM student";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $login) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
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

    <div id="jishu">共有<?php echo $totalRows_Recordset1 ?> 条记录，目前显示第<?php echo ($startRow_Recordset1 + 1) ?>条至第<?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?>条</div>
      <div id="title1">
        <ul>
          <li>学号</li>
          <li>姓名</li>
          <li>性别</li>
          <li>专业名</li>
          <li>总学分</li>
          <li>备注</li>
          <li>操作</li>
        </ul>
      </div>
      <?php do { ?>
        <div class="list1">
          <ul>
            <li><?php echo $row_Recordset1['学号']; ?></li>
            <li><?php echo $row_Recordset1['姓名']; ?></li>
            <li><?php echo $row_Recordset1['性别']; ?></li>
            <li><?php echo $row_Recordset1['专业名']; ?></li>
            <li><?php echo $row_Recordset1['总学分']; ?></li>
            <li><?php echo $row_Recordset1['备注']; ?>&nbsp;</li>
            <li>[<a target="kuang" href="t_xs_detail.php?num=
			<?php echo $row_Recordset1['学号'];?>">查看详情</a>]</li>
          </ul>
          
        </div>
        
        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        
        <?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
  <div class="list2" style="text-align:center;">目前还没有添加任何信息</div>
  <?php } // Show if recordset empty ?>
  <div id="menu">
    <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">第一页</a>
      <?php } // Show if not first page ?>
　
<?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">上一页</a>
  <?php } // Show if not first page ?>
　
<?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">下一页</a>
  <?php } // Show if not last page ?>
　
<?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">最后一页</a>
  <?php } // Show if not last page ?>
  </div>
    
  <button onclick="tiao()">添加学生信息</button>
</div>




</body>
</html>
<script>
function tiao(){
	var url="t_xs_mgr1.php";
	window.location.href=url;
}
</script>
<?php
mysql_free_result($Recordset1);
?>
