<?php require_once('Connections/ConnexionBD.php');
error_reporting(0);
$menunavactv="Historique des Vainqueurs";
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
<title>Historique</title>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<link rel="stylesheet" type="text/css" href="css/style.css" />
    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">
<script src="js/dt/jquery-1.6.2.js"></script>

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

<link rel="stylesheet" href="js/base/jquery.ui.all.css" />
<link rel="stylesheet" href="css/demos.css" />
<script src="js/dt/jquery.ui.core.js"></script>
<script src="js/dt/jquery.ui.datepicker.js"></script>

<script type="text/javascript">
    $(function() {
		$( "#inputField" ).inputField();
	});
	$(function() {
		$( "#datepicker1" ).inputField({ minDate: +1});
	});
</script>


<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>

<div class="mainwidth">

<?php include("include/header.php"); ?>


<?php include("include/menu.php"); ?>



<?php include("include/marqu.php"); ?>



<div class="monprofilemain">

<div class="historyteg"><strong>Sélectionner la date</strong></div>

    <form action="history_traite.php" method="post" >
<input type="text" id="inputField" name="date"  onFocus="if(this.value == 'Click to Select Date') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Click to Select Date';}" value="cliquer sur le jour" class="hisdrop" required/>
        
  <input type="submit" id="submit" onClick="return contactvalitation();"  name="contactsubmit" value="Envoyer" class="contactsubbbtn" style="margin:0; float:left; font-size:12px; width:70px;" />

</form>
<div class="clear"></div>
<?php 
 function connectbd(){
    $base = mysql_connect ('localhost','root','telcosarl2013');
    mysql_select_db ('telco_anniv_ci',$base);
}
connectbd();
$WinnerSQL = 'SELECT Max(ID_VAINQ) As Vainq,DATE_VAINQ FROM vainqueur';
$ExecutWinnerSQL = mysql_query($WinnerSQL);
$RecupWinner = mysql_fetch_array($ExecutWinnerSQL) or die(mysql_error()); // recuperer le dernier gagnant de la liste des vainqueurs

if ( $RecupWinner['Vainq'] != NULL )
{
/*  $SelectVainqInfo1 = 'SELECT * FROM vainqueur WHERE DATE_VAINQ="'.$RecupWinner['ID_VAINQ'].'"';
    $ExecutVainqInfo1 = mysql_query($SelectVainqInfo1);
  $RecupVainqInfo1 = mysql_fetch_array($ExecutVainqInfo1); //Recuperer les id du vainqueur
  
    $SelectPrix1 = 'SELECT LIBELLE_PRIX,PHOTO_PRIX,DETAIL_PRIX FROM prix WHERE ID_PRIX="'.$RecupVainqInfo1 ['ID_PRIX'].'"';
    $ExecutPrix1 = mysql_query($SelectPrix1);
  $RecupPrix1 = mysql_fetch_array($ExecutPrix1 );//Recuperer le prix du vainqueur

    $SelectVainq1 = 'SELECT * FROM candidat WHERE ID_CANDIDAT="'.$RecupVainqInfo1['ID_CANDIDAT'].'"';
    $ExecutVainq1 = mysql_query($SelectVainq1);
    $RecupVainq1 = mysql_fetch_array($ExecutVainq1);//Recuperer les informations du vainqueur

$dateEng1 = $RecupVainqInfo1['DATE_VAINQ'];*/
}
$SelectVainqInfo = 'SELECT * FROM vainqueur WHERE DATE_VAINQ="'.$_SESSION['date'].'"';
    $ExecutVainqInfo = mysql_query($SelectVainqInfo);
  $RecupVainqInfo = mysql_fetch_array($ExecutVainqInfo); //Recuperer les id du vainqueur
  
    $SelectPrix = 'SELECT LIBELLE_PRIX,PHOTO_PRIX,DETAIL_PRIX FROM prix WHERE ID_PRIX="'.$RecupVainqInfo ['ID_PRIX'].'"';
    $ExecutPrix = mysql_query($SelectPrix);
  $RecupPrix = mysql_fetch_array($ExecutPrix );//Recuperer le prix du vainqueur

    $SelectVainq = 'SELECT * FROM candidat WHERE ID_CANDIDAT="'.$RecupVainqInfo['ID_CANDIDAT'].'"';
    $ExecutVainq = mysql_query($SelectVainq);
    $RecupVainq = mysql_fetch_array($ExecutVainq);//Recuperer les informations du vainqueur

$dateEng = $RecupVainqInfo['DATE_VAINQ'];
function date_fr($date_saisie){
 
        //division de la date par rapport au / ou -
        @list ($jour , $mois , $an) = split("[-./]",$date_saisie);
        //inverse la date
        return($an."-".$mois."-".$jour);
 
}    // Mettre la date en format francais
 
   $dateFr = date_fr($dateEng);
?>  
<div class="history">
<div class="historyheading"><?php if (isset($_SESSION['date']) )
    { echo "VAINQUEUR DU: ".date_fr($_SESSION['date']); unset($_SESSION['date']);} else {echo "Selectionnez une date";} ?></div>
<img src="<?php echo 'photo/'.$RecupVainq['PHOTO']; ?>">
<h1><?php echo $RecupVainq['NOM_CANDIDAT']." ".$RecupVainq['PREN_CANDIDAT']; ?></h1>
<p>  &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; Numero <?php if (strlen($RecupVainq['NUM_CANDIDAT']) == 11) { echo substr($RecupVainq['NUM_CANDIDAT'],3,8); } else {echo $RecupVainq['NUM_CANDIDAT'];} ?></p>

<p> &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; Ne le: <?php echo substr(date_fr($RecupVainq['DATE_CANDIDAT']),0,5); ?></p>

<p> &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; <strong>Son Lot: </strong> <?php echo $RecupPrix['LIBELLE_PRIX']; ?> </p>

<div class="add">
<img align="center" style="margin-left:10%; margin-bottom:50px;" src="<?php echo 'photo/'.$RecupPrix['PHOTO_PRIX']; ?>" height="120" >
</div>

</div>


<div class="historyten">

<div class="historyheading">HISTORIQUE DES VAINQUEURS</div>
<marquee DIRECTION="up" BEHAVIOR="alternate" SCROLLAMOUNT="03" height="370" onmouseover="this.stop();" onmouseout="this.start();">
<?php  //Recuperer les vainqueurs

connectbd();
    $SelectVainqueur = 'SELECT * FROM vainqueur';
    $ExecutVainqueur = mysql_query($SelectVainqueur) ;

    ?>
<?php while ($RecupVainqueur = mysql_fetch_assoc($ExecutVainqueur)) { 
$SelectDetails = 'SELECT * FROM candidat WHERE ID_CANDIDAT="'.$RecupVainqueur['ID_CANDIDAT'].'"';
    $ExecutDetails = mysql_query($SelectDetails);
    $RecupDetails = mysql_fetch_array($ExecutDetails);//Recuperer les informations du vainqueur
  
  $SelectPrixH = 'SELECT LIBELLE_PRIX FROM prix WHERE ID_PRIX="'.$RecupListeH['ID_PRIX'].'"';
    $ExecutPrixH = mysql_query($SelectPrixH);
  $RecupPrixH = mysql_fetch_array($ExecutPrixH );//Recuperer le prix du vainqueur
  
  // $dateFr = date_fr($dateEng);
  ?>
<li>
<div class="user"><img src="<?php echo 'photo/'.$RecupDetails['PHOTO']; ?>"></div><div class="usertext"><strong><?php echo $RecupDetails['NOM_CANDIDAT']." ".$RecupDetails['PREN_CANDIDAT'];?></strong><br> Numero <?php if (strlen($RecupDetails['NUM_CANDIDAT']) == 11) { echo substr($RecupDetails['NUM_CANDIDAT'],3,8); } else {echo $RecupDetails['NUM_CANDIDAT'];} ?> <br> <?php echo date_fr($RecupVainqueur['DATE_VAINQ']); ?></div><div class="clear"></div>
</li>
<?php } ?>
      
</marquee>
</div>







<div class="hisposter"><h1>FAITES VOTER VOS AMIS</h1></div>


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
                //duration: 3000,
                pauseOnHover: 0,
    alwaysShowScrollbar: 2
    
            });
   
   
            var nt_example1 = $('#nt-example1').newsTicker({
                row_height: 74,
                max_rows: 5,
                duration: 2000,
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
