

<div class="deshboardmain">
<div class="deshboard">
<ul>
<li><a href="afterlogin.php" <?php if($deshboard=="Mon profile") echo "id='deshboardactiv'"; ?>>Mon profile</a></li>
<li><a href="modifyprofile.php?IDCANDIDAT=<?php echo base64_encode($Recup['ID_CANDIDAT']); ?>" <?php if($deshboard=="Modifier mon profile") echo "id='deshboardactiv'"; ?>>Modifier mon profile</a></li>
<li><a href="ajouter.php" <?php if($deshboard=="Ajouter ami(s)") echo "id='deshboardactiv'"; ?>>Ajouter ami(s)</a></li>
<li><a href="listedamis.php" <?php if($deshboard=="Liste d'amis") echo "id='deshboardactiv'"; ?>>Liste d'amis</a></li>
<!--<li><a href="#">Numeros inconnus</a></li>-->
</ul>
</div>
</div>
