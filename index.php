
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

<?php
error_reporting(0);
$menunavactv="Accueil";
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
 <?php setlocale(LC_TIME,'fr_FR','fra'); 
  
date_default_timezone_set('Africa/Abidjan');?>

        <meta http-equiv="Refresh" content="300">
<title>Home</title>
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

$(document).ready(
        function (){
          
  document.getElementById("blink1").style.color="#FFF"
  setTimeout("setblinkFont()",500)
        });
        
        
function blinkFont()
{
  document.getElementById("blink1").style.color="#FFF"
  setTimeout("setblinkFont()",500)
}

function setblinkFont()
{
  document.getElementById("blink1").style.color="#97feff"
  setTimeout("blinkFont()",500)
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
        <!--Banner-->
   <script language="javascript" type='text/javascript'>
    
function horloge()
{
    var tt = new Date().toLocaleTimeString(); // hh:mm:ss
 
    document.getElementById("timer").innerHTML = tt;
    setTimeout(horloge, 1000); // mise à jour du contenu "timer" toutes les secondes
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


<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>


<div class="mainwidth">

<?php include("include/header.php"); ?>



<?php include("include/menu.php"); ?>



<?php include("include/banner.php"); ?>




<div class="midiconmain">
<div class="midicon"><a href="insc_desc.php">
<p>s'inscrire</p>
<img src="images/midicon1.png">
<div class="clickbtn">Click</div>
</a>
</div>


<div class="midicon"><a href="rajouter.php">
<p>ajouter vos amis</p>
<img src="images/midicon2.png">
<div class="clickbtn">Click</div>
</a>
</div>


<div class="midicon" id="last"><a href="votre.php">
<p>votre classement</p>
<img src="images/midicon3.png">
<div class="clickbtn">Click</div>
</a>
</div>

</div>
<div class="clear"></div>

<div class="midtag"><strong>Ci-dessous les candidats en compétition aujourd'hui,<br> <img src="images/cartoon1.png">Votez massivement pour remporter le super lot<img src="images/cartoon2.png"></strong></div>


<div class="midimgtagmain">




<script type="text/javascript" language="javascript">
var sliderwidthuser="1400px"
var sliderheightuser="104px"
var slidespeeduser=1
//slidebgcolor=null
var leftrightslideuser=new Array();
var finalslideuser=''
 
<?php 
  mysql_select_db($database_ConnexionBD,$ConnexionBD);
 $SelectCandJr = 'SELECT * FROM candidat_jour ORDER BY NBSMS DESC LIMIT 15';
$ExecutCandJr = mysql_query($SelectCandJr,$ConnexionBD);
 // Selectionner les candidats du jour
  $i = 0;
  //while ($RecupCandJr = mysql_fetch_array($ExecutCandJr)) {
  ?>

  
<?php for($i=0;$i<=20;$i++){?>
         leftrightslideuser[<?php echo $i; ?>]=' <?php while ($RecupCandJr = mysql_fetch_array($ExecutCandJr)) { $i = $i +1;
  ?><div class="midimgtag"><img src='<?php echo "photo/".$RecupCandJr['PHOTO']; ?>' width=54 height=52><p><?php echo $RecupCandJr['NOM_CANDIDAT']." ".substr($RecupCandJr['NUMERO'],3,8); ?><br><span>RANG: <?php echo $i ; ?>e</span></p></div> <?php } ?>'
     
      <?php } ?>

var imagegapuser=" "
var slideshowgapuser=2
var copyspeeduser=slidespeeduser
leftrightslideuser='<nobruser>'+leftrightslideuser.join(imagegapuser)+'</nobruser>'
var iedomuser=document.all||document.getElementById
if (iedomuser)
document.write('<span id="tempuser" style="visibility:hidden;position:absolute;top:-100px;left:-9000px">'+leftrightslideuser+'</span>')
var actualwidthuser=''
var cross_slideuser, ns_slideuser





function slideleftuser(){
if (iedomuser){
if (parseInt(cross_slideuser.style.left)>(actualwidthuser*(-1)+10))
cross_slideuser.style.left=parseInt(cross_slideuser.style.left)-copyspeeduser+"px"
else
cross_slideuser.style.left=parseInt(cross_slideuser2.style.left)+actualwidthuser+slideshowgapuser+"px"

if (parseInt(cross_slideuser2.style.left)>(actualwidthuser*(-1)+10))
cross_slideuser2.style.left=parseInt(cross_slideuser2.style.left)-copyspeeduser+"px"
else
cross_slideuser2.style.left=parseInt(cross_slideuser.style.left)+actualwidthuser+slideshowgapuser+"px"

}
else if (document.layers){
if (ns_slideuser.left>(actualwidthuser*(-1)+10))
ns_slideuser.left-=copyspeeduser
else
ns_slideuser.left=ns_slideuser2.left+actualwidthuser+slideshowgapuser

if (ns_slideuser2.left>(actualwidthuser*(-1)+10))
ns_slideuser2.left-=copyspeeduser
else
ns_slideuser2.left=ns_slideuser.left+actualwidthuser+slideshowgapuser
}
}


if (iedomuser||document.layers){
with (document){
document.write('<table border="0" cellspacing="0" cellpadding="0"><td>')
if (iedomuser){
write('<div style="position:relative;width:'+sliderwidthuser+';height:'+sliderheightuser+';overflow:hidden">')
write('<div style="position:absolute;width:'+sliderwidthuser+';height:'+sliderheightuser+';background-color:'+slidebgcolor+'" onMouseover="copyspeeduser=0" onMouseout="copyspeeduser=slidespeeduser">')
write('<div id="test2user" style="position:absolute;left:0px;top:0px"></div>')
write('<div id="test3user" style="position:absolute;left:-1000px;top:0px"></div>')
write('</div></div>')
}
else if (document.layers){
write('<ilayer width='+sliderwidthuser+' height='+sliderheightuser+' name="ns_slideusermenu" bgColor='+slidebgcolor+'>')
write('<layer name="ns_slideusermenu2user" left=0 top=0 onMouseover="copyspeeduser=0" onMouseout="copyspeeduser=slidespeeduser"></layer>')
write('<layer name="ns_slideusermenu3user" left=0 top=0 onMouseover="copyspeeduser=0" onMouseout="copyspeeduser=slidespeeduser"></layer>')
write('</ilayer>')
}
document.write('</td></table>')
}
}
</script>


<div class="clear"></div>
</div>


<div class="midimgtagmain">




<script type="text/javascript" language="javascript">
var sliderwidththum="1400px"
var sliderheightthum="104px"
var slidespeedthum=2
//slidebgcolor=null
var leftrightslidethum=new Array();
var finalslidethum=''
 <?php  $ExecutCandJr2 = mysql_query($SelectCandJr,$ConnexionBD);   $i = 0;?>


<?php for($i=0;$i<=20;$i++){?>
         leftrightslidethum[<?php echo $i; ?>]='<?php while ($RecupCandJr2 = mysql_fetch_array($ExecutCandJr2)) {$i = $i +1;
  ?><div class="midimgtag"><img src='<?php echo "photo/".$RecupCandJr2['PHOTO']; ?>' width=54 height=52><p><?php echo $RecupCandJr2['NOM_CANDIDAT']." ".substr($RecupCandJr2['NUMERO'],3,8); ?><br><span>RANG: <?php echo /*$RecupCandJr2['ID']*/$i; ?>e</span></p></div><?php } ?>'
      <?php } ?>

var imagegapthum=" "
var slideshowgapthum=2
var copyspeedthum=slidespeedthum
leftrightslidethum='<nobrthum>'+leftrightslidethum.join(imagegapthum)+'</nobrthum>'
var iedomthum=document.all||document.getElementById
if (iedomthum)
document.write('<span id="tempthum" style="visibility:hidden;position:absolute;top:-100px;left:-9000px">'+leftrightslidethum+'</span>')
var actualwidththum=''
var cross_slidethum, ns_slidethum



function slideleftthum(){
if (iedomthum){
if (parseInt(cross_slidethum.style.left)>(actualwidththum*(-1)+10))
cross_slidethum.style.left=parseInt(cross_slidethum.style.left)-copyspeedthum+"px"
else
cross_slidethum.style.left=parseInt(cross_slidethum2.style.left)+actualwidththum+slideshowgapthum+"px"

if (parseInt(cross_slidethum2.style.left)>(actualwidththum*(-1)+10))
cross_slidethum2.style.left=parseInt(cross_slidethum2.style.left)-copyspeedthum+"px"
else
cross_slidethum2.style.left=parseInt(cross_slidethum.style.left)+actualwidththum+slideshowgapthum+"px"

}
else if (document.layers){
if (ns_slidethum.left>(actualwidththum*(-1)+10))
ns_slidethum.left-=copyspeedthum
else
ns_slidethum.left=ns_slidethum2.left+actualwidththum+slideshowgapthum

if (ns_slidethum2.left>(actualwidththum*(-1)+10))
ns_slidethum2.left-=copyspeedthum
else
ns_slidethum2.left=ns_slidethum.left+actualwidththum+slideshowgapthum
}
}


if (iedomthum||document.layers){
with (document){
document.write('<table border="0" cellspacing="0" cellpadding="0"><td>')
if (iedomthum){
write('<div style="position:relative;width:'+sliderwidththum+';height:'+sliderheightthum+';overflow:hidden">')
write('<div style="position:absolute;width:'+sliderwidththum+';height:'+sliderheightthum+';background-color:'+slidebgcolor+'" onMouseover="copyspeedthum=0" onMouseout="copyspeedthum=slidespeedthum">')
write('<div id="test2thum" style="position:absolute;left:0px;top:0px"></div>')
write('<div id="test3thum" style="position:absolute;left:-1000px;top:0px"></div>')
write('</div></div>')
}
else if (document.layers){
write('<ilayer width='+sliderwidththum+' height='+sliderheightthum+' name="ns_slidethummenu" bgColor='+slidebgcolor+'>')
write('<layer name="ns_slidethummenu2" left=0 top=0 onMouseover="copyspeedthum=0" onMouseout="copyspeedthum=slidespeedthum"></layer>')
write('<layer name="ns_slidethummenu3" left=0 top=0 onMouseover="copyspeedthum=0" onMouseout="copyspeedthum=slidespeedthum"></layer>')
write('</ilayer>')
}
document.write('</td></table>')
}
}
</script>


<div class="clear"></div>
</div>






<div class="midaddmain">

<div class="midad">
<!--<div class="midaddheading"></div>-->


<iframe width="100%" height="250" src="https://www.youtube.com/embed/3hiYl2W4AqI" frameborder="0" allowfullscreen></iframe>


</div>
<?php 
//$IDWinner = mysql_insert_id();
$WinnerSQL = 'SELECT Max(ID_VAINQ) As Vainq,DATE_VAINQ,ID_PRIX FROM vainqueur';
$ExecutWinnerSQL = mysql_query($WinnerSQL, $ConnexionBD);
$RecupWinner = mysql_fetch_array($ExecutWinnerSQL); // recuperer le dernier gagnant de la liste des vainqueurs

if ( $RecupWinner['Vainq'] != NULL )
{
  $SelectVainqInfo = 'SELECT * FROM vainqueur WHERE ID_VAINQ="'.$RecupWinner['Vainq'].'"';
    $ExecutVainqInfo = mysql_query($SelectVainqInfo , $ConnexionBD);
  $RecupVainqInfo = mysql_fetch_array($ExecutVainqInfo); //Recuperer les id du vainqueur
  
    $SelectPrix = 'SELECT LIBELLE_PRIX,PHOTO_PRIX,DETAIL_PRIX FROM prix WHERE ID_PRIX="'.$RecupVainqInfo ['ID_PRIX'].'"';
    $ExecutPrix = mysql_query($SelectPrix , $ConnexionBD);
  $RecupPrix = mysql_fetch_array($ExecutPrix );//Recuperer le prix du vainqueur

    $SelectVainq = 'SELECT * FROM candidat WHERE ID_CANDIDAT="'.$RecupVainqInfo['ID_CANDIDAT'].'"';
    $ExecutVainq = mysql_query($SelectVainq , $ConnexionBD);
    $RecupVainq = mysql_fetch_array($ExecutVainq);//Recuperer les informations du vainqueur

$dateEng = $RecupVainqInfo['DATE_VAINQ'];;
}
function date_fr($date_saisie){
 
        //division de la date par rapport au / ou -
        @list ($jour , $mois , $an) = split("[-./]",$date_saisie);
        //inverse la date
        return($an."-".$mois."-".$jour);
 
}    // Mettre la date en format francais
 
   $dateFr = date_fr($dateEng);
?>
<div class="midadd">
<div class="midaddheading"><a href="history.php">VAINQUEUR DU:</a> <?php if ($RecupWinner['Vainq'] != NULL )
    { echo $dateFr;} ?></div>
<img src="<?php echo 'photo/'.$RecupVainq['PHOTO']; ?>" >
<h1><?php echo $RecupVainq['NOM_CANDIDAT']." ".$RecupVainq['PREN_CANDIDAT']; ?></h1>
<p> Numero: <?php if (strlen($RecupVainq['NUM_CANDIDAT']) == 11) { echo substr($RecupVainq['NUM_CANDIDAT'],3,8); } else {echo $RecupVainq['NUM_CANDIDAT'];} ?>  &nbsp; Ne le: <?php echo substr(date_fr($RecupVainq['DATE_CANDIDAT']),0,5); ?></p>

<p><strong>Son Lot: </strong> <?php echo $RecupPrix['LIBELLE_PRIX']; ?> </p>

<div class="add">
<img src="<?php echo 'photo/'.$RecupPrix['PHOTO_PRIX']; ?> " height="120" width="50%" />
</div>

</div>


<div class="topten">
<div class="midaddheading">Top 10 en tete</div>

<marquee DIRECTION="up" BEHAVIOR="alternate" SCROLLAMOUNT="03" height="370" onmouseover="this.stop();" onmouseout="this.start();">
 
<li >
<?php 
 $SelectSQL = 'SELECT * FROM candidat_jour ORDER BY NBSMS DESC LIMIT 10';
 $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
 $i = 0;
?>

<?php while ($Recup2 = mysql_fetch_assoc($ExecutSQL)) {  $i = $i + 1;?>
<div class="user">

  <img src="<?php echo 'photo/'.$Recup2['PHOTO']; ?>"></div><div class="usertext"><strong><?php echo $Recup2['NOM_CANDIDAT']." ".$Recup2['PREN_CANDIDAT'];?></strong><br> Numero: <?php if (strlen($Recup2['NUMERO']) == 11) { echo substr($Recup2['NUMERO'],3,8); } else {echo $Recup2['NUMERO'];} ?> <br><span>  RANG: <?php echo /*$Recup2['ID']*/$i; ?>e</span><br><?php date_default_timezone_set('UTC');
   echo date("d-M-Y"); ?></div><div class="clear"></div>
<?php } ?>
</li>

</marquee>

</div>
      
      

</li>

</ul>
</div>
<?php  //Recuperer le Lot du jour
    $SelectLot = 'SELECT * FROM prix WHERE DATE_PRIX="'.date("Y-m-d").'"';
    $ExecutLot = mysql_query($SelectLot , $ConnexionBD);
    $RecupLot = mysql_fetch_array($ExecutLot);
  

    ?>

<div class="topten" id="last">
<div class="midaddheading"><a href="history.php"> Lot en jeu aujourd'hui</a></div>
<ul id="nt-titlee" class="nt-title">
 <p><strong>NOUVELLE GAMME : <?php echo $RecupLot['LIBELLE_PRIX']; ?></strong> </p>
  <p> </p>

 
 <p><img src="<?php echo 'photo/'.$RecupLot['PHOTO_PRIX']; ?>" height="250" width="100%" /></p>

</ul>

</div>







<div class="clear"></div>
</div>



<div class="welcomemaintab">
<div class="welcomemtab">
<div class="welcomemvideo">
<h1>Welcome</h1>
<iframe width="100%" height="250" src="https://www.youtube.com/embed/3hiYl2W4AqI" frameborder="0" allowfullscreen></iframe></div>


<div class="facebooktab"><h1>Facebook</h1>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like-box" style="background:#FFF;" data-href="https://www.facebook.com/monincroyableanniversaire" data-width="280"  data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="true" data-show-border="true"></div>

</div>

<div class="clear"></div>
</div>

<div class="latestnewstab">
<h1>News</h1>
<p><strong>LANCEMENT LE 17 FEVRIER 2017 </strong></p>

<!---<span>Depuis le 01 Octobre 2015</span><br> 
La remise des lots DES GAGNANTS DE CHAQUE DEUX SEMAINES se fait les samedi en 15 a 15H a l'hotel EDA OBA DE LOME<br>
-->

<div class="morebtn"><a href="#"><strong> </strong></a></div>
<div class="clear"></div>
</div>


<div class="clear"></div>
</div>


<div class="socialiconmain">
<div class="tellogo"><img src="images/telco.png"></div>
<div class="mediaicon">
<a href="https://www.facebook.com/monincroyableanniversaire" target="_blank"><img src="images/facebook.png"></a>
<a href="https://www.twitter.com/telcoanniv/" target="_blank"><img src="images/twitter.png"></a>
<a href="https://www.instagram.com/telcoanniv/" target="_blank"><img src="images/instagram-logo.png"></a>
<a href="https://www.youtube.com/channel/UC3MgQ1nZ3bhCqpEifmMk7Mw" target="_blank"><img src="images/youtube.png"></a>
</div>

<div class="clear"></div>
</div>




<?php include("include/footer.php"); ?>



</div>



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


</body>
</html>
