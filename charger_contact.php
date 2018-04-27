<?php  require_once('Connections/ConnexionProfil.php');
if (!isset($_SESSION)) {
  session_start();
}
 
 
 // UPLOAD BEGIN
  $dossier = 'temp/';
  $fichier = basename($_FILES['contact']['name']);	
  $extensions = array('.csv');
  $extension = strrchr($_FILES['contact']['name'], '.'); 
  $nomfic = $fichier;
  
   if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
	{
     $erreur = 'Vous devez uploader un fichier de type csv';
	}
 
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
if(move_uploaded_file($_FILES['contact']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
		 // echo 'Dépot réussi !';
		 $nomfic = $fichier;
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          //echo 'Echec de l\'upload !';
		  $nomfic = 'default.csv';
     }
}
else
{
     //echo $erreur;
	  $nomfic = 'default.csv';
}
//echo $dossier . $fichier;
// UPLOAD TERMINE 
/*********DEBUT EXTRATION DE CINTACT DU FICHIER ET INSERTION DS LA BD ****************************/

function Parite ($Nombre) // verifier la parite d'un nombre 
{

	$tamp = $Nombre%2;// tamp recoit le reste de la division
	if ( $tamp == 0)
		return 1;
	else return 0;
}
function connectbd(){
    $base = mysql_connect ('localhost','telco','telcosarl2013');
    mysql_select_db ('telco_anniv_ci',$base);
}


//---------------------------------
 connectbd();
 // $_SESSION['ID'] = 2;   
//-----------------------
$row = 1;
if (($handle = fopen("temp/$fichier", "r")) !== FALSE) 
{
	$ErrorSQL = "";
	
    while (($data = fgetcsv($handle, 1024, ";",",")) !== FALSE)
     {
        $num = count($data);
       // echo "<p> $num champs à la ligne $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) 
        {
        	if (Parite($c) == 1)
        	{
      		$pseudo = $data[$c];
			$SelectSQL = 'SELECT * FROM amis WHERE PSEUDO_AMIS="'.$pseudo.'" AND ID_CANDIDAT="'.$_SESSION['ID'].'"';
       		$ExecutSelect = mysql_query($SelectSQL)or die(mysql_error());
			$Get = mysql_fetch_array($ExecutSelect);
			if ($Get['PSEUDO_AMIS'] == NULL)
			{
				//echo $Get['PSEUDO_AMIS'];
      		$InsertSQL = 'INSERT INTO amis VALUES("","'.$_SESSION['ID'].'","'.$pseudo.'", "'.$pseudo.'")';
       		$ExecutSQL = mysql_query($InsertSQL) or die('<div align="left" style="font-size:18px"><font color="red">Il y a eu des espaces libres ou des doublons dans votre fichier. ils ont de ce fait ete supprimes.<a href="listedamis.php">Retour</a> </font></div>');
			}
			}
     	    else
     	    {
      		$number = $data[$c];
			$numero=str_replace(' ','',$number);
      if (strlen($numero) == 8) {$numero = "225".$numero;}
			if (is_numeric($numero)) // Verifier que c'est bel et bien un numero
			{
			$SelectSQL2 = 'SELECT * FROM amis WHERE NUM_AMIS="'.$numero.'" AND ID_CANDIDAT="'.$_SESSION['ID'].'"';
       		$ExecutSelect2 = mysql_query($SelectSQL2)or die(mysql_error());
			$Get2 = mysql_fetch_array($ExecutSelect2);
			if ($Get2['NUM_AMIS'] == NULL)
			{
				//echo $Get2['NUM_AMIS'];
      		$UpdateSQL = 'UPDATE amis SET NUM_AMIS="'.$numero.'" WHERE PSEUDO_AMIS="'.$pseudo.'"';
       		$ExecutSQL2 = mysql_query($UpdateSQL) or die('<div align="left" style="font-size:18px"><font color="red">Il y a eu des espaces libres ou des doublons dans votre fichier. ils ont de ce fait ete supprimes.<a href="friends_list.php">Retour</a> </font></div>');
			}
			}
			}
        }
		
		
            		
        	
    }
	
    echo "Contact charge avec succes";
    fclose($handle);
	$_SESSION['contact'] = "ok"; 
}

/*--------------------------------------Insertion dans la bd globale-------------------------*/
/*connectbd();
$row = 1;
if (($handle = fopen("temp/$fichier", "r")) !== FALSE) 
{
  $ErrorSQL = "";
  
    while (($data = fgetcsv($handle, 1024, ";",",")) !== FALSE)
     {
        $num = count($data);
       // echo "<p> $num champs à la ligne $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) 
        {
          if (Parite($c) == 1)
          {
          $pseudo = $data[$c];
      $SelectSQL = 'SELECT * FROM amis WHERE PSEUDO_AMIS="'.$pseudo.'" AND ID_CANDIDAT="'.$_SESSION['ID'].'"';
          $ExecutSelect = mysql_query($SelectSQL)or die(mysql_error());
      $Get = mysql_fetch_array($ExecutSelect);
      if ($Get['PSEUDO_AMIS'] == NULL)
      {
        //echo $Get['PSEUDO_AMIS'];
          $InsertSQL = 'INSERT INTO amis VALUES("","'.$_SESSION['ID'].'","'.$pseudo.'", "'.$pseudo.'")';
          $ExecutSQL = mysql_query($InsertSQL) or die('<div align="left" style="font-size:18px"><font color="red">Il y a eu des espaces libres ou des doublons dans votre fichier. ils ont de ce fait ete supprimes.<a href="friends_list.php">Retour</a> </font></div>');
      }
      }
          else
          {

          $number = $data[$c];
      $numero = str_replace(' ','',$number);
      if (strlen($numero) == 8) {$numero = "228".$numero;}
      if (is_numeric($numero)) // Verifier que c'est bel et bien un numero
      {
      $SelectSQL2 = 'SELECT * FROM amis WHERE NUM_AMIS="'.$numero.'" AND ID_CANDIDAT="'.$_SESSION['ID'].'"';
          $ExecutSelect2 = mysql_query($SelectSQL2)or die(mysql_error());
      $Get2 = mysql_fetch_array($ExecutSelect2);
      if ($Get2['NUM_AMIS'] == NULL)
      {
        //echo $Get2['NUM_AMIS'];
          $UpdateSQL = 'UPDATE amis SET NUM_AMIS="'.$numero.'" WHERE PSEUDO_AMIS="'.$pseudo.'"';
          $ExecutSQL2 = mysql_query($UpdateSQL) or die('<div align="left" style="font-size:18px"><font color="red">Il y a eu des espaces libres ou des doublons dans votre fichier. ils ont de ce fait ete supprimes.<a href="friends_list.php">Retour</a> </font></div>');
      }
      }
      }
    }
    
    
                
          
    }
  
    echo "Contact charge avec succes";
    fclose($handle);
  $_SESSION['contact'] = "ok"; 
}*/
$GoTo = "ajouter.php";

	header("Location: ". $GoTo);
?>