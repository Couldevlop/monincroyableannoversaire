<?php require_once('Connections/ConnexionBD.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
?>

<div class="navbar"><a href="javascript:void();" onClick="opnnav();"><i class="fa fa-bar"></i></a></div>
<nav id="nav">
<ul>
<li><a href="index.php">Accueil</a></li>
<li><a href="monprofile.php">Mon Profile</a></li>
<li><a href="description.php">Description</a></li>
<li><a href="registetion.php">Inscription</a></li>
<li><a href="history.php">Historique des Vainqueurs</a></li>
<li><a href="contact.php">Contact</a></li>

</ul>
</nav>
<div class="transprntbg" onClick="closetrns();"></div>





<div class="menu">
<div class="menunav">
<ul>
<li><a href="index.php" <?php if($menunavactv=="Accueil") echo "id='menunavactv'"; ?>>Accueil</a></li>
<li><a href="monprofile.php"  <?php if($menunavactv=="Mon Profile") echo "id='menunavactv'"; ?>>Mon Profile</a></li>
<li><a href="description.php"  <?php if($menunavactv=="Description") echo "id='menunavactv'"; ?>>Description</a></li>
<li><a href="registetion.php"  <?php if($menunavactv=="Inscription") echo "id='menunavactv'"; ?>>Inscription</a></li>
<li><a href="history.php"  <?php if($menunavactv=="Historique des Vainqueurs") echo "id='menunavactv'"; ?>>Historique des Vainqueurs</a></li>
<li><a href="contact.php"  <?php if($menunavactv=="Contact") echo "id='menunavactv'"; ?>>Contact</a></li>
</ul>

</div>
<?php if ((isset($_SESSION['MM_Username']))) { ?>
<div class="login"><a href="logout.php">Logout</a></div>
 <?php } else { ?> 
<div class="login"><a href="monprofile.php">Login</a></div>
  <?php } ?> 
</div>
<div class="clear"></div>