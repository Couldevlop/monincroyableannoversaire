
<?php require_once('Connections/ConnexionProfil.php');
if (!isset($_SESSION)) {
  session_start();
}
function connectbd(){
    $base = mysql_connect ('localhost','telco','telcosarl2013');
    mysql_select_db ('telco_anniv_ci',$base);
}

require_once('caractere.php');


//$login =  $_SESSION['login'];
   //------UPLOAD DE LA PHOTO--------------------//
   
   /* // On cherche d'abord à uploader la photo
 $dossier = '../photo/'; // dossier contenant les photos uploadées
 $fichier = basename($_FILES['photo']['name']);
 $taille_maxi = 3000000;
 $taille = filesize($_FILES['photo']['tmp_name']);
 $extensions = array('.jpg', '.png', '.gif','.PNG','.JPG');
 $extension = strrchr($_FILES['photo']['name'], '.'); 
 $nomfic = $fichier;
 $name = $login.$extension;
 //echo  $name;
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
	/*	 $nomfic = $name/*$fichier;
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
*/

//------UPLOAD DE LA PHOTO TERMINE--------------------//
   //-------------------------------------------//  
connectbd();

   $nomfic = 'default.jpg';       
      $nom =trim(mysql_real_escape_string(htmlspecialchars($_POST['nom'])));         
      $prenom =  trim(mysql_real_escape_string(htmlspecialchars($_POST['prenoms'])));
     $annee = mysql_real_escape_string(htmlspecialchars($_POST['annee']));
      if ($annee == '')
      {
        $year = "0000";
       
      }
      else 
      {
         $year = mysql_real_escape_string(htmlspecialchars($_POST['annee']));
         if (strlen($year) != 4)
         {
          $GoTo = "registetion.php";
           header("Location: $GoTo");
         }

      }  
      if ($_POST['mois'] == "0" || $_POST['jour'] == "0")   
      {
          $GoTo = "registetion.php";
           header("Location: $GoTo");
      } 
      $date= $year."-".$_POST['mois']."-".$_POST['jour'];
      
      if (strlen($numero) != 8)
         {
          $GoTo = "monprofile.php";
           header("Location: $GoTo");
         }
         $numero =  "225".mysql_real_escape_string(htmlspecialchars($_POST['numero']));
      $email =  FileNameGen(mysql_real_escape_string(htmlspecialchars($_POST['email'])));
     // $email=  $_SESSION['email'];
      $login1 =  FileNameGen(mysql_real_escape_string(htmlspecialchars($_POST['login'])));
      $login=str_replace(' ','',$login1);
      $pass =  FileNameGen(mysql_real_escape_string(htmlspecialchars($_POST['password'])));

       $_SESSION['nom'] = $nom;
       $_SESSION['prenom'] = $prenom;
       $_SESSION['date'] = $date;
       $_SESSION['numero'] = $numero;
       $_SESSION['email'] = $email;
       $_SESSION['login1'] = $login;
       $_SESSION['pass'] = $pass;
   //echo $date;
   //  $pass2 = $_SESSION['pass2'];
	/* if ( (substr($numero, 0,5) == '22504') || (substr($numero, 0,5) == '22505') || (substr($numero, 0,5) == '22506') || (substr($numero, 0,5) == '22544') || (substr($numero, 0,5) == '22545')
    ||(substr($numero, 0,5) == '22546')||(substr($numero, 0,5) == '22554')||(substr($numero, 0,5) == '22555')||(substr($numero, 0,5) == '22556')||(substr($numero, 0,5) == '22574')
    ||(substr($numero, 0,5) == '22575')||(substr($numero, 0,5) == '22576') )
 {
    */
  if (($nom != '') && ($prenom != '') && ($date != '') && ($numero != '') && ($login != '') &&  ($pass != '') && ($nomfic != ''))   
  {
    $Requestsql = 'INSERT INTO candidat VALUES("","","'.$nom.'", "'.$prenom.'", "'.$date.'","'.$numero.'","'.$login.'","'.$pass.'","'.$nomfic.'","")';
    //$Requestsql = 'INSERT INTO candidat VALUES("","","'.$_SESSION['nom'].'", "'.$_SESSION['prenom'].'", "'.$_SESSION['date'].'","'.$_SESSION['numero'].'","'.$_SESSION['login1'].'","'.$_SESSION['pass'].'","'.$nomfic.'","")';
     
      $Execute = mysql_query($Requestsql) or die('Erreur SQL!'.$Requestsql. '<br>' .mysql_error());
	 


     if ($Execute == NULL)
	   {
	     $_SESSION['login'] = "ok";
		 $GoTo = "monprofile.php";
		 echo " Le login ou le numero est deja utilise ";/*
		 echo '<a href="inscription.php"> Retour </a>';*/
    	//header("Location: $GoTo"); 
		echo '<a href="javascript:history.back()"> Retour a la page precedente</a> pour modifier';
	   }
	  
	   else
	  {  
		
	 //----------------------------------------------Generation de code de vote---------------------
	  // mysql_select_db($database_ConnexionBD,$ConnexionBD);
	   $ID = mysql_insert_id();
	   // $SelectSQL = 'SELECT (LEFT(LOGIN_CANDIDAT, 2)) AS lettre FROM candidat WHERE ID_CANDIDAT="'.$ID.'"';
	   // $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
	   // $Recup = mysql_fetch_assoc($ExecutSQL);
	   $code = $ID;
	   
	   $UpdateSQL = 'UPDATE candidat SET CODE_CANDIDAT = "'.$code.'" WHERE ID_CANDIDAT="'.$ID.'"';
       mysql_query($UpdateSQL) or die('Erreur SQL!'.$UpdateSQL. '<br>' .mysql_error());
   }

   $GoTo = "monprofile.php";
    $_SESSION['sauve'] = "ok";
       header("Location: $GoTo");  
 }
 else
 {
  $GoTo = "registetion.php";
   
       header("Location: $GoTo"); 
 }

	    
  
 /* } else

  {
     $GoTo = "registetion.php";
    $_SESSION['pas_mtn'] = "ok";
       header("Location: $GoTo");  
  }
  
*/
  
?>