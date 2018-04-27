<?php
error_reporting(0);
$menunavactv="Description";
?>
<?php require_once('Connections/ConnexionBD.php');

  mysql_select_db($database_ConnexionBD,$ConnexionBD);
     $SelectCan = 'SELECT ID_CANDIDAT,PHOTO FROM candidat';
     $ExecutCan = mysql_query($SelectCan, $ConnexionBD);
    while ( $RecupCan = mysql_fetch_assoc($ExecutCan) )
    {
        $dirname = 'photo/'; /* Verifier l'existance de la photo en cas de pblm*/
        $dir = opendir($dirname); 
        $trouve = false;
        $IDTrouve = NULL;
        while($file = readdir($dir)) 
        {
            if($file == $RecupCan['PHOTO'])/*($file != '.' && $file != '..' && !is_dir($dirname.$file))*/
            {
                $trouve = true;
            }
           else $IDTrouve = $RecupCan['ID_CANDIDAT'];
        }
        closedir($dir);
        if ($trouve == false) {
            //$nomfic = "default.jpg"; // en cas d'absence de la photo, on lui attribue la tof par defaut
        //  echo $RecupCan['PHOTO']."  ";
            $updateCand = "UPDATE candidat SET PHOTO='default.jpg' WHERE ID_CANDIDAT='".$IDTrouve."'";// WHERE ID_CANDIDAT='".$IDTrouve."'
            $ExecutUpdateCand = mysql_query($updateCand, $ConnexionBD);
            
            //mysql_query($updateCand, $ConnexionBD) or die(mysql_error());
                       
             }
    }

/*
En cas de candidat dont les photos sont inexistantes dans sur notre disque, on leur attribue la photo par defaut  qu'il peuvent ensuite modifier

*/

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
/*  echo "<pre>";
    print_r($_GET);
    echo "</pre>";*/
}

if (!isset($_SESSION)) {
  session_start();
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
<title>Description</title>
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
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>

<div class="mainwidth">

<?php include("include/header.php"); ?>


<?php include("include/menu.php"); ?>



<?php include("include/marqu.php"); ?>



<div class="monprofilemain">

<div class="description">
<h1>Description</h1>
<h2>1. Contexte du jeu</h2>
<p>« Le bon sens est la chose du monde la mieux partagée », dit René Descartes. C'est ainsi que le désir de célébrer et d'être célébré, de contenter et d'être contenté reste une chose que nous partageons tous, parents, amis, collègues, clients, « followers » sur les réseaux sociaux …<br>
 En effet, il nous tient tous à cœur de souhaiter un vibrant <strong>Joyeux Anniversaire</strong> avec un somptueux présent à nos Amis [parents, amis, collègues, clients, partenaires, followers…] le jour de la célébration de leur naissance. Aussi, tout un chacun rêve d'avoir un <strong>Anniversaire Inoubliable,</strong> un <strong>Incroyable Anniversaire </strong>où nous sommes arrosés de divers cadeaux. Cependant, les contraintes de notre quotidien, difficultés financières, indisponibilité due aux voyages, au travail font que très souvent nous n'arrivons pas à réaliser notre rêve ou notre souhait. Notre Platforme de Jeu <strong>"Mon Incroyable Anniversaire</strong> va donner l'opportunité à tous ces Wishers and Dreamers de réaliser leur rêve.</p>

<h2>2. Comment participer au jeu</h2>
 <strong><span>2.1 Inscription</span></strong>
<p>Inscrivez-vous gratuitement sur ce site avec vos informations personnelles dont les plus importantes sont votre date de naissance (jour, mois et année) et votre numéro de téléphone. Après l'inscription, vous recevrez un code de vote avec lequel vos amis pourront voter pour vous en envoyant un sms.</p>


<h2>3. Fonctionnement du jeu</h2>
<strong><span>3.1 Informer vos amis</span></strong>
<p>Le jour de votre anniversaire, un message vous sera envoyé pour vous rappeler votre anniversaire et comment vous pourrez voter pour vous-même. Egalement à vos amis, seront envoyés des messages leur rappelant votre participation au jeu et comment voter pour vous afin de vous faire gagner un super cadeau d'anniversaire.</p>

<strong><span>3.2 <!--Comment voter un ami en compétition ?-->Comment voter pour un ami en compétition ?</span></strong>
<!--<p>Le vote est simple, vous et vos amis n'aurez qu'à envoyer par SMS au numéro <strong>5005</strong> pour les abonnés <strong>Moov</strong> ou <strong>5006</strong> pour les abonnés <strong>Togocel,</strong> votre code de vote qui sera communiqué dans les messages.</p>-->

<p>Le vote est simple, vous et vos amis n'aurez qu'à envoyer par SMS au numéro 98164, votre code de vote qui sera communiqué dans les messages envoyés par nos soins.</p>


<strong><span>3.3 Comment suivre le concours ?</span></strong>
<p>Vous pouvez à tout moment suivre votre classement et la tendance sur notre site internet (www.telcoanniv.com/ci). Vous pourrez voir de façon dynamique tous les candidats concourant ce jour ainsi que leur position. Et plus précisément, vous aurez un zoom sur les dix en tête de liste ainsi que le lot du jour.</p>

<h2>4. Sélection du gagnant</h2>
<p>À la fin de la journée (23H), le candidat qui aura eu le nombre maximal de vote (SMS) se verra vainqueur du jeu pendant cette journée et bénéficiera d'un super <strong>cadeau d'anniversaire.</strong> La photo du vainqueur ainsi que son lot seront affichés sur notre site web (www.telcoanniv.com/ci).</p>


<h2>5. Réception des lots</h2>
<p>Le vainqueur devra se rendre dans nos locaux muni de sa pièce d'identité afin de retirer son lot.</p>






</div>

<div class="leftpanel">

<div class="leftposterr"><img src="images/leftimg5.png"></div>
<div class="posterr"><img src="images/Monanniv16.png"></div>

<div class="lefttopten">
<div class="leftmidaddheading">Top 10 en tete</div>


<marquee DIRECTION="up" BEHAVIOR="alternate" SCROLLAMOUNT="03" height="370" onmouseover="this.stop();" onmouseout="this.start();">
 
<li >
<?php 
 $SelectSQL = 'SELECT * FROM candidat_jour ORDER BY NBSMS DESC LIMIT 10';
 $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
?>

<?php while ($Recup2 = mysql_fetch_assoc($ExecutSQL)) { ?>
<div class="user">

  <img src="<?php echo 'photo/'.$Recup2['PHOTO']; ?>"></div><div class="usertext"><strong><?php echo $Recup2['NOM_CANDIDAT']." ".$Recup2['PREN_CANDIDAT'];?></strong><br> Numero: <?php if (strlen($Recup2['NUMERO']) == 11) { echo substr($Recup2['NUMERO'],3,8); } else {echo $Recup2['NUMERO'];} ?> <br><span>  RANG: <?php echo $Recup2['ID'] ?>e</span><br><?php date_default_timezone_set('UTC');
   echo date("d-M-Y"); ?></div><div class="clear"></div>
<?php } ?>
</li>

</marquee>

</div>
</ul>
</div>

<?php  //Recuperer les vainqueurs
    $SelectListeH = 'SELECT * FROM vainqueur';
    $ExecutListeH = mysql_query($SelectListeH , $ConnexionBD);
	function date_fr($date_saisie){
 
        //division de la date par rapport au / ou -
        @list ($jour , $mois , $an) = split("[-./]",$date_saisie);
        //inverse la date
        return($an."-".$mois."-".$jour);
 
}    // Mettre la date en format francais
 
 
    ?>

<div class="lefttopten">
<div class="leftmidaddheading">Historique des Vainqueurs</div>
<marquee DIRECTION="up" BEHAVIOR="alternate" SCROLLAMOUNT="03" height="370" onmouseover="this.stop();" onmouseout="this.start();">
<li>


<?php  while ($RecupListeH = mysql_fetch_assoc($ExecutListeH))
  { $SelectDetails = 'SELECT * FROM candidat WHERE ID_CANDIDAT="'.$RecupListeH['ID_CANDIDAT'].'"';
    $ExecutDetails = mysql_query($SelectDetails , $ConnexionBD);
    $RecupDetails = mysql_fetch_array($ExecutDetails);//Recuperer les informations du vainqueur
  
  $SelectPrixH = 'SELECT LIBELLE_PRIX FROM prix WHERE ID_PRIX="'.$RecupListeH['ID_PRIX'].'"';
    $ExecutPrixH = mysql_query($SelectPrixH , $ConnexionBD);
  $RecupPrixH = mysql_fetch_array($ExecutPrixH );//Recuperer le prix du vainqueur
  ?>
<div class="user"><img src="<?php echo 'photo/'.$RecupDetails['PHOTO']; ?>"></div><div class="usertext"><strong><?php echo $RecupDetails['NOM_CANDIDAT']." ".$RecupDetails['PREN_CANDIDAT']; ?></strong><br> Numero <?php echo $RecupDetails['NUM_CANDIDAT']; ?>  <br> <?php echo substr(date_fr($RecupListeH['DATE_VAINQ']),0,5); ?></div><div class="clear"></div>
<?php } ?> 
      
    
</li>
</marquee>
</ul>

</div>






</div>

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
