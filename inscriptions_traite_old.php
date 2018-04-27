
<?php require_once('Connections/ConnexionProfil.php');
if (!isset($_SESSION)) {
  session_start();
}
function connectbd2(){
    $base = mysql_connect ('localhost','root','telcosarl2013');
    mysql_select_db ('gamebd_togo',$base);
}
function connectbd(){
    $base = mysql_connect ('localhost','root','telcosarl2013');
    mysql_select_db ('gamebd',$base);
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
         $numero =  "228".mysql_real_escape_string(htmlspecialchars($_POST['numero']));
      $email =  FileNameGen(mysql_real_escape_string(htmlspecialchars($_POST['email'])));
     // $email=  $_SESSION['email'];
      $login1 =  FileNameGen(mysql_real_escape_string(htmlspecialchars($_POST['login'])));
      $login=str_replace(' ','',$login1);
      $pass =  FileNameGen(mysql_real_escape_string(htmlspecialchars($_POST['password'])));
   //echo $date;
   //  $pass2 = $_SESSION['pass2'];
	 if ($_POST['mois'] == date("m"))
{
    connectbd();
     
    $Requestsql = 'INSERT INTO candidat VALUES("","","'.$nom.'", "'.$prenom.'", "'.$date.'","'.$numero.'","'.$login.'","'.$pass.'","'.$nomfic.'","")';
     
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
//-------------------------------------------

       connectbd2();
     
    $Requestsql1 = 'INSERT INTO candidat VALUES("","","'.$nom.'", "'.$prenom.'", "'.$date.'","'.$numero.'","'.$login.'","'.$pass.'","'.$nomfic.'","")';
     
      $Execute1 = mysql_query($Requestsql1) or die(mysql_error());

      $ID1 = mysql_insert_id();
    /* $SelectSQL1 = 'SELECT (LEFT(LOGIN_CANDIDAT, 2)) AS lettre FROM candidat WHERE ID_CANDIDAT="'.$ID1.'"';
     $ExecutSQL1 = mysql_query($SelectSQL1);
     $Recup1 = mysql_fetch_assoc($ExecutSQL1);*/
     $code1 = $ID1;
     
     $UpdateSQL1 = 'UPDATE candidat SET CODE_CANDIDAT = "'.$code1.'" WHERE ID_CANDIDAT="'.$ID1.'"';
       mysql_query($UpdateSQL1) or die('Erreur SQL!'.$UpdateSQL1. '<br>' .mysql_error());
	
       mysql_close();
  /*
		$GoTo = "monprofile.php";
 		$_SESSION['sauve'] = "ok";
        header("Location: $GoTo");  */
	   
  
  }
  else
  {
    connectbd();
     
    $Requestsql = 'INSERT INTO candidat VALUES("","","'.$nom.'", "'.$prenom.'", "'.$date.'","'.$numero.'","'.$login.'","'.$pass.'","'.$nomfic.'","")';
     
      $Execute = mysql_query($Requestsql) /*or die('Erreur SQL!'.$Requestsql. '<br>' .mysql_error())*/;
   


     if ($Execute == NULL)
     {
       $_SESSION['login'] = "ok";
     $GoTo = "inscription.php";
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
     /*$SelectSQL = 'SELECT (LEFT(LOGIN_CANDIDAT, 2)) AS lettre FROM candidat WHERE ID_CANDIDAT="'.$ID.'"';
     $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
     $Recup = mysql_fetch_assoc($ExecutSQL);*/
     $code = $ID;
     
     $UpdateSQL = 'UPDATE candidat SET CODE_CANDIDAT = "'.$code.'" WHERE ID_CANDIDAT="'.$ID.'"';
       mysql_query($UpdateSQL) or die('Erreur SQL!'.$UpdateSQL. '<br>' .mysql_error());
       mysql_close();
  
   
    }
  }

   $GoTo = "monprofile.php";
    $_SESSION['sauve'] = "ok";
       header("Location: $GoTo");  
?>