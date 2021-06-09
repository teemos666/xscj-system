<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_login = "192.168.247.128";
$database_login = "marks";
$username_login = "teacher";
$password_login = "123456";
$login = mysql_pconnect($hostname_login, $username_login, $password_login) or trigger_error(mysql_error(),E_USER_ERROR); 


?>
