<?php require_once('Connections/ConnexionProfil.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

function balanceSMS($message, $telephone) 
{ 
//$message = urlencode(strtoupper($message)); 
$message = urlencode($message);
$url = "http://localhost:12013/cgi-bin/sendsms?username=telcoSender&password=telco12345&to=$telephone&text=$message";  
$fp = @fopen($url, "r");
 if ($fp) 
fclose($fp);
 }

function connectbd(){
    $base = mysql_connect ('localhost','telco','telcosarl2013');
    mysql_select_db ('telco_anniv_ci',$base);
}
function connectbd2(){
    $base = mysql_connect ('localhost','telco','telcosarl2013');
    mysql_select_db ('telco_anniv_ci',$base);
}
require_once('caractere.php');

$amdp = mysql_real_escape_string(htmlspecialchars($_POST['amdp'])); 
$login = mysql_real_escape_string(htmlspecialchars($_POST['login'])); 
//$email = mysql_real_escape_string(htmlspecialchars($_POST['email']));

mysql_select_db($database_ConnexionBD,$ConnexionBD);
     $SelectSQL = 'SELECT PWD_CANDIDAT FROM candidat WHERE LOGIN_CANDIDAT="'.$login.'" ';
     $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD) or die(mysql_error());
     $Recup = mysql_fetch_assoc($ExecutSQL) ;

     if ($Recup['PWD_CANDIDAT'] != NULL)
	 {
	 	$_SESSION['lg'] = "ok";

     	if ($Recup['PWD_CANDIDAT'] == $amdp)
		 {
		 	

		 	$nmdp = mysql_real_escape_string(htmlspecialchars($_POST['nmdp'])); 
		 	$cnmdp = mysql_real_escape_string(htmlspecialchars($_POST['cnmdp'])); 
		 	if ($nmdp == $cnmdp)
		 	{
		 	$_SESSION['cpwd'] = "ok";
		 //	echo "Mot de passe id";
		 	$UpdateSQL = 'UPDATE candidat SET PWD_CANDIDAT="'.$nmdp.'" WHERE LOGIN_CANDIDAT="'.$login.'"';
       	    $ExecutUpdateSQL = mysql_query($UpdateSQL, $ConnexionBD) or die(mysql_error());
       	    $RecupUpdate = mysql_fetch_assoc($ExecutUpdateSQL) ;

       	    $msg = "Votre nouveau mot de passe est: ".$nmdp;
       	    $SelectNumSQL = 'SELECT NUM_CANDIDAT FROM candidat WHERE LOGIN_CANDIDAT="'.$login.'" ';
     		$ExecutNumSQL = mysql_query($SelectNumSQL, $ConnexionBD) or die(mysql_error());
     		$RecupNum = mysql_fetch_assoc($ExecutNumSQL);
     		$telephone = $RecupNum['NUM_CANDIDAT'];
       	    balanceSMS($msg, $telephone);
       	    $GoTo = "change.php"; 
   		  //  header("Location: $GoTo");
		 	}
	 		else
	 		{
	 		$_SESSION['cpwd'] = "non";
	 		//echo "Mot d passe nn id";
	 		$GoTo = "change.php"; 
   		   // header("Location: $GoTo");
	 		}
       	   
       	}
       	else

       	{
       		$_SESSION['cpwd'] = "non";
       		$GoTo = "change.php"; 
   		   // header("Location: $GoTo");
       	}
	} else
	{
		$_SESSION['lg'] = "non";
		$GoTo = "change.php"; 
   	//	header("Location: $GoTo");
	}

	?>

      
