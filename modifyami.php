<?php
error_reporting(0);
$deshboard="Modifier ami";
?>
<?php require_once('Connections/ConnexionProfil.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}


if (!(isset($_SESSION['MM_Username'])))
{
	 $GoTo = "monprofile.php";
 
    header("Location: $GoTo");
}
$ID = $_SESSION['ID'];
mysql_select_db($database_ConnexionBD,$ConnexionBD);
	   $SelectSQL = 'SELECT * FROM candidat WHERE ID_CANDIDAT="'.$ID.'"';
	   $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
	   $Recup = mysql_fetch_assoc($ExecutSQL);
	   
	   //-***************************
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	/* eviter doublons ds les noms */
	$SelectSQL = 'SELECT * FROM amis WHERE ID_CANDIDAT="'.$_SESSION['ID'].'" AND NUM_AMIS="'.$_POST['NUM_AMIS'].'"';
       		$ExecutSelect = mysql_query($SelectSQL)or die(mysql_error());
			$Get = mysql_fetch_array($ExecutSelect);
	$SelectSQL2 = 'SELECT * FROM amis WHERE ID_CANDIDAT="'.$_SESSION['ID'].'" AND PSEUDO_AMIS="'.$_POST['PSEUDO_AMIS'].'"';
       		$ExecutSelect2 = mysql_query($SelectSQL2)or die(mysql_error());
			$Get2 = mysql_fetch_array($ExecutSelect2);
			if ( $Get['NUM_AMIS'] == NULL || $Get2['PSEUDO_AMIS'] == NULL)
			{
  $updateSQL = sprintf("UPDATE amis SET PSEUDO_AMIS=%s, NUM_AMIS=%s WHERE ID_AMIS=%s",
                       
                       GetSQLValueString($_POST['PSEUDO_AMIS'], "text"),
                       GetSQLValueString($_POST['NUM_AMIS'], "text"),
                       GetSQLValueString($_POST['ID_AMIS'], "int"));

  mysql_select_db($database_ConnexionBD, $ConnexionBD);
  $Result1 = mysql_query($updateSQL, $ConnexionBD) or die(mysql_error());

			}
		
			else
			 //  a revoir
			{ $_SESSION['existPseudo'] = "ok";}

  $updateGoTo = "listedamis.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
 //Pour la modification
 
 $colname_Recordset1 = "-1";
if (isset($_GET['IDAMIS'])) {
  $colname_Recordset1 = $_GET['IDAMIS'];
}
mysql_select_db($database_ConnexionBD, $ConnexionBD);
$query_Recordset1 = sprintf("SELECT * FROM amis WHERE ID_AMIS = '".base64_decode($_GET['IDAMIS'])."'", GetSQLValueString($colname_Recordset1, "int"));
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
<title>Fabian</title>
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
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>

<div class="mainwidth">

<?php include("include/header.php"); ?>


<?php include("include/menu.php"); ?>



<?php include("include/marqu.php"); ?>



<div class="monprofilemain">
<div class="afterlogin">
<div class="afterloginimg"><img src="images/cartoon2.png"></div>
<div class="myprofilemain" id="last">
<div class="myprofile" id="last">
<strong>Modifier votre ami</strong>
</div>
 <div class="clear"></div>
 
<div class="myprofile" id="last">
<strong>• Pseudo/Nom:</strong>
</div>
<div class="myprofile">
<form class="commentForm" action="<?php echo $editFormAction; ?>" method="post">

<input type="text" id="name" name="PSEUDO_AMIS" placeholder="Entrer le Pseudo de votre ami"  value="<?php echo htmlentities($row_Recordset1['PSEUDO_AMIS'], ENT_COMPAT, 'utf-8'); ?>" class="myprofileform" />
</div>


<div class="myprofile" id="last">
<strong>• Numéro mobile:</strong>
</div>
<div class="myprofile">
<input type="text" id="name" name="NUM_AMIS"  placeholder="Entrez le numero mobile de votre ami" value="<?php echo htmlentities($row_Recordset1['NUM_AMIS'], ENT_COMPAT, 'utf-8'); ?>" onkeyup="verif_nombre(this);" maxlength="8" onBlur="valider_numero(this)" class="myprofileform" />
</div>

 <div class="clear"></div>
 
 <input type="submit" id="submit" onClick="return contactvalitation();"  name="contactsubmit" value="Envoyer" class="changesubbtn" />
 <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID_AMIS" value="<?php echo $row_Recordset1['ID_AMIS']; ?>" />
</form>
</div>
<div class="clear"></div>

</div>


</div>


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
<?php
mysql_free_result($Recordset1);
?>