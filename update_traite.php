<?php  require_once('Connections/ConnexionProfil.php');
if (!isset($_SESSION)) {
  session_start();
}
 	
 	if (isset($_SESSION['login']))
	{
$login =  $_SESSION['login'];}
	 
   //------UPLOAD DE LA PHOTO--------------------//
   
    // On cherche d'abord à uploader la photo /opt/lampp/htdocs/xampp/www/game/photo
//$dossier = '/opt/lampp/htdocs/xampp/www/game/photo/';

 $dossier = 'photo/'; // dossier contenant les photos uploadées
 $fichier = basename($_FILES['photo']['name']);
 $taille_maxi = 3000000;
 $taille = filesize($_FILES['photo']['tmp_name']);
 $extensions = array('.jpg', '.png', '.gif','.PNG','.JPG');
 $extension = strrchr($_FILES['photo']['name'], '.'); 
 $nomfic = $fichier;
 $name = $login.$extension;
 //Début des vérifications de sécurité...
 if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
	{
     $erreur = 'Vous devez uploader un fichier de type jpg ,gif ou png...';
	}
 if($taille>$taille_maxi)
	{
     $erreur = 'Le fichier est trop gros...';
	}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
	 // au lieu de foramter, je vais renomer après
     if(move_uploaded_file($_FILES['photo']['tmp_name'], $dossier . $name)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
		 // echo 'Dépot réussi !';
		 $nomfic =  $name;

     }
     else //Sinon (la fonction renvoie FALSE).
     {
          //echo 'Echec de l\'upload !';
		  $nomfic = 'default.jpg';
     }
}
else
{
     //echo $erreur;
	  $nomfic = 'default.jpg';
}


if ( $nomfic == "default.jpg" )
{ $nomfic = $_SESSION['photo']; }
/*---------------------------------*/


$dirname = 'photo/'; // Verifier l'existance de la photo en cas de pblm
$dir = opendir($dirname); 
$trouve = false;

while($file = readdir($dir)) {
	if($file == $nomfic)/*($file != '.' && $file != '..' && !is_dir($dirname.$file))*/
	{
		$trouve = true;
	}
	//else echo "Non trouve";
}
closedir($dir);
if ($trouve == false) {
$nomfic = "default.jpg"; // en cas d'absence de la photo, on lui attribue la tof par defaut
//echo "nouvo nom  ".$nomfic;
 }
/***********************************************************/
//$nomfic = "default.jpg";
$Select = "SELECT DAY(DATE_CANDIDAT) AS JR,MONTH(DATE_CANDIDAT) AS MS FROM candidat WHERE ID_CANDIDAT='".$_SESSION['ID']."'";
  mysql_select_db($database_ConnexionBD, $ConnexionBD);
  $Ex = mysql_query($Select);
  $Recup = mysql_fetch_assoc($Ex);


  $annee = mysql_real_escape_string(htmlspecialchars($_POST['annee']));
  if ($annee == '')
      {
        $year = "0000";
       
      }
      else 
      {
         $year = mysql_real_escape_string(htmlspecialchars($_POST['annee']));

      }      
      $date= $year."-".$_POST['mois']."-".$_POST['jour'];
      $moisjourfalse = $year."-0-0";// Mois et jour non modifie
      $jourfalse = $year."-".$_POST['mois']."-0"; // jour non modifie
      $moisfalse = $year."-"."0-".$_POST['jour']; // jour non modifie

if ( ($date == $moisjourfalse) ||  ($date == $jourfalse) || ($date == $moisfalse))
{
	$date = $year."-".$Recup['MS']."-".$Recup['JR'];
	
} 
$nom = mysql_real_escape_string(htmlspecialchars($_POST['NOM_CANDIDAT'])); 
$pnom = mysql_real_escape_string(htmlspecialchars($_POST['PREN_CANDIDAT'])); 



$num = "225".mysql_real_escape_string(htmlspecialchars($_POST['NUM_CANDIDAT']));

/*if ( (substr($numero, 0,5) == '22504') || (substr($numero, 0,5) == '22505') || (substr($numero, 0,5) == '22506') || (substr($numero, 0,5) == '22544') || (substr($numero, 0,5) == '22545')
    ||(substr($numero, 0,5) == '22546')||(substr($numero, 0,5) == '22554')||(substr($numero, 0,5) == '22555')||(substr($numero, 0,5) == '22556')||(substr($numero, 0,5) == '22574')
    ||(substr($numero, 0,5) == '22575')||(substr($numero, 0,5) == '22576') )
{*/
$updateSQL = "UPDATE candidat SET PHOTO='".$nomfic."', NOM_CANDIDAT='".$nom."', PREN_CANDIDAT='".$pnom."', DATE_CANDIDAT='".$date."', NUM_CANDIDAT='".$num."' WHERE ID_CANDIDAT='".$_SESSION['ID']."'";
                       
  mysql_select_db($database_ConnexionBD, $ConnexionBD);
  $Execute = mysql_query($updateSQL, $ConnexionBD);
   
  $updateGoTo = "afterlogin.php";

  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }

  header(sprintf("Location: %s", $updateGoTo));
  if (!$Execute) {$_SESSION['reponse'] = "ok"; header(sprintf("Location: %s", $updateGoTo));}
/*}
else
{
  $updateGoTo = "modifyprofile.php";
   header(sprintf("Location: %s", $updateGoTo));
  if (!$Execute) {$_SESSION['pas_mtn'] = "ok"; header(sprintf("Location: %s", $updateGoTo));}
}*/
//ho $nomfic;
//echo  $_SESSION['photo'];

?>