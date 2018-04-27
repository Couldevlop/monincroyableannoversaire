<?php
error_reporting(0);
$deshboard="Liste d'amis";
?>
<?php require_once('Connections/ConnexionProfil.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
/*************Suppression champs vides********/
function connectbd(){
    $base = mysql_connect ('localhost','telco','telcosarl2013');
    mysql_select_db ('telco_anniv_ci',$base);
}
/*function connectbd2(){
    $base = mysql_connect ('localhost','root','telcosarl2013');
    mysql_select_db ('gamebd_togo',$base);
}*/

 connectbd();
			$SearchSQL = 'SELECT * FROM amis WHERE PSEUDO_AMIS="" AND NUM_AMIS=""';
       		$ExecutSearch = mysql_query($SearchSQL)or die(mysql_error());
			$GetSearch = mysql_fetch_array($ExecutSearch);
			if ($GetSearch['ID_AMIS'] != NULL)
			{
				//echo " Ya des espace vide ";
				$DeleteSQL = 'DELETE FROM amis WHERE ID_AMIS="'.$GetSearch['ID_AMIS'].'"';
				$ExecutDelete = mysql_query($DeleteSQL)or die(mysql_error());
				//echo "Supression Ok";
			}	
			$SearchSQL2 = 'SELECT * FROM amis WHERE PSEUDO_AMIS=NUM_AMIS';// a modifier si le numero n es pa numerik delete
       		$ExecutSearch2 = mysql_query($SearchSQL2)or die(mysql_error());
			$GetSearch2 = mysql_fetch_array($ExecutSearch2);
			if ($GetSearch2['ID_AMIS'] != NULL)
			{
				//echo " Ya une ligne non valide ";
				$DeleteSQL2 = 'DELETE FROM amis WHERE ID_AMIS="'.$GetSearch2['ID_AMIS'].'"';
				$ExecutDelete2 = mysql_query($DeleteSQL2)or die(mysql_error());
				//echo "Supression Ok";
			}
/*-----------------------------------------------------*/

if (!(isset($_SESSION['MM_Username'])))
{
	 $GoTo = "index.php";
 
    header("Location: $GoTo");
}
$ID = $_SESSION['ID'];

	   $SelectSQL = 'SELECT * FROM candidat WHERE ID_CANDIDAT="'.$ID.'"';
	   $ExecutSQL = mysql_query($SelectSQL, $ConnexionBD);
	   $Recup = mysql_fetch_assoc($ExecutSQL);
	   //-------------------------
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_ConnexionBD, $ConnexionBD);
$query_Recordset1 = "SELECT * FROM amis WHERE ID_CANDIDAT='".$ID."' ORDER BY PSEUDO_AMIS ASC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $ConnexionBD) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);


	

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
  
	   //-------------------------
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
<title>Liste</title>
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
  
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>

<div class="mainwidth">

<?php include("include/header.php"); ?>


<?php include("include/menu.php"); ?>



<?php include("include/marqu.php"); ?>



<div class="monprofilemain">
<div class="afterlogin">
<div class="listemain">
<h1><img src="images/4.png">Liste de vos amis<img src="images/3.png"></h1>

<?php  if ( $row_Recordset1['ID_AMIS'] == NULL ) { ?>
        <p align="center" style="font-size:18px; font-weight:bold; color:#00F"> Votre liste d'amis est vide </p>
        <?php }  else {?>
	
 <?php   if (isset($_SESSION['existPseudo']))
	{
	echo ' <div align="left" style="font-size:18px"><font color="red">Ce pseudo ou ce numero existe deja. Veuillez utiliser un autre.</font></div>';
	unset($_SESSION['existPseudo']);
	}
	echo "<br />";
	?>
 <form  action="listedamis.php" >
<div class="listtag">
<div class="listheading">
<div class="listtext"><strong>Noms</strong></div>
<div class="listtext"><strong>Numeros</strong></div>
<div class="listtext"><strong>Selectionner</strong></div>

<div class="clear"></div>
<input type="hidden" name="envoi" value="yes">
  <?php do { ?>
<div class="listcontect"><?php echo $row_Recordset1['PSEUDO_AMIS']; ?></div>
<div class="listcontect"><?php if ( strlen($row_Recordset1['NUM_AMIS']) == 11 ) { echo substr($row_Recordset1['NUM_AMIS'],3,8);} else { echo $row_Recordset1['NUM_AMIS']; } ?></div>
<div class="listcontect"><input type="checkbox" name="options[]" value="<?php echo $row_Recordset1['ID_AMIS']; ?>"></div>
<div class="clear"></div>
 <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
 <?php 
	if (isset($_GET['envoi']) && isset($_GET['options']))
	{
	   $envoi = $_GET['envoi'];   
	   $options = $_GET['options']; 
	   if ($envoi == 'yes') {
	     for ($k=0 ; $k < count($options) ; $k++)
           {
            connectbd();
      $deleteSQL  = 'DELETE FROM amis WHERE ID_AMIS="'.$options[$k].'"';
         mysql_query($deleteSQL )or die(mysql_error());

     // $GetSearch = mysql_fetch_array($ExecutSearch);
           /* mysql_select_db($database_ConnexionBD, $ConnexionBD);
            $SearchSQL = 'SELECT * FROM amis WHERE ID_AMIS="'.$options[$k].'"';
          $ExecutSearch = mysql_query($SearchSQL, $ConnexionBD) or die(mysql_error());
      $GetSearch = mysql_fetch_assoc($ExecutSearch);*/
      //echo  $GetSearch['ID_AMIS']." ";
	          /* $deleteSQL = 'DELETE FROM amis WHERE ID_AMIS="'.$options[$k].'"';
	           mysql_select_db($database_ConnexionBD, $ConnexionBD);
  		       mysql_query($deleteSQL, $ConnexionBD) or die(mysql_error());*/
             //connectbd2();

  

	       }
       }
	}
 
	?>

</div>    
</div>
	<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><font color="#000066"  style="font-size:13px; font:Tahoma, Geneva, sans-serif; font-weight:bold">Premier</font></a>
        <?php } // Show if not first page ?></td>
         <td> <p align="left">&nbsp;</p> </td>
    <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><font color="#000066"  style="font-size:13px; font:Tahoma, Geneva, sans-serif; font-weight:bold">Precedent</font></a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><font color="#000066"  style="font-size:13px; font:Tahoma, Geneva, sans-serif; font-weight:bold">Suivant</font></a>
        <?php } // Show if not last page ?></td>
      
    <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><font color="#000066"  style="font-size:13px; font:Tahoma, Geneva, sans-serif; font-weight:bold">Dernier</font></a>
        <?php } // Show if not last page ?></td>
        
  </tr>
</table>
<?php echo ($startRow_Recordset1 + 1) ?> a <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> sur <?php echo $totalRows_Recordset1 ?>
   	
<input class="changesubbtn" type="submit" value="Supprimer" onclick="return window.confirm('Voulez vous suprimer cet(ces) ami(s)? ');"/>
    <?php }  ?>
	</form>		
</div>



<!--<div class="myprofilemain" id="last">
<div class="myprofile" id="last">
<strong>Ajouter une liste d'amis</strong>
</div>
 <div class="clear"></div>
 
<div class="myprofile" id="last">
<strong>Charger fichier de contacts:</strong>
</div>
<div class="myprofile">
<input type="text" id="name" name="name"  value="<?php echo $Login; ?>" class="myprofileform" />
</div>
<input type="submit" id="submit" onClick="return contactvalitation();"  name="contactsubmit" value="Envoyer" class="changesubbtn" />
</div>-->

</div>
<a href="#" title="Pour modifier un ami, vous n'avez qu'a le supprimer et le recreer."><img src="images/questionmark.png"></a>

<?php include("include/deshboard.php"); ?>

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
