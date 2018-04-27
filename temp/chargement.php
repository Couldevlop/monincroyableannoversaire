<?php  


/*********DEBUT EXTRATION DE CINTACT DU FICHIER ET INSERTION DS LA BD ****************************/

function Parite ($Nombre) // verifier la parite d'un nombre 
{

	$tamp = $Nombre%2;// tamp recoit le reste de la division
	if ( $tamp == 0)
		return 1;
	else return 0;
}
function connectbd2(){
    $base = mysql_connect ('localhost','root','telcosarl2013');
    mysql_select_db ('gamebd_tg',$base);
}
function connectbd(){
    $base = mysql_connect ('localhost','root','telcosarl2013');
    mysql_select_db ('gamebd_togo',$base);
}


//---------------------------------

 // $_SESSION['ID'] = 2;   
//-----------------------
 //include("caractere.php");
$row = 0;
$a = 0;
if (($handle = fopen("FREDY.csv", "r")) !== FALSE) 
{
	$ErrorSQL = "";
	
    while (($data = fgetcsv($handle, 1024, ";",",")) !== FALSE)
     {
        $num = count($data);
       // echo "<p> $num champs à la ligne $row: <br /></p>\n";
        $row = $row+ 1;
       
      		$pseudo = $data[0];
          $numero = "228".$data[1];
        //  $statut = $data[2];
          //$prenom = FileNameGen($prenom);
           connectbd2();
    	  $SelectId = 'SELECT ID_CANDIDAT FROM candidat WHERE NUM_CANDIDAT="22899498043"';
          $ExecutSelectId = mysql_query($SelectId)or die(mysql_error());
          $GetiD = mysql_fetch_array($ExecutSelectId);

         
        if ($GetiD['ID_CANDIDAT'] != NULL )
        {
      		$InsertSQL = 'INSERT INTO amis VALUES(" ","'.$GetiD['ID_CANDIDAT'].'","'.$pseudo.'", "'.$numero.'")';
      		
       		$ExecutSQL = mysql_query($InsertSQL);  
       		if (!$ExecutSQL)  
       		{
       			echo "Existant";
       			echo '</br>';
       		}    
       		
        }
        else
        {
        	echo "candidat inexistant";
        	echo '</br>';
        }
       /* connectbd2();

        $SelectId2 = 'SELECT ID_CANDIDAT FROM candidat WHERE NUM_CANDIDAT="'. $numero .'"';
          $ExecutSelectId2 = mysql_query($SelectId2)or die(mysql_error());
          $GetiD2 = mysql_fetch_array($ExecutSelectId2);

         
        if ($GetiD2['ID_CANDIDAT'] != NULL )
        {
      		$InsertSQL2 = 'INSERT INTO amis VALUES(" ","'.$GetiD2['ID_CANDIDAT'].'","'.$pseudo.'", "'.$numero.'")';
       		
       		$ExecutSQL2 = mysql_query($InsertSQL2);  
       		if (!$ExecutSQL2)  
       		{
       			echo "Existant";
       			echo '</br>';
       		}    
       		 
        }
        else
        {
        	echo "candidat inexistant 2";
        	echo '</br>';
        }
			
     	 		*/
     }   	
}
	
    echo "Contact charge avec succes";
    fclose($handle);
	

//	header("Location: ". $GoTo);
?>