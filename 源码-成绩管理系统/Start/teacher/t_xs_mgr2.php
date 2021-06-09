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
	/* echo "<script>alert(\"";
	echo "??";
	echo "\");</script>";*/
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
<form action="t_xs_mgr2.php" method="post" enctype="multipart/form-data">
<table width="660">
    <tr>
        <td width="200">姓名：</td>
        <td width="550">
        <input type="text" name="xm" placeholder="请输入姓名" value="<?php echo $row_stu_msg['姓名'];?>" required/>
        </td>
        <td rowspan="4">
        <img id="o_photo_img" src="<?php echo $row_stu_msg['照片'];?>" width=90 height=120 />
        </td>
    </tr>
    <tr>
        <td>学号：</td>
        <td><input type="text" name="num" placeholder="请输入学号" value="<?php echo $row_stu_msg['学号'];?>" readonly="readonly"/></td>
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
        <input type="text" name="zym" placeholder="请输入专业名" value="<?php echo $row_stu_msg['专业名'];?>" required/></td>
      </tr>
    <tr>
        <td>备注：</td>
        <td>
        <input type="text" name="note" placeholder="请输入备注" value="<?php echo $row_stu_msg['备注'];?>"/></td>
        <td><input type="file" name="file" onchange="uploader(this.files)" accept="image/jpeg" />
        </td>
      </tr>
      <tr>
    <td></td>
    <td><input type="submit" name="submit" value="修改学生信息"/></td>
    
    </tr>
    
</table>
</form>
</div>
<div id="kecheng">
  <div id="jishu">共有 <?php echo $totalRows_cj_msg ?> 条记录，目前显示第<?php echo ($startRow_cj_msg + 1) ?>条至第<?php echo min($startRow_cj_msg + $maxRows_cj_msg, $totalRows_cj_msg) ?>条</div>
  <div id="title1">
        <ul>
          <li>姓名</li>
          <li>课程号</li>
          <li>课程名</li>
          <li>课程学分</li>
          <li>成绩</li>
          <li>该科排名</li>
           <li>操作</li>
    </ul>
  </div>
  <div id="查询框">
  <?php do { ?>
    <div class="list1">
      <ul>
        <li><?php echo $row_cj_msg['姓名']; ?></li>
        <li><?php echo $row_cj_msg['课程号']; ?></li>
        <li><?php echo $row_cj_msg['课程名']; ?></li>
        <li><?php echo $row_cj_msg['学分']; ?></li>
        <li><?php echo $row_cj_msg['成绩']; ?></li>
        <li><?php echo $row_cj_msg['排名']; ?></li>
        <li>
        <?php if ($totalRows_cj_msg != 0){ ?>
        <input type="button" class="xiugai" value="修改成绩" onclick="update()"/>
		<?php }?>
        </li>
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


<button id="add1" onclick="add()">添加成绩信息</button>
</div>
<select id="kch0" hidden="">
</select>
<select id="xf0" hidden="">
</select>
<form id="up" name="up" method="POST" action="" hidden="">
    <input type="text" name="cj" id="cj" required/>
    <input type="text" name="kch" id="kch" required/>
    <input type="text" name="cmd" id="cmd" required/>
    <input type="submit" name="submit0" id="submit0" value="up"/>
</form>
</body>
</html>
<?php
//下拉框
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
mysql_select_db($database_login, $login);
$query_Recordset1 = "SELECT * FROM kc";
$Recordset1 = mysql_query($query_Recordset1, $login) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

?>

<script>
//由于下列函数设计php代码，故不能放入js文件内
//获取option元素的值
function display(idname,optionNA){
   var all_options = document.getElementById(idname).options;
   for (i=0; i<all_options.length; i++){
      if (all_options[i].className == optionNA) 
      {
         all_options[i].selected = true;
      }
   }
};
//当选择option元素而onchange事件时的函数
//显示选中课程的课程号和学分
function xuanze(){
	var text=document.getElementById("sel").value;
	display("kch0",text);
	display("xf0",text);
	 document.getElementById("kch").innerHTML=document.getElementById("kch0").value;
	 document.getElementById("xf").innerHTML=document.getElementById("xf0").value;
	 document.getElementById("kch_t").value=document.getElementById("kch").innerHTML;
     document.getElementById("xf_t").value=document.getElementById("xf").innerHTML;
}
//点击按钮添加成绩时，动态增加html元素
function add() {
    var d=document.createElement('div');
    var o=document.getElementById('查询框');
	var f=document.createElement('form');
	var u=document.createElement('ul');
	
	var li1=document.createElement('li');
	var li2=document.createElement('li');
	var li3=document.createElement('li');
	var li4=document.createElement('li');
	var li5=document.createElement('li');
	var li6=document.createElement('li');
	var li7=document.createElement('li');
	
	var li8=document.createElement('li');
	var li9=document.createElement('li');
	var li_=document.createElement('li');
	
	var i1=document.createElement('p');
	var i2=document.createElement('p');
	var i3=document.createElement('p');
	var i4=document.createElement('select');
	var i5=document.createElement('p');
	var i6=document.createElement('input');
	var i7=document.createElement('input');
	
	var i_=document.createElement('p');
	var i8=document.createElement('input');
	var i9=document.createElement('input');
	var ok=document.createElement('input');
	
	var s1=document.getElementById('kch0');
	var s2=document.getElementById('xf0');
	var op=new Array();
	var op1=new Array();
	var op2=new Array();
	var op_p=0;
	
	d.setAttribute("class","list1");
	ok.setAttribute("type","submit");
	ok.setAttribute("name","add");
	
	ok.setAttribute("value","添加成绩");
	
	i2.innerHTML="<?php echo $row_stu_msg['姓名'];?>";
	
	//i2.innerHTML="<?php echo $row_stu_msg['学号'];?>";
	
	i3.setAttribute("id","kch");
	i3.innerHTML="请选择课程";
	//--------
	i4.setAttribute("id","sel");
	i4.setAttribute("onchange","xuanze()");
	var t=document.createElement('option');
	t.innerHTML="请选择课程";
	i4.appendChild(t);
	<?php do { ?>
	op.push(document.createElement('option'));
	op[op_p].setAttribute("value","<?php echo $row_Recordset1['课程名']; ?>");
	op[op_p].setAttribute("class","<?php echo $row_Recordset1['课程名']; ?>");
	op[op_p].innerHTML="<?php echo $row_Recordset1['课程名']; ?>";
	i4.appendChild(op[op_p]);
	//op_p++;
	//-----
	op1.push(document.createElement('option'));
	op1[op_p].setAttribute("value","<?php echo $row_Recordset1['课程号']; ?>");
	op1[op_p].setAttribute("class","<?php echo $row_Recordset1['课程名']; ?>");
	op1[op_p].innerHTML="<?php echo $row_Recordset1['课程号']; ?>";
	s1.appendChild(op1[op_p]);
	
	//---
	op2.push(document.createElement('option'));
	op2[op_p].setAttribute("value","<?php echo $row_Recordset1['学分']; ?>");
	op2[op_p].setAttribute("class","<?php echo $row_Recordset1['课程名']; ?>");
	op2[op_p].innerHTML="<?php echo $row_Recordset1['学分']; ?>";
	s2.appendChild(op2[op_p]);
	op_p++;
	
	<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
	//---------
	i5.setAttribute("id","xf");
	i5.innerHTML="请选择课程";
	
	i6.setAttribute("type","text");
	i6.setAttribute("name","cj");
	i6.setAttribute("placeholder","请输入成绩");
	
	
	i8.setAttribute("name","kch");
	i9.setAttribute("name","xf");
	i8.setAttribute("id","kch_t");
	i9.setAttribute("id","xf_t");
	i8.setAttribute("hidden","");
	i9.setAttribute("hidden","");
	
	f.setAttribute("method","post");
	f.setAttribute("action","");
	
	/*u.appendChild(li1);
	li1.appendChild(i1);*/
	
	u.appendChild(li2);
	li2.appendChild(i2);
	
	u.appendChild(li3);
	li3.appendChild(i3);
	
	u.appendChild(li4);
	li4.appendChild(i4);
	
	u.appendChild(li5);
	li5.appendChild(i5);
	
	u.appendChild(li6);
	li6.appendChild(i6);
	
	i_.innerHTML="&nbsp;";
		u.appendChild(li_);
	li_.appendChild(i_);
	u.appendChild(li7);
	li7.appendChild(ok);
	

	u.appendChild(li8);
	li8.appendChild(i8);
	u.appendChild(li9);
	li9.appendChild(i9);
	
	f.appendChild(u);
	d.appendChild(f);
    o.appendChild(d);
	document.getElementById('add1').setAttribute("hidden","");
	document.getElementsByClassName('list2')[0].setAttribute("hidden","");
}
//点击修改成绩时
function update(i) {
	var c=document.getElementsByClassName('list1')[i].children[0].children[4];
	var text=document.getElementsByClassName('list1')[i].children[0].children[4].innerHTML;
  
	var cc=c.childNodes[0];
	var ok=document.createElement('input');
	ok.setAttribute("type","text");
	ok.setAttribute("name","cj");
	ok.setAttribute("value",text);
	c.replaceChild(ok,cc);
	//------
	var c=document.getElementsByClassName('list1')[i].children[0].children[6];
  
	var cc=c.children[0];
	var zong=document.createElement('span');
	var ok=document.createElement('input');
	ok.setAttribute("type","button");
	ok.setAttribute("name","tijiao");
	ok.setAttribute("value","确定");
	var de=document.createElement('input');
	de.setAttribute("type","button");
	de.setAttribute("name","shanchu");
	de.setAttribute("value","删除");
	var k=document.createTextNode(" ");
	zong.appendChild(ok);
	zong.appendChild(k);
	zong.appendChild(de);
	c.replaceChild(zong,cc);
	var v="transfer("+i+",1)";
	ok.setAttribute("onclick",v);
	var v="transfer("+i+",0)";
	de.setAttribute("onclick",v);
  
}
function transfer(i,cmd) {
	var text=document.getElementsByClassName('list1')[i].children[0].children[4].childNodes[0].value;
	document.getElementById('cj').setAttribute("value",text);
	 var text=document.getElementsByClassName('list1')[i].children[0].children[1].innerHTML;
	document.getElementById('kch').setAttribute("value",text);
	document.getElementById('cmd').setAttribute("value",cmd);
	//document.getElementById('up').submit();
	if(cmd=='0'){
	  var r=confirm("确定删除？");
	  if (r == true) {
		  document.getElementById('submit0').click();
		  } 
	}
	if(cmd=='1'){
		var r=confirm("确定修改？");
		if (r == true) {
		  document.getElementById('submit0').click();
		  } 
	}
  
}
</script>
<script src="js/public.js">

</script>

<?php
//添加成绩
if ((isset($_POST["add"])) && ($_POST["add"] == "添加成绩")) {
  $insertSQL = sprintf("INSERT INTO cj (学号, 课程号, 成绩, 学分) VALUES (%s, %s, %d, %d)",
                       GetSQLValueString($num, "text"),
                       GetSQLValueString($_POST['kch'], "text"),
                       GetSQLValueString($_POST['cj'], "int"),
                       GetSQLValueString($_POST['xf'], "int"));
  mysql_select_db($database_login, $login);
  $Result1 = mysql_query($insertSQL, $login) or die(mysql_error());
  echo"<script>url=\"t_xs_mgr2.php?num=";
  echo $num;
  echo "\";window.location.href=url;</script>";
  
}	
?>
<?php
//修改成绩
if (isset($_POST["kch"]) &&isset($_POST["cj"]) && isset($_POST["cmd"])){
	if($_POST["cmd"]=='1'){
  $SQL = sprintf("UPDATE cj SET 成绩=%s WHERE 学号=%s and 课程号=%s",
                       GetSQLValueString($_POST['cj'], "int"),
                       GetSQLValueString($num, "text"),
					   GetSQLValueString($_POST['kch'], "text"));}
					   else{
						   $SQL = sprintf("DELETE FROM cj WHERE 课程号=%s and 学号=%s",
                       GetSQLValueString($_POST['kch'], "text"),
					   GetSQLValueString($num, "text"));
					   }
  mysql_select_db($database_login, $login);
  $Result1 = mysql_query($SQL, $login) or die(mysql_error());
  
  echo"<script>url=\"t_xs_mgr2.php?num=";
  echo $num;
  echo "\";window.location.href=url;</script>";
  
}	
?>
<?php
//修改学生信息
if ((isset($_POST["submit"])) && ($_POST["submit"] == "修改学生信息")) {
  $num=$_POST['num'];
  $zpn=$_FILES["file"]["name"];
  $zp=sprintf("%s%s/%s",dirname(dirname(dirname($_SERVER["PHP_SELF"]))),"/upload",$zpn); 
  $SQL = sprintf("UPDATE student SET 姓名=%s, 性别=%s, 专业名=%s, 备注=%s, 照片=%s WHERE 学号=%s",
                       GetSQLValueString($_POST['xm'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
					   GetSQLValueString($_POST['zym'], "text"),
					   GetSQLValueString($_POST['note'], "text"),
					   GetSQLValueString($zp, "text"),
					   GetSQLValueString($num, "text"));
					  
  mysql_select_db($database_login, $login);
  $Result1 = mysql_query($SQL, $login) or die(mysql_error());
  echo"<script>url=\"t_xs_mgr2.php?num=";
  echo $num;
  echo "\";window.location.href=url;</script>";
  
}	
?>
<?php
mysql_free_result($cj_msg);
?>
