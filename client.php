<?php 
$get = htmlspecialchars($_GET['id'], ENT_COMPAT,'ISO-8859-1', true);
$now = time();
$_SESSION['temp'] = $get;
if(($now - $get) <= 1000){
?>
<form action="index.php" method="post">
  <p>
    <label>
      clé privée fournie par email
    </label>
    <input name="key" type="text"/>
  </p>
  <p>
    <img src="verif_code_gen.php" alt="Code de vérification" />
  </p>
  <p>
    <label>
      Merci de retaper le code de l'image ci-dessus
    </label>
    : 
    <input type="text" name="verif_code" />
  </p>
  <p>
    <input hidden name="csrf" value=
<?php include('csrf.php');?>
    />
  </p>
  <p>
    <input type="submit" value="recuperer le mot de passe" />
  </p>
</form>
<?php
}else{
    unlike("key/$get.dat");
    echo "le temps est impartie, identifiants et mot de passe supprimé";

}



?>