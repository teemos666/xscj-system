<?php require_once('../../Connections/login.php'); ?>
<?php require_once('../../Connections/is_login.php'); ?>
<?php
//GET接受课程数据
if(isset($_GET['kcm'])){
	$_kcm=$_GET['kcm'];
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
	//---
	 
	 
	$currentPage = $_SERVER["PHP_SELF"];
	//$currentPage = $_SERVER['REQUEST_URI'];
	

$maxRows_cj_rank = 10;
$pageNum_cj_rank = 0;
if (isset($_GET['pageNum_cj_rank'])) {
  $pageNum_cj_rank = $_GET['pageNum_cj_rank'];
}
$startRow_cj_rank = $pageNum_cj_rank * $maxRows_cj_rank;

mysql_select_db($database_login, $login);
$query_cj_rank = "select 学号,姓名,课程号,课程名,学分,成绩,排名
from(
select 学号,课程号,课程名,学分,成绩,@currank := @currank+1 as 排名
from 
(select 学号,课程号,kc.课程名,cj.学分,成绩
from cj
join kc
using(课程号)
where 课程名='$_kcm'
order by 成绩 desc) a
join (select @currank := 0 ) q
) b
join student
using(学号)";
$query_limit_cj_rank = sprintf("%s LIMIT %d, %d", $query_cj_rank, $startRow_cj_rank, $maxRows_cj_rank);
$cj_rank = mysql_query($query_limit_cj_rank, $login) or die(mysql_error());
$row_cj_rank = mysql_fetch_assoc($cj_rank);

if (isset($_GET['totalRows_cj_rank'])) {
  $totalRows_cj_rank = $_GET['totalRows_cj_rank'];
} else {
  $all_cj_rank = mysql_query($query_cj_rank);
  $totalRows_cj_rank = mysql_num_rows($all_cj_rank);
}
$totalPages_cj_rank = ceil($totalRows_cj_rank/$maxRows_cj_rank)-1;


}
//--------------------




?>
<?php
//下拉框
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
mysql_select_db($database_login, $login);
$query_Recordset1 = "SELECT * FROM kc";
$Recordset1 = mysql_query($query_Recordset1, $login) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="style/style.css" rel="stylesheet" type="text/css">

</head>

<body>
<script>
function xuanze(){
       document.getElementById("in_kc").value=document.getElementById("sel").value;
	   document.getElementById('submit0').click();
     }
</script>
<div id="search">
<div id="top1">
课程名:
<select id="sel" onchange="xuanze()">
<option>请选择课程</option>
<?php do { ?>
<option value="<?php echo $row_Recordset1['课程名']; ?>"><?php echo $row_Recordset1['课程名']; ?></option>
<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</select>
</div>
    <form id="kc_search" name="kc_search" method="get" action="s_all_rank.php" hidden="">
      <p>
        <label for="password"></label>
        搜索课程：<input type="text" name="in_kc" id="in_kc" placeholder="请输入课程号或课程名"/>
        <?php 
		if (isset($_REQUEST['kcm'])){
			echo "<input type=\"hidden\"  name=\"kcm\" value=\"";
			echo $_REQUEST['kcm'];
			echo "\"/>";
		}
		if(isset($_GET['in_kc'])){
			$words=$_GET['in_kc'];
			echo "<script>document.getElementById('in_kc').value = $words;</script>";	
			echo "<script>document.getElementById('sel').value = \"$words\";</script>";
			
			
		}
		
		?>
        
        <input type="submit" name="submit" id="submit0" value="点击搜索" />
       
      </p>
    </form>
<?php
	//搜索课程
if(isset($_GET['submit'])){
	mysql_select_db($database_login, $login);
	$words=$_GET['in_kc'];
	$query_search_kc = "select 课程号,课程名,学时,学分 from kc where 课程名 like '%$words%' or 课程号 like '%$words%'";
	$search_kc = mysql_query($query_search_kc, $login) or die(mysql_error());
	$row_search_kc = mysql_fetch_assoc($search_kc);
	$totalRows_search_kc = mysql_num_rows($search_kc);
	
	//+++++
	$queryString_kcm = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cj_rank") == false && 
        stristr($param, "totalRows_cj_rank") == false &&
		stristr($param, "kcm") == false){
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_kcm = "&" . htmlentities(implode("&", $newParams));
  }
}
	/*echo "<div id=\"title_r\">";
    echo "<ul>";
    echo "<li>课程号</li>";
    echo "<li>课程名</li>";
    echo "<li>学时</li>";
    echo "<li>学分</li>";
    echo "<li>查询</li>";
    echo "</ul>";
 	echo "</div>";
	//-------------------------
	echo "<div id=\"res\">";
	echo "<div class=\"list_r\">";
    echo "<ul>";
    echo "<li>";echo $row_search_kc['课程号']; echo "</li>";
    echo "<li>";echo $row_search_kc['课程名']; echo "</li>";
    echo "<li>";echo $row_search_kc['学时']; echo "</li>";
    echo "<li>";echo $row_search_kc['学分']; echo "</li>";
    echo "<li>[
	<a href=\"";
	printf("%s?kcm=%s%s", $currentPage, $row_search_kc['课程名'],$queryString_kcm); 
	echo "\">查询</a>
	]</li>";
    echo "</ul>";
    echo "</div>";
	echo "</div>";*/
echo "<script>var url=\"";
printf ("%s?kcm=%s%s", $currentPage, $row_search_kc['课程名'],$queryString_kcm); 	
echo "\";window.location.href=url;</script>";
}
?>
</div>
<div id="box">
<?php
//输出计数
if(isset($_GET['kcm']))
{
	
	
	echo "<div id=\"jishu\">共有 ";
	echo $totalRows_cj_rank ; 
	echo "条记录，目前显示第";
	echo ($startRow_cj_rank + 1);
	echo "条至第";
	echo min($startRow_cj_rank + $maxRows_cj_rank, $totalRows_cj_rank);
	echo "条</div>";
}
?>
<div id="title1">
        <ul>
        	<li>学号</li>
      	  	<li>姓名</li>
         	<li>课程号</li>
        	<li>课程名</li>
        	<li>学分</li>
        	<li>成绩</li>
        	<li>排名</li>
    	</ul>
</div>

<div id="sss" class="list2" style="text-align:center;">目前还没有搜索任何信息</div>
 
    
<?php
//输出课程查询
if(isset($_GET['kcm']))
{
	$queryString_cj_rank = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cj_rank") == false && 
        stristr($param, "totalRows_cj_rank") == false &&
		stristr($param, "kcm") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cj_rank = "&" . htmlentities(implode("&", $newParams));
  }
}
/*$queryString_cj_rank = sprintf("&totalRows_cj_rank=%d%s", $totalRows_cj_rank, $queryString_cj_rank);*/
	
	echo "<script>document.getElementById(\"sss\").style.display=\"none\";</script>"; 
	
	
	
	
	 do { 
		echo "<div class=\"list1\">";
		 echo " <ul>";
		 echo "  <li>";echo $row_cj_rank['学号'];  echo "</li>";
		 echo "  <li>";echo $row_cj_rank['姓名'];  echo "</li>";
		  echo "  <li>";echo $row_cj_rank['课程号'];  echo "</li>";
		   echo " <li>";echo $row_cj_rank['课程名']; echo "</li>";
		   echo " <li>";echo $row_cj_rank['学分'];  echo "</li>";
		   echo " <li>";echo $row_cj_rank['成绩']; echo "</li>";
		   echo " <li>";echo $row_cj_rank['排名'];  echo "</li>";
		echo "  </ul>";
	   echo " </div>";
	   
		 } while ($row_cj_rank = mysql_fetch_assoc($cj_rank)); 
		 
	    if ($totalRows_cj_rank == 0) {
    echo "<div class=\"list2\" style=\"text-align:center;\">目前还没有添加任何信息</div>";
   } 
	
	
	   
	
	echo "<div id=\"menu\">";
	if ($pageNum_cj_rank > 0) {
		echo "<a href=\"";
		printf("%s?kcm=%s&pageNum_cj_rank=%d%s", $currentPage,$_GET['kcm'],  0, $queryString_cj_rank);
		echo "\">第一页</a> ";
	}
	//----
	if ($pageNum_cj_rank > 0) {
		echo "<a href=\"";
		printf("%s?kcm=%s&pageNum_cj_rank=%d%s", $currentPage,$_GET['kcm'],  max(0, $pageNum_cj_rank - 1), $queryString_cj_rank); 
		echo "\">上一页</a> ";
	}
	//----
	if ($pageNum_cj_rank < $totalPages_cj_rank) {
		echo "<a href=\"";
		printf("%s?kcm=%s&pageNum_cj_rank=%d%s", $currentPage,$_GET['kcm'], min($totalPages_cj_rank, $pageNum_cj_rank + 1), $queryString_cj_rank);
		echo "\">下一页</a> ";
	}
	if ($pageNum_cj_rank < $totalPages_cj_rank) {
		echo "<a href=\"";
		printf("%s?kcm=%s&pageNum_cj_rank=%d%s",  $currentPage, $_GET['kcm'],$totalPages_cj_rank, $queryString_cj_rank); 
		echo "\">最后一页</a> ";
	}
	echo "</div>";
}

///-------------------------
?>


</div>





</body>
</html>

<?php
/*echo $_SERVER["PHP_SELF"];
echo "<br>";
echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
echo "<br>";
echo $_SERVER['HTTP_HOST'];
echo "<br>";
echo $_SERVER['REQUEST_URI'];
echo "<br>";
echo $_SERVER['QUERY_STRING'];*/
?>