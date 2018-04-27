<?php
error_reporting(0);

$deshboard="Modifier mon profile";
?>

<?php

if (substr(phpversion(),0,1) == 5)
{
	include_once("crypt_url/secureURL.php");
}
else
{
	include_once("crypt_url/secureURL_php4.php");
}

class URL_Parser_JavaScript extends URL_Parser
{
	var $js = "javascript:gotopage";
	
	function isReadable($text)
	{
		if (strtolower(substr($text,0,strlen($this->js))) == $this->js)
		{
			return true;
		}
		
		return false;
	}
	
	function Read($text)
	{
		$url = substr($text,strlen($this->js) + 2); // ("
		$url = substr($url,0,strlen($url) - 3); // ");
		
		$url = str_replace("\\\"","\"",$url);
		$url = str_replace("\\'","'",$url);
		$url = html_entity_decode($url);
		
		return $url;
	}
	
	function Render($url)
	{
		$url = addslashes($url);
		
		return $this->js . "('" . $url . "');";
	}
}


SecureURL::setFilterIncludeOption(true); //Encode the URL when no filter matches it
SecureURL::addFilter(new URL_Filter_Simple("google.com",null,true,false)); //remove google from list
SecureURL::addParser(new URL_Parser_JavaScript());
SecureURL::Initialize(new URL_Encoder_Base64());

if (count($_GET))
{
/*	echo "<pre>";
	print_r($_GET);
	echo "</pre>";*/
}

?>
<?php require_once('Connections/ConnexionProfil.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}


if (!(isset($_SESSION['MM_Username'])))
{
   $GoTo = "authentification.php";
 
    header("Location: $GoTo");
}
/*  POUR ASELECTIONNER LE USERNAME ET PSWD*/
$ID = $_SESSION['ID'];
mysql_select_db($database_ConnexionBD,$ConnexionBD);
     $SelectSQL = 'SELECT * FROM candidat WHERE ID_CANDIDAT="'.$ID.'"';
     $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
     $Recup = mysql_fetch_assoc($ExecutSQL);
	 
/* RECUPERER LE ID DU CANDIDAT */
	  $colname_Recordset1 = "-1";
if (isset($_GET['IDCANDIDAT'])) {
  $colname_Recordset1 = $_GET['IDCANDIDAT'];
}
	if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_ConnexionBD, $ConnexionBD);
$query_Recordset1 = sprintf("SELECT * FROM candidat WHERE ID_CANDIDAT = '".base64_decode($_GET['IDCANDIDAT'])."'", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $ConnexionBD) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<!DOCTYPE html>
<!--[if IE 7 ]> <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html>
<!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Modifier profile</title>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<link rel="stylesheet" type="text/css" href="css/style.css" />
    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">
<script src="js/jquery-1.9.1.js"></script>

    <script src="assets/js/chart.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/prism.js"></script>
    <script src="assets/js/jquery.mCustomScrollbar.min.js"></script>
    <script src="assets/js/jquery.newsTicker.js"></script>
    
    
<script type="text/javascript">
function opnnav(){
$("#nav").slideToggle(500);
$(".transprntbg").show();

}

function closetrns(){
$("#nav").slideToggle(500);
$(".transprntbg").hide();

}



function openfile(){
$("#changepic").click();	
}

</script>
<script language="javascript" type='text/javascript'>
// deconnexion automatik d un user apres 5 min d inactivite
    function session(){
        window.location="logout.php"; //page de déconnexion
    }
  setTimeout("session()",900000); //ça fait bien 5min??? c'est pour le test
	
</script> 
<script language="javascript">
	function gotopage(url)//cryptage url
	{
		window.location = url;
	}
	</script>
    <script>
// Fonction desactiver les sugestion d'un input text
function disableAutocomplete(elementId)
{
    var e = document.getElementById(elementId);
    if(e != null)
    {
        e.setAttribute("autocomplete", "off");
    }
}
</script>
 <script>
function verif_nombre(champ)
  {
	var chiffres = new RegExp("[0-9]");
	var verif;
	var points = 0;
 
	for(x = 0; x < champ.value.length; x++)
	{
            verif = chiffres.test(champ.value.charAt(x));
	    if(champ.value.charAt(x) == "."){points++;}
            if(points > 1){verif = false; points = 1;}
  	    if(verif == false){champ.value = champ.value.substr(0,x) + champ.value.substr(x+1,champ.value.length-x+1); x--;}
	}
  }
</script>
 <script>
  function valider_numero(monchamps){
	var mini = 8
	var maxi = 8
	if ( mini != 0 ) {
	  // Si la longueur de la saisie est inférieure au minimum demandé
	  if ( monchamps.value.length < mini ) {
		// Envoi d'une alerte
		alert('Le numero mobile comporte ' + mini + ' chiffres.');
		return false
	  }
	}
	  // Si la longueur de la saisie est supérieure au maximum demandé
	if ( maxi != 0 ) {
	  if ( monchamps.value.length > maxi ) {
		alert('Vous ne devez pas saisir plus de ' + maxi + ' caracteres.');
		return false
	  }
	}
  }
  </script>
  <script>
  function valider_annee(monchamps){
	var mini = 4
	var maxi = 4
	if ( mini != 0 ) {
	  // Si la longueur de la saisie est inférieure au minimum demandé
	  if ( monchamps.value.length < mini ) {
		// Envoi d'une alerte
		alert('Une annee comporte ' + mini + ' chiffres.');
		return false
	  }
	}
	  // Si la longueur de la saisie est supérieure au maximum demandé
	if ( maxi != 0 ) {
	  if ( monchamps.value.length > maxi ) {
		alert('Vous ne devez pas saisir plus de ' + maxi + ' caracteres.');
		return false
	  }
	}
  }
  </script>
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>

<div class="mainwidth">

<?php include("include/header.php"); ?>


<?php include("include/menu.php"); ?>



<?php include("include/marqu.php"); ?>



<div class="monprofilemain">
<div class="afterlogin">
<div class="afterloginimg" style="bottom:0; right:30%;"><img src="images/cartoon2.png"></div>
<div class="photoedit">
<strong>Modifier mon profile</strong>
<form id=payment action="update_traite.php" name="form1" id="form1" method="post" enctype="multipart/form-data" >

<img src="<?php echo 'photo/'.$row_Recordset1['PHOTO']; ?>" height="175"><?php $_SESSION['photo'] = $row_Recordset1['PHOTO'];?><br><br>
<a href="javascript:void();" onClick="openfile();"><strong>modifier votre photo</strong></a>
<input name="MAX_FILE_SIZE" type="hidden" value="3000000" />
<input type="file" id="changepic" style="width:0px; height:0px; background:none;" name="photo">
</div>

<div class="myprofilemain">
<div class="myprofile">
<strong>Nom:</strong>
</div>
<div class="myprofile">

<input type="text" id="name" name="NOM_CANDIDAT" placeholder="" value="<?php echo htmlentities($row_Recordset1['NOM_CANDIDAT'], ENT_COMPAT, 'utf-8'); ?>" class="myprofileform" required />
</div>

<div class="myprofile">
<strong>Prénoms:</strong>
</div>
<div class="myprofile">
<input type="text" id="name" name="PREN_CANDIDAT" placeholder="" value="<?php echo htmlentities($row_Recordset1['PREN_CANDIDAT'], ENT_COMPAT, 'utf-8'); ?>" class="myprofileform" />
</div>
 <?php $_SESSION['date'] = htmlentities($row_Recordset1['DATE_CANDIDAT'], ENT_COMPAT, 'utf-8'); ?>
<div class="myprofile">
<strong>Né(e) le:</strong>
</div>
<div class="inqdropmain">
 <select name="jour" id="Date" class="inqdropp" required>
    
   <option value="0">Jour</option>
                  <option value="1" >1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
        
    
    </select>
    </div>
<div class="inqdropmain">
<select name="mois" id="Month" class="inqdropp" required>
    
   <option value="0">Mois</option>
        <option value="1">Janvier</option>
        <option value="2">Fevrier</option>
        <option value="3">Mars</option>
        <option value="4">Avril</option>
        <option value="5">Mai</option>
        <option value="6">Juin</option>
        <option value="7">Juillet</option>
        <option value="8">Aout</option>
        <option value="9">Septembre</option>
        <option value="10">Octobre</option>
        <option value="11">Novembre</option>
        <option value="12">Decembre</option>
        
    
    </select>
</div>

<input style="width:12%" type="text" name="annee" class="registerform" placeholder="Année" maxlength="4" onkeyup="verif_nombre(this);" min="4" onBlur="valider_annee(this)"/>
<div class="clear"></div>    


<div class="myprofile">
<strong>Téléphone:</strong>
</div>
<div class="myprofile">
<input type="text" id="phone" name="NUM_CANDIDAT" required placeholder="Telephone" value="<?php if ( strlen($row_Recordset1['NUM_CANDIDAT']) == 11 ) { echo htmlentities(substr($row_Recordset1['NUM_CANDIDAT'],3,8), ENT_COMPAT, 'utf-8');} else { echo htmlentities($row_Recordset1['NUM_CANDIDAT'], ENT_COMPAT, 'utf-8');} ?>" class="myprofileform" onkeyup="verif_nombre(this);" maxlength="8" onBlur="valider_numero(this)" />

</div>
<?php
if (isset($_SESSION['pas_mtn']))
  {
    echo ' <div align="left" style="font-size:14px"><font color="red">Veuillez saisir un numéro MTN SVP </font></div>';
   unset($_SESSION['pas_mtn']);
 }

?>

<input type="submit" id="submit" onClick="return contactvalitation();"  name="contactsubmit" value="Envoyer" class="changesubbtn" />


</div>
</div>
</form>

<?php include("include/deshboard.php"); ?>


<div class="clear"></div>


</div>






<?php include("include/footer.php"); ?>







<script>
    		$('a[href*=#]').click(function() {
			    var href = $.attr(this, 'href');
			    if (href != "#") {
				    $('html, body').animate({
				        scrollTop: $(href).offset().top - 81
				    }, 500, function () {
				        window.location.hash = href;
				    });
				}
				else {
					$('html, body').animate({
				        scrollTop: 0
				    }, 500, function () {
				        window.location.hash = href;
				    });
				}
			    return false;
			});

    		$(window).load(function(){
	            $('code.language-javascript').mCustomScrollbar();
	        });
            var nt_title = $('#nt-title').newsTicker({
                row_height: 74,
                max_rows: 5,
                duration: 3000,
                pauseOnHover: 0
            });
			
			var nt_titlee = $('#nt-titlee').newsTicker({
                row_height: 74,
                max_rows: 5,
                duration: 3000,
                pauseOnHover: 0
            });
			
			
            var nt_example1 = $('#nt-example1').newsTicker({
                row_height: 80,
                max_rows: 3,
                duration: 4000,
                prevButton: $('#nt-example1-prev'),
                nextButton: $('#nt-example1-next')
            });
            var nt_example2 = $('#nt-example2').newsTicker({
                row_height: 60,
                max_rows: 1,
                speed: 300,
                duration: 6000,
                prevButton: $('#nt-example2-prev'),
                nextButton: $('#nt-example2-next'),
                hasMoved: function() {
                	$('#nt-example2-infos-container').fadeOut(200, function(){
	                	$('#nt-example2-infos .infos-hour').text($('#nt-example2 li:first span').text());
	                	$('#nt-example2-infos .infos-text').text($('#nt-example2 li:first').data('infos'));
	                	$(this).fadeIn(400);
	                });
                },
                pause: function() {
                	$('#nt-example2 li i').removeClass('fa-play').addClass('fa-pause');
                },
                unpause: function() {
                	$('#nt-example2 li i').removeClass('fa-pause').addClass('fa-play');
                }
            });
            $('#nt-example2-infos').hover(function() {
                nt_example2.newsTicker('pause');
            }, function() {
                nt_example2.newsTicker('unpause');
            });
            var state = 'stopped';
            var speed;
            var add;
            var nt_example3 = $('#nt-example3').newsTicker({
                row_height: 80,
                max_rows: 1,
                duration: 0,
                speed: 10,
                autostart: 0,
                pauseOnHover: 0,
                hasMoved: function() {
                	if (speed > 700) {
                		$('#nt-example3').newsTicker("stop");
                		console.log('stop')
                		$('#nt-example3-button').text("RESULT: " + $('#nt-example3 li:first').text().toUpperCase());
                		setTimeout(function() {
                			$('#nt-example3-button').text("START");
                			state = 'stopped';
                		},2500);
                		
                	}
                	else if (state == 'stopping') {
                		add = add * 1.4;
                		speed = speed + add;
                		console.log(speed)
                		$('#nt-example3').newsTicker('updateOption', "duration", speed + 25);
                		$('#nt-example3').newsTicker('updateOption', "speed", speed);
                	}
                }
            });
            
            $('#nt-example3-button').click(function(){
            	if (state == 'stopped') {
	            	state = 'turning';
	            	speed = 1;
	            	add = 1;
	            	$('#nt-example3').newsTicker('updateOption', "duration", 0);
	            	$('#nt-example3').newsTicker('updateOption', "speed", speed);
	            	nt_example3.newsTicker('start');
	            	$(this).text("STOP");
	            }
	            else if (state == 'turning') {
	            	state = 'stopping';
	            	$(this).text("WAITING...");
	            }
            });
        </script>

</div>
</body>
</html>
