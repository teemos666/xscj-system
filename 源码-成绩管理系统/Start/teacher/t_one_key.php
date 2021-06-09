<?php require_once('../../Connections/login.php'); ?>
<?php require_once('../../Connections/is_login.php'); ?>
<?php
//GET接受课程数据
if(isset($_GET['ss'])){
	$_ss=$_GET['ss'];
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



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="style/style.css" rel="stylesheet" type="text/css">

</head>

<body>

<div id="search">

    <form id="kc_search" name="kc_search" method="post" action="t_one_key.php" >
    <img src="../../img/miku.gif" />
      <p>
        <label for="password"></label>
        搜索学生：<input type="text" name="in_kc" id="in_kc" placeholder="请输入学号或姓名" required="required"/>
        <?php 
		if (isset($_REQUEST['kcm'])){
			echo "<input type=\"hidden\"  name=\"kcm\" value=\"";
			echo $_REQUEST['kcm'];
			echo "\"/>";
		}
		if(isset($_POST['in_kc'])){
			$words=$_POST['in_kc'];
			echo "<script>document.getElementById('in_kc').value = '$words';</script>";	
			
			
			
		}
		
		?>
        
        <input type="submit" name="ss" id="submit0" value="点击搜索" />
        
       
      </p>
    </form>
<form method="post">
    <input type="submit" name="pjf" id="pjf" value="查询课程平均分" />
    <input type="submit" name="zgf" id="zgf" value="查询课程最高分" />
    <input type="submit" name="bjg" id="bjg" value="查询不及格的同学" />
    <input type="submit" name="yx" id="yx" value="查询优秀的同学" />
</form>

</div>
<div id="box1">
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
		 
		echo "<div class=\"list0\">";
		echo "<ul>";
		echo "<li>";echo $row_cj_rank['学号'];  echo "</li>";
		echo "<li>";echo $row_cj_rank['姓名'];  echo "</li>";
		echo "<li>";echo $row_cj_rank['课程号'];  echo "</li>";
		echo "<li>";echo $row_cj_rank['课程名']; echo "</li>";
		echo "<li>";echo $row_cj_rank['学分'];  echo "</li>";
		echo "<li>";echo $row_cj_rank['成绩']; echo "</li>";
		echo "<li>";echo $row_cj_rank['排名'];  echo "</li>";
		echo "</ul>";
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
<?php
	//查询课程平均分
if(isset($_POST['pjf'])){
	mysql_select_db($database_login, $login);
	$query_search_kc = "select 课程名,课程号,avg(成绩) as 平均成绩 from cj join kc using(课程号) group by 课程号";
	$search_kc = mysql_query($query_search_kc, $login) or die(mysql_error());
	$row_search_kc = mysql_fetch_assoc($search_kc);
	$totalRows_search_kc = mysql_num_rows($search_kc);

	echo "<div id=\"box2\">";
	echo "<div class=\"jieguo\">";
	echo "<div id=\"title0\">";
    echo "<ul>";
	echo "<li>&nbsp;</li>";
    echo "<li>课程名</li>";
    echo "<li>课程号</li>";
    echo "<li>平均成绩</li>";
    echo "</ul>";
 	echo "</div>";
	//-------------------------
	do{
	echo "<div id=\"res\">";
	echo "<div class=\"list0\">";
    echo "<ul>";
	echo "<li>&nbsp;</li>";
    echo "<li>";echo $row_search_kc['课程名']; echo "</li>";
    echo "<li>";echo $row_search_kc['课程号']; echo "</li>";
    echo "<li>";echo $row_search_kc['平均成绩']; echo "</li>";
    echo "</ul>";
    echo "</div>";
	} while ($row_search_kc = mysql_fetch_assoc($search_kc)); 
	echo "</div>";
	echo "</div>";
	echo "</div>";
/*echo "<script>var url=\"";
printf ("%s?kcm=%s%s", $currentPage, $row_search_kc['课程名'],$queryString_kcm); 	
echo "\";window.location.href=url;</script>";*/
}
?>
<?php
	//查询课程最高分
if(isset($_POST['zgf'])){
	mysql_select_db($database_login, $login);
	$query_search_zgf = "select 课程名,课程号,姓名,学号,成绩 from cj as T1
join student using(学号)
join kc using(课程号)
where not exists
(select 1 from cj where 课程号=T1.课程号 and 成绩>T1.成绩)";
	$search_zgf = mysql_query($query_search_zgf, $login) or die(mysql_error());
	$row_search_zgf = mysql_fetch_assoc($search_zgf);
	$totalRows_search_zgf = mysql_num_rows($search_zgf);

	echo "<div id=\"box2\">";
	echo "<div class=\"jieguo\">";
	echo "<div id=\"title0\">";
    echo "<ul>";
    echo "<li>课程名</li>";
    echo "<li>课程号</li>";
	echo "<li>姓名</li>";
	echo "<li>学号</li>";
    echo "<li>最高分</li>";
    echo "</ul>";
 	echo "</div>";
	//-------------------------
	do{
	echo "<div id=\"res\">";
	echo "<div class=\"list0\">";
    echo "<ul>";
    echo "<li>";echo $row_search_zgf['课程名']; echo "</li>";
    echo "<li>";echo $row_search_zgf['课程号']; echo "</li>";
  	echo "<li>";echo $row_search_zgf['姓名']; echo "</li>";
    echo "<li>";echo $row_search_zgf['学号']; echo "</li>";
	echo "<li>";echo $row_search_zgf['成绩']; echo "</li>";
    echo "</ul>";
    echo "</div>";
	} while ($row_search_zgf = mysql_fetch_assoc($search_zgf)); 
	echo "</div>";
	echo "</div>";
	echo "</div>";
/*echo "<script>var url=\"";
printf ("%s?kcm=%s%s", $currentPage, $row_search_kc['课程名'],$queryString_kcm); 	
echo "\";window.location.href=url;</script>";*/
}
?>
<?php
	//查询不及格
if(isset($_POST['bjg'])){
	mysql_select_db($database_login, $login);
	$query_search_bjg = "select 课程名,课程号,姓名,学号,成绩 from cj
join student using(学号)
join kc using(课程号)
where 成绩<60";
	$search_bjg = mysql_query($query_search_bjg, $login) or die(mysql_error());
	$row_search_bjg = mysql_fetch_assoc($search_bjg);
	$totalRows_search_bjg = mysql_num_rows($search_bjg);

	echo "<div id=\"box2\">";
	echo "<div class=\"jieguo\">";
	echo "<div id=\"title0\">";
    echo "<ul>";
    echo "<li>课程名</li>";
    echo "<li>课程号</li>";
	echo "<li>姓名</li>";
	echo "<li>学号</li>";
    echo "<li>成绩</li>";
    echo "</ul>";
 	echo "</div>";
	//-------------------------
	do{
	echo "<div id=\"res\">";
	echo "<div class=\"list0\">";
    echo "<ul>";
    echo "<li>";echo $row_search_bjg['课程名']; echo "</li>";
    echo "<li>";echo $row_search_bjg['课程号']; echo "</li>";
  	echo "<li>";echo $row_search_bjg['姓名']; echo "</li>";
    echo "<li>";echo $row_search_bjg['学号']; echo "</li>";
	echo "<li>";echo $row_search_bjg['成绩']; echo "</li>";
    echo "</ul>";
    echo "</div>";
	} while ($row_search_bjg = mysql_fetch_assoc($search_bjg)); 
	echo "</div>";
	echo "</div>";
	echo "</div>";
/*echo "<script>var url=\"";
printf ("%s?kcm=%s%s", $currentPage, $row_search_kc['课程名'],$queryString_kcm); 	
echo "\";window.location.href=url;</script>";*/
}
?>
<?php
	//查询优秀
if(isset($_POST['yx'])){
	mysql_select_db($database_login, $login);
	$query_search_yx = "select 课程名,课程号,姓名,学号,成绩 from cj
join student using(学号)
join kc using(课程号)
where 成绩>=90";
	$search_yx = mysql_query($query_search_yx, $login) or die(mysql_error());
	$row_search_yx = mysql_fetch_assoc($search_yx);
	$totalRows_search_yx = mysql_num_rows($search_yx);

	echo "<div id=\"box2\">";
	echo "<div class=\"jieguo\">";
	echo "<div id=\"title0\">";
    echo "<ul>";
    echo "<li>课程名</li>";
    echo "<li>课程号</li>";
	echo "<li>姓名</li>";
	echo "<li>学号</li>";
    echo "<li>成绩</li>";
    echo "</ul>";
 	echo "</div>";
	//-------------------------
	do{
	echo "<div id=\"res\">";
	echo "<div class=\"list0\">";
    echo "<ul>";
    echo "<li>";echo $row_search_yx['课程名']; echo "</li>";
    echo "<li>";echo $row_search_yx['课程号']; echo "</li>";
  	echo "<li>";echo $row_search_yx['姓名']; echo "</li>";
    echo "<li>";echo $row_search_yx['学号']; echo "</li>";
	echo "<li>";echo $row_search_yx['成绩']; echo "</li>";
    echo "</ul>";
    echo "</div>";
	} while ($row_search_yx = mysql_fetch_assoc($search_yx)); 
	echo "</div>";
	echo "</div>";
	echo "</div>";
/*echo "<script>var url=\"";
printf ("%s?kcm=%s%s", $currentPage, $row_search_kc['课程名'],$queryString_kcm); 	
echo "\";window.location.href=url;</script>";*/
}
?>
<?php
	//搜索学生
if(isset($_POST['in_kc'])){
	$words=$_POST['in_kc'];
	mysql_select_db($database_login, $login);
	$query_search_xs = "select * from student 
where 学号 like'%$words%'
or 姓名 like'%$words%'";
	$search_xs = mysql_query($query_search_xs, $login) or die(mysql_error());
	$row_search_xs = mysql_fetch_assoc($search_xs);
	$totalRows_search_xs = mysql_num_rows($search_xs);

	echo "<div id=\"box2\">";
	echo "<div class=\"jieguo\">";
	echo "<div id=\"title0\">";
    echo "<ul>";
    echo "<li>学号</li>";
    echo "<li>姓名</li>";
	echo "<li>性别</li>";
	echo "<li>专业名</li>";
	echo "<li>操作</li>";
    echo "</ul>";
 	echo "</div>";
	//-------------------------
	do{
	echo "<div id=\"res\">";
	echo "<div class=\"list0\">";
    echo "<ul>";
    echo "<li>";echo $row_search_xs['学号']; echo "</li>";
    echo "<li>";echo $row_search_xs['姓名']; echo "</li>";
  	echo "<li>";echo $row_search_xs['性别']; echo "</li>";
    echo "<li>";echo $row_search_xs['专业名']; echo "</li>";
	echo "<li>[";
	echo "<a target=\"kuang\" href=\"t_xs_detail.php?num=";
	echo $row_search_xs['学号'];echo "\">查看详情</a>]"; 
	echo "</li>";
    echo "</ul>";
    echo "</div>";
	} while ($row_search_xs = mysql_fetch_assoc($search_xs)); 
	echo "</div>";
	echo "</div>";
	echo "</div>";
/*echo "<script>var url=\"";
printf ("%s?kcm=%s%s", $currentPage, $row_search_kc['课程名'],$queryString_kcm); 	
echo "\";window.location.href=url;</script>";*/
}
?>
</div>





</body>
</html>

