<?php  require_once('Connections/ConnexionBD.php');
 mysql_select_db($database_ConnexionBD,$ConnexionBD);
		/* Selectionner le nombre eleve de sms*/
		setlocale(LC_TIME,'fr_FR','fra'); 
  
date_default_timezone_set('Africa/Abidjan');
// echo date("H");
		$WinSQL = 'SELECT Max(NBSMS_CANDIDAT) As Winner, ID_CANDIDAT FROM candidat WHERE DAY(DATE_CANDIDAT)="'.date("d").'" AND MONTH(DATE_CANDIDAT)="'.date("m").'" ';
	   $ExecutWinSQL = mysql_query($WinSQL, $ConnexionBD) or die(msql_error());
	   $RecupWin = mysql_fetch_array($ExecutWinSQL);
	   /* Selectionner le candidat*/
	   /*$WinSQL2 = 'SELECT ID_CANDIDAT FROM candidat WHERE DAY(DATE_CANDIDAT)="'.date("d").'" AND NBSMS_CANDIDAT="'.$RecupWin['Winner'].'"';
	   $ExecutWinSQL2 = mysql_query($WinSQL2, $ConnexionBD) or die(msql_error());
	   $RecupWin2 = mysql_fetch_array($ExecutWinSQL2);
	   /*     Selectionner le prix   */
	  
	  $SearchSQL = 'SELECT ID_PRIX,LIBELLE_PRIX FROM prix WHERE DATE_PRIX="'.date("Y-m-d").'"';
	  $ExecutSearch =  mysql_query($SearchSQL, $ConnexionBD) or die(msql_error());
	  $RecupSearch = mysql_fetch_array($ExecutSearch);

	 /* Insere le vainqueur ds la bd*/
	 $InsertSQL = 'INSERT INTO vainqueur VALUES("","'.$RecupSearch['ID_PRIX'].'","'.$RecupWin['ID_CANDIDAT'].'","'.date("Y-m-d").'","'.$RecupWin['Winner'].'")';
    $ExecutSearch1 = mysql_query($InsertSQL, $ConnexionBD) or die(msql_error());	
   //  echo $RecupWin2['ID_CANDIDAT']." ".$RecupSearch['ID_PRIX'];
	
	?> 