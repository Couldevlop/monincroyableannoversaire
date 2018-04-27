<?php require_once('Connections/ConnexionProfil.php'); ?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['login'])) {
  $loginUsername =  mysql_real_escape_string(htmlspecialchars($_POST['login']));
  $password =  mysql_real_escape_string(htmlspecialchars($_POST['password']));
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "afterlogin.php";
  $MM_redirectLoginFailed = "monprofile.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_ConnexionBD, $ConnexionBD);
  
  $LoginRS__query=sprintf("SELECT LOGIN_CANDIDAT, PWD_CANDIDAT FROM candidat WHERE LOGIN_CANDIDAT=%s AND PWD_CANDIDAT=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $ConnexionBD) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	mysql_select_db($database_ConnexionBD,$ConnexionBD);
	   $SelectSQL = 'SELECT ID_CANDIDAT FROM candidat WHERE LOGIN_CANDIDAT="'.$loginUsername.'" AND PWD_CANDIDAT="'.$password.'"';
	   $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
	   $Recup = mysql_fetch_assoc($ExecutSQL);
	   $_SESSION['ID'] = $Recup['ID_CANDIDAT'];
	   $_SESSION['adminId'] = "ok";
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
	$_SESSION['echec'] = "ok";
	
  }
}
?>