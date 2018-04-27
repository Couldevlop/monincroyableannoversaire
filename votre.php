<?php require_once('Connections/ConnexionBD.php');
error_reporting(0);
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
<title>Classement</title>
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

<div class="votretop">
<div class="votreimg"><img src="images/4.png"></div>
<div class="votreimgg"><img src="images/3.png"></div>
<form action="votre_traite.php" method="post">
<div class="votretag"><strong>Saisir Votre</strong></div>

<div class="votredrop">
  <input type="text" name="identifiant" value=""  placeholder="Code de vote"  style="background:none; border:none;" required> 
    </div><input type="submit" id="submit" onClick="return contactvalitation();"  name="contactsubmit" value="Envoyer" class="contactsubbbtn" style="margin:0; float:left; font-size:12px; width:70px;" />
<div class="clear"></div>

<div class="downtag">
<div class="downheading"><strong>Votre classement</strong></div>
<p><strong><?php if ( isset($_SESSION['LOGIN']) ) {echo $_SESSION['LOGIN']; unset($_SESSION['LOGIN']);}   ?></strong> <span><?php if ( isset($_SESSION['NBSMS']) ) {echo $_SESSION['NBSMS'];  ?> SMS <?php unset($_SESSION['NBSMS']); } ?></span></p>
</div>
<div class="clear"></div>

</form>
</div>

<div class="votre">
<div class="votrearotop"><i class="fa fa-arrow-up" id="nnnttt-example1-prev"></i></div>
<div class="votrearodown"> <i class="fa fa-arrow-down" id="nnnttt-example1-next"></i></div>
<div class="votreheading">Top 10 d'aujourd'hui</div>


<ul id="nnnttt-example1" class="newscrZXoll">
<?php 
setlocale(LC_TIME,'fr_FR','fra'); 
  
date_default_timezone_set('Africa/Abidjan');
mysql_select_db($database_ConnexionBD,$ConnexionBD);
 $SelectSQL = 'SELECT * FROM candidat_jour ORDER BY NBSMS DESC LIMIT 10';
 $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
 
?>

<?php while ($Recup = mysql_fetch_assoc($ExecutSQL)) { ?>


<li>
<div class="votreuser"><img src="<?php echo 'photo/'.$Recup['PHOTO']; ?>"></div>
<div class="votreusertext">
<strong><?php echo $Recup['NOM_CANDIDAT']." ".$Recup['PREN_CANDIDAT'];?></strong><br> Numero <?php if (strlen($Recup['NUMERO']) == 11) { echo substr($Recup['NUMERO'],3,8); } else {echo $Recup['NUMERO'];} ?> <br>RANG: <?php echo $Recup['ID'] ?>e <br> <?php echo date("d-m-Y") ;?>
</div>
<div class="clear"></div>
</li>

<?php } ?>
      
</ul>
</div>


<div class="votre">
<div class="votrearotop"><i class="fa fa-arrow-up" id="nnttt-example1-prev"></i></div>
<div class="votrearodown"> <i class="fa fa-arrow-down" id="nnttt-example1-next"></i></div>
<?php $jour = date("d") + 1; ?>
<div class="votreheading">Top 10 du <?php echo $jour."-".date("m-Y") ;?></div>


<ul id="nnttt-example1" class="newscrZXoll">

<?php 
setlocale(LC_TIME,'fr_FR','fra'); 
  
date_default_timezone_set('Africa/Abidjan');
mysql_select_db($database_ConnexionBD,$ConnexionBD);
 $SelectSQL = 'SELECT * FROM candidat_jour_plus1 ORDER BY NBSMS DESC LIMIT 10';
 $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
  // Mettre la date en format francais
?>

<?php while ($Recup = mysql_fetch_assoc($ExecutSQL)) { ?>


<li>
<div class="votreuser"><img src="<?php echo 'photo/'.$Recup['PHOTO']; ?>"></div>
<div class="votreusertext">
<strong><?php echo $Recup['NOM_CANDIDAT']." ".$Recup['PREN_CANDIDAT'];?></strong><br> Numero <?php if (strlen($Recup['NUMERO']) == 11) { echo substr($Recup['NUMERO'],3,8); } else {echo $Recup['NUMERO'];} ?> <br>RANG: <?php echo $Recup['ID'] ?>e <br> <?php echo $jour."-".date("m-Y") ;?>
</div>
<div class="clear"></div>
</li>

<?php } ?>
      
</ul>
</div>


<div class="votre">
<div class="votrearotop"><i class="fa fa-arrow-up" id="nntt-example1-prev"></i></div>
<div class="votrearodown"> <i class="fa fa-arrow-down" id="nntt-example1-next"></i></div>
<?php $jour2 = date("d") + 2; ?>
<div class="votreheading">Top 10 du <?php echo $jour2."-".date("m-Y") ;?></div>


<ul id="nntt-example1" class="newscrZXoll">

<?php 
setlocale(LC_TIME,'fr_FR','fra'); 
  
date_default_timezone_set('Africa/Abidjan');
mysql_select_db($database_ConnexionBD,$ConnexionBD);
 $SelectSQL = 'SELECT * FROM candidat_jour_plus2 ORDER BY NBSMS DESC LIMIT 10';
 $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
  // Mettre la date en format francais
?>

<?php while ($Recup = mysql_fetch_assoc($ExecutSQL)) { ?>


<li>
<div class="votreuser"><img src="<?php echo 'photo/'.$Recup['PHOTO']; ?>"></div>
<div class="votreusertext">
<strong><?php echo $Recup['NOM_CANDIDAT']." ".$Recup['PREN_CANDIDAT'];?></strong><br> Numero <?php if (strlen($Recup['NUMERO']) == 11) { echo substr($Recup['NUMERO'],3,8); } else {echo $Recup['NUMERO'];} ?> <br>RANG: <?php echo $Recup['ID'] ?>e <br> <?php echo $jour2."-".date("m-Y") ;?>
</div>
<div class="clear"></div>
</li>

<?php } ?>
      
</ul>
</div>

<div class="votre">
<div class="votrearotop"><i class="fa fa-arrow-up" id="ntt-example1-prev"></i></div>
<div class="votrearodown"> <i class="fa fa-arrow-down" id="ntt-example1-next"></i></div>
<?php $jour3 = date("d") + 3; ?>
<div class="votreheading">Top 10 du <?php echo $jour3."-".date("m-Y") ;?></div>


<ul id="ntt-example1" class="newscrZXoll">
<?php 
setlocale(LC_TIME,'fr_FR','fra'); 
  
date_default_timezone_set('Africa/Abidjan');
mysql_select_db($database_ConnexionBD,$ConnexionBD);
 $SelectSQL = 'SELECT * FROM candidat_jour_plus3 ORDER BY NBSMS DESC LIMIT 10';
 $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
  // Mettre la date en format francais
?>

<?php while ($Recup = mysql_fetch_assoc($ExecutSQL)) { ?>


<li>
<div class="votreuser"><img src="<?php echo 'photo/'.$Recup['PHOTO']; ?>"></div>
<div class="votreusertext">
<strong><?php echo $Recup['NOM_CANDIDAT']." ".$Recup['PREN_CANDIDAT'];?></strong><br> Numero <?php if (strlen($Recup['NUMERO']) == 11) { echo substr($Recup['NUMERO'],3,8); } else {echo $Recup['NUMERO'];} ?> <br>RANG: <?php echo $Recup['ID'] ?>e <br> <?php echo $jour2."-".date("m-Y") ;?>
</div>
<div class="clear"></div>
</li>

<?php } ?>
</ul>
</div>


<div class="votre">
<div class="votrearotop"><i class="fa fa-arrow-up" id="nt-example1-prev"></i></div>
<div class="votrearodown"> <i class="fa fa-arrow-down" id="nt-example1-next"></i></div>
<?php $jour4 = date("d") + 4; ?>
<div class="votreheading">Top 10 du <?php echo $jour4."-".date("m-Y") ;?></div>


<ul id="nt-example1" class="newscrZXoll">
<?php 
setlocale(LC_TIME,'fr_FR','fra'); 
  
date_default_timezone_set('Africa/Abidjan');
mysql_select_db($database_ConnexionBD,$ConnexionBD);
 $SelectSQL = 'SELECT * FROM candidat_jour_plus4 ORDER BY NBSMS DESC LIMIT 10';
 $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
  // Mettre la date en format francais
?>

<?php while ($Recup = mysql_fetch_assoc($ExecutSQL)) { ?>


<li>
<div class="votreuser"><img src="<?php echo 'photo/'.$Recup['PHOTO']; ?>"></div>
<div class="votreusertext">
<strong><?php echo $Recup['NOM_CANDIDAT']." ".$Recup['PREN_CANDIDAT'];?></strong><br> Numero <?php if (strlen($Recup['NUMERO']) == 11) { echo substr($Recup['NUMERO'],3,8); } else {echo $Recup['NUMERO'];} ?> <br>RANG: <?php echo $Recup['ID'] ?>e <br> <?php echo $jour2."-".date("m-Y") ;?>
</div>
<div class="clear"></div>
</li>

<?php } ?>
      
</ul>
</div>




















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
                row_height: 130,
                max_rows: 3,
                duration: 4000,
                prevButton: $('#nt-example1-prev'),
                nextButton: $('#nt-example1-next')
            });
			
			   var ntt_example1 = $('#ntt-example1').newsTicker({
                row_height: 130,
                max_rows: 3,
                duration: 4000,
                prevButton: $('#ntt-example1-prev'),
                nextButton: $('#ntt-example1-next')
            });
			
			
			var ntt_example1 = $('#nntt-example1').newsTicker({
                row_height: 130,
                max_rows: 3,
                duration: 4000,
                prevButton: $('#nntt-example1-prev'),
                nextButton: $('#nntt-example1-next')
            });
			
			
			var ntt_example1 = $('#nnttt-example1').newsTicker({
                row_height: 130,
                max_rows: 3,
                duration: 4000,
                prevButton: $('#nnttt-example1-prev'),
                nextButton: $('#nnttt-example1-next')
            });
			
			
			
			var ntt_example1 = $('#nnnttt-example1').newsTicker({
                row_height: 130,
                max_rows: 3,
                duration: 4000,
                prevButton: $('#nnnttt-example1-prev'),
                nextButton: $('#nnnttt-example1-next')
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
