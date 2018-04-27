<?php
error_reporting(0);
$deshboard="Mon profile";
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
if (!isset($_SESSION)) {
  session_start();
}
if (!(isset($_SESSION['MM_Username'])))
{
   $GoTo = "index.php";
 
    header("Location: $GoTo");
}
/*  POUR ASELECTIONNER LE USERNAME ET PSWD*/
$ID = $_SESSION['ID'];
mysql_select_db($database_ConnexionBD,$ConnexionBD);
     $SelectSQL = 'SELECT * FROM candidat WHERE ID_CANDIDAT="'.$ID.'"';
     $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
     $Recup = mysql_fetch_assoc($ExecutSQL);
      function Mois ($chiffre)
     {
       if ($chiffre == "01")
        return "Janvier";
       else if ($chiffre == "02")
        return "Fevrier";
       else if ($chiffre == "03")
        return "Mars";
       else if ($chiffre == "04")
        return "Avril";
       else if ($chiffre == "05")
        return "Mai";
       else if ($chiffre == "06")
        return "juin";
       else if ($chiffre == "07")
        return "juillet";
       else if ($chiffre == "08")
        return "Aout";
       else if ($chiffre == "09")
        return "septembre";
       else if ($chiffre == "10")
        return "Octobre";
       else if ($chiffre == "11")
        return "Novembre";
       else if ($chiffre == "12")
        return "Decembre";
     }
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
<title>Profile</title>
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

<div class="photoedit">
<form  action="update_traitephoto.php" name="form1" id="form1" method="post" enctype="multipart/form-data" >
<img src="<?php echo 'photo/'.$Recup['PHOTO']; ?>" height="175"><br>
<?php $_SESSION['photo'] = $row_Recordset1['PHOTO'];?><br>
<a href="javascript:void();" onClick="openfile();"><strong>Ajouter ma photo</strong></a>
 <input name="MAX_FILE_SIZE" type="hidden" value="3000000" />
<input type="file" id="changepic" style="width:0px; height:0px; background:none;" name="photo">
<input style="float:left;" type="submit" id="submit" onClick="return contactvalitation();"  name="contactsubmit" value="Ajouter" class="changesubbtn" />
</form>
</div>



<div class="myprofilemain">
<div class="myprofile">
<strong>Nom:</strong>
</div>
<div class="myprofile">
<?php echo $Recup['NOM_CANDIDAT']; ?>
</div>

<div class="myprofile">
<strong>Prénoms:</strong>
</div>
<div class="myprofile">
<?php echo $Recup['PREN_CANDIDAT']; ?>
</div>

<div class="myprofile">
<strong>Né(e) le:</strong>
</div>
<div class="myprofile">
<?php 
  $Jour = substr($Recup['DATE_CANDIDAT'], 8);
  $Mois = substr(substr($Recup['DATE_CANDIDAT'], 5), 0, 2); echo $Jour." - ".Mois($Mois); ?>
</div>

<div class="myprofile">
<strong>Login:</strong>
</div>
<div class="myprofile">
<?php echo $Recup['LOGIN_CANDIDAT']; ?>
</div>

<div class="myprofile">
<strong>Téléphone:</strong>
</div>
<div class="myprofile">
<?php if ( strlen($Recup['NUM_CANDIDAT']) == 11 ) { echo substr($Recup['NUM_CANDIDAT'],3,8); } else { echo $Recup['NUM_CANDIDAT'];}?>
</div>

<div class="myprofile">
<strong>Code de vote:</strong>
</div>
<div class="myprofile">
    <strong style="font-size:10px;color:#093"> Le code sera envoye par sms plus tard</strong>
<?php echo "";//echo $Recup['CODE_CANDIDAT']; ?>
</div>

<div class="myprofile">
<strong>Nombre de voix:</strong>
</div>
<div class="myprofile">
<?php echo $Recup['NBSMS_CANDIDAT']; ?>
</div>

<?php if (isset($_SESSION['reponse'])) { echo '<p style="color:#F00">Ce numero est enregistre a un autre nom. Merci de changer!'; unset($_SESSION['reponse']);} ?>

</div>

<div class="clear"></div>
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
<?php $_SESSION['login'] = $Recup['LOGIN_CANDIDAT']; ?>
</div>
</body>
</html>
