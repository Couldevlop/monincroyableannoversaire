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
$dirname = 'photo/'; /* Verifier l'existance de la photo en cas de pblm*/
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
/*function connectbd2(){
    $base = mysql_connect ('localhost','root','telcosarl2013');
    mysql_select_db ('gamebd_togo',$base);
}*/
function connectbd(){
    $base = mysql_connect ('localhost','root','telcosarl2013');
    mysql_select_db ('telco_anniv_ci',$base);
}
connectbd();

$updateSQL = "UPDATE candidat SET PHOTO='".$nomfic."' WHERE ID_CANDIDAT='".$_SESSION['ID']."'";
    mysql_query($updateSQL);                   
 // mysql_select_db($database_ConnexionBD, $ConnexionBD);
  //mysql_query($updateSQL, $ConnexionBD) or die(mysql_error());

 
   /* connectbd2();
   
     $UpdateSQL1 = 'UPDATE candidat SET PHOTO="'.$nomfic.'"" WHERE ID_CANDIDAT="'.$_SESSION['ID'].'"';
       mysql_query($UpdateSQL1) ;
*/

  $updateGoTo = "afterlogin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
//echo $nomfic;
//echo  $_SESSION['photo'];

?>