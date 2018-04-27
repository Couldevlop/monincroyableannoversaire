<?php
error_reporting(0);
$menunavactv="Inscription";
require_once('Connections/ConnexionProfil.php'); 
if (!isset($_SESSION)) {
  session_start();
}
require_once('logout2.php');

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
<title>Inscription</title>
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
<script language="Javascript">
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
		//alert('Le numero mobile comporte ' + mini + ' chiffres.');
    alert(substr(monchamps.value,0,2));
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

  /*if (substr(monchamps.value,0,2) = '08')
  {
    alert('Vous devez saisir un numero MTN' );
    return false
  }*/
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

<div class="regleftposter"></div>

<div class="registetion">

<h1>Formulaire d'inscription</h1>
<form align="center" id=payment action="inscriptions_traite.php" name="inscription" method="post" enctype="multipart/form-data">

<input type="text" style="font-weight:bold" id="name" name="nom" placeholder="Nom" value="<?php echo $Login; ?>" class="registerform" required />
<div class="clear"></div>
<input type="text" style="font-weight:bold" id="phone" name="prenoms" placeholder="Prénoms" value="<?php echo $Prénoms; ?>" class="registerform" />



<div class="regmain">
 <select name="jour" id="Date" class="inqdropp" required>
    
   <option value="0">Né(e) le</option>
                  <option value="1">1</option>
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
    
   <div class="regmain"> 
  <select name="mois" id="Mois" class="inqdropp" required>
    
   <option value="0">Mois</option>
   		<option value="1">Janvier</option>
        <option value="2">Février</option>
        <option value="3">Mars</option>
        <option value="4">Avril</option>
        <option value="5">Mai</option>
        <option value="6">Juin</option>
        <option value="7">Juillet</option>
        <option value="8">Aout</option>
        <option value="9">Septembre</option>
        <option value="10">Octobre</option>
        <option value="11">Novembre</option>
        <option value="12">Décembre</option>
    
    </select>
    </div>
    
    
    <input style="width:25%;font-weight:bold"  type="text" name="annee" class="registerform" placeholder="Année" maxlength="4" onkeyup="verif_nombre(this);" min="4" onBlur="valider_annee(this)"/>
   
<div class="clear"></div>

<input type="text" style="font-weight:bold" id="phone" name="numero" placeholder="Téléphone mobile / Ex: 90909090" value="<?php echo $phone; ?>" class="registerform" required  onkeyup="verif_nombre(this);" maxlength="8" onBlur="valider_numero(this)"/>
<div class="clear"></div>
<input type="text" style="font-weight:bold" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" class="registerform" />
<div class="clear"></div>
<input type="text" style="font-weight:bold" id="login" name="login" placeholder="Login / Identifiant" value="<?php echo $login; ?>" class="registerformm" required onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/ig, '');" />

<a href="#" title="Seuls les caracteres de l'alphabet et les chiffres sont autorises dans le Login et le mot de passe. Merci"><img src="images/questionmark.png"></a>
<div class="clear"></div>
<input type="password" style="font-weight:bold" id="mot" name="password" placeholder="Mot de passe" value="<?php echo $mot; ?>" class="registerform" required onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/ig, '');" />

<?php
if (isset($_SESSION['pas_mtn']))
  {
?>
<p align="center" style="color:#F00; font-weight:bold">Veuillez saisir un numéro MTN SVP.</p>
<?php }
unset($_SESSION['pas_mtn']);
?>
<div class="clear"></div>
<input type="submit" id="submit" onClick="return contactvalitation();"  name="contactsubmit" value="Envoyer" class="changesubbtn" />
<div class="clear"></div>

</form>
</div>


<div class="regposter"></div>






<div class="clear"></div>

</div>




<BR><BR>

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
