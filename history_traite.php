<?php require_once('Connections/ConnexionBD.php');
require_once('caractere.php');	
if (!isset($_SESSION)) {
  session_start();
}
	setlocale(LC_TIME,'fr_FR','fra'); 
  
date_default_timezone_set('Africa/Abidjan');
$date = FileNameGen(mysql_real_escape_string(htmlspecialchars($_POST['date'])));  
//echo $date." ";

function date_en($date_saisie){
 
        //division de la date par rapport au / ou -
        @list ($jour , $mois , $an) = split("[-./]",$date_saisie);
        //inverse la date
        
 		return($an."-".$mois."-".$jour);
}    // Mettre la date en format francais
//echo date_en($date);

mysql_select_db($database_ConnexionBD,$ConnexionBD);
     $SelectCan = 'SELECT * FROM vainqueur WHERE DATE_VAINQ="'.date_en($date).'"';
     $ExecutCan = mysql_query($SelectCan, $ConnexionBD);
    $RecupCan = mysql_fetch_assoc($ExecutCan) ;

    $_SESSION['date'] = $RecupCan['DATE_VAINQ'];
    echo  $_SESSION['date'];
    $GoTo = "history.php";
     	header("Location: $GoTo"); 
?>