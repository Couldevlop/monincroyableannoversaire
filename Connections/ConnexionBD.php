<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ConnexionBD = "localhost";
$database_ConnexionBD = "telco_anniv_ci";
$username_ConnexionBD = "root";
$password_ConnexionBD = "";
/*$ConnexionBD = mysql_pconnect($hostname_ConnexionBD, $username_ConnexionBD, $password_ConnexionBD) or trigger_error(mysql_error(),E_USER_ERROR);*/
$ConnexionBD = mysql_connect($hostname_ConnexionBD, $username_ConnexionBD, $password_ConnexionBD) or trigger_error(mysql_error(),E_USER_ERROR); 
?>