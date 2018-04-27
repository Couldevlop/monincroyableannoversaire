<?php require_once('Connections/ConnexionBD.php');
require_once('caractere.php');	
if (!isset($_SESSION)) {
  session_start();
}
$ID = FileNameGen(mysql_real_escape_string(htmlspecialchars($_POST['identifiant'])));         

mysql_select_db($database_ConnexionBD,$ConnexionBD);
     $SelectCan = 'SELECT * FROM candidat WHERE CODE_CANDIDAT="'.$ID.'"';
     $ExecutCan = mysql_query($SelectCan, $ConnexionBD);
     $RecupCan = mysql_fetch_assoc($ExecutCan) ;
  
$_SESSION['LOGIN'] = $RecupCan['LOGIN_CANDIDAT'];
$_SESSION['NBSMS'] = $RecupCan['NBSMS_CANDIDAT'];
$GoTo = "votre.php";
     	header("Location: $GoTo"); 
//echo $_SESSION['LOGIN']." ".$_SESSION['NBSMS'];

?>