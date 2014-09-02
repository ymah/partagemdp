<?php 
//session_save_path('file/temp');
//session_start();
include('Crypt/RSA.php');
include('Crypt/AES.php');


if(empty($_SESSION['id'])){

    header('Location: index.php');

}

$id = $_SESSION['id'];
$line = file('file/key/'.$id.'.crt');


$tab = explode(";",$line[0]);

$rsa = new Crypt_RSA();
$aes = new Crypt_AES();

$aes->setKey($_SESSION['aes']);
$key = $aes->decrypt(base64_decode($tab[2]));

$rsa->setPrivateKey($key);
$ident = $rsa->decrypt(base64_decode($tab[0]));
$mdp = $rsa->decrypt(base64_decode($tab[1]));
echo "
<div class=\"row\">
<div class=\"panel\">
<h5>Vos identifiants</h5>
<br/>
<div class=\"panel callout radius\">
<p>Identifiant : $ident</p>
<p>Mot de passe : $mdp</p>
</div>
</div>
";

