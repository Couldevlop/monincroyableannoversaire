<?php //require_once('Connections/ConnexionBD.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
function connectbd(){
    $base = mysql_connect ('localhost','telco','telcosarl2013');
    mysql_select_db ('telco_anniv_ci',$base);
} 
/*function connectbd2(){
    $base = mysql_connect ('localhost','root','telcosarl2013');
    mysql_select_db ('gamebd_togo',$base);
}   */

//echo $_POST['numero'];
$numero =  "225".htmlspecialchars($_POST['numero']);

/*if ( (substr($numero, 0,5) == '22504') || (substr($numero, 0,5) == '22505') || (substr($numero, 0,5) == '22506') || (substr($numero, 0,5) == '22544') || (substr($numero, 0,5) == '22545')
    ||(substr($numero, 0,5) == '22546')||(substr($numero, 0,5) == '22554')||(substr($numero, 0,5) == '22555')||(substr($numero, 0,5) == '22556')||(substr($numero, 0,5) == '22574')
    ||(substr($numero, 0,5) == '22575')||(substr($numero, 0,5) == '22576') )
{
*/

$pseudo =  mysql_real_escape_string(htmlspecialchars($_POST['pseudo']));


 connectbd();    
   $InsertSql = 'INSERT INTO amis VALUES("","'.$_SESSION['ID'].'","'.$pseudo.'", "'.$numero.'")';
   $exec = mysql_query($InsertSql) /*or die(mysql_error())*/;

   /*$Select = 'SELECT NUM_CANDIDAT FROM candidat WHERE ID_CANDIDAT="'.$_SESSION['ID'].'"';
   $execSelect = mysql_query($Select) ;
   $Recuperer = mysql_fetch_array($execSelect );
   $NumCandidat = $Recuperer['NUM_CANDIDAT'];*/
   if ($exec)
   {
    /*connectbd2();  
   $Select2 = 'SELECT ID_CANDIDAT FROM candidat WHERE NUM_CANDIDAT="'.$NumCandidat.'"';
   $execSelect2 = mysql_query($Select2) ;
   $Recuperer2 = mysql_fetch_array($execSelect2 );
   $IDCandidat = $Recuperer2['ID_CANDIDAT'];
       $InsertSql2 = 'INSERT INTO amis VALUES("","'.$IDCandidat.'","'.$pseudo.'", "'.$numero.'")';
   $exec2 = mysql_query($InsertSql2) ;*/
   //echo $NumCandidat;
   //echo "/".$IDCandidat;
  $_SESSION['add'] = "ok";
  $MM_redirect = "ajouter.php";
 // $_SESSION['amis'] = "ok";
   header("Location: ". $MM_redirect);
   } else
   {
     //echo $NumCandidat;
  // echo "/".$IDCandidat;
	  $_SESSION['err'] = "ok";
  $MM_redirect = "ajouter.php";
 // $_SESSION['amis'] = "ok";
  header("Location: ". $MM_redirect);
	   }
   /* include("dashboard.php");
   include("add_friend.php");*/
/*}
else
{
  $_SESSION['pas_mtn'] = "ok";
  $MM_redirect = "ajouter.php";
 // $_SESSION['amis'] = "ok";
   header("Location: ". $MM_redirect);
}*/
?>
