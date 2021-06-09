<?php
//删除cookies
setcookie("admin","",time()-3600,'/');

echo"<script>url=\"../login.php\";window.location.href=url;</script>";
?>
