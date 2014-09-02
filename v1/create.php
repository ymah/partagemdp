<?php

include('Crypt/RSA.php');
include('Crypt/AES.php');


////////////////////////
function  generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//$\'"&,;?@#<>(){}[]/\\';
    $randomString = '';
    $l = strlen($characters);
    $last = 0;
    for ($i = 0; $i < $length; $i++) {
        $nbr = mt_rand(0, $l - 1);
        if($nbr == $last){
            $nbr = ($nbr * mt_rand(0,5))%$l;
        }
        if(($characters[$last] == '0' and $characters[$nbr] == 'O')
        || ($characters[$last] == '1' and ($characters[$nbr] == 'l' || $characters[$nbr] == 'I'))
        || ($characters[$last] == 'O' and $characters[$nbr] == '0')
        || ($characters[$last] == 'l' and ($characters[$nbr] == '1' || $characters[$nbr] == 'I'))
        || ($characters[$last] == 'I' and ($characters[$nbr] == 'l' || $characters[$nbr] == '1'))
        || ($characters[$last] == 'w' and $characters[$nbr] == 'v')
        || ($characters[$last] == 'v' and $characters[$nbr] == 'w')
        || ($characters[$last] == 'W' and $characters[$nbr] == 'V')
        || ($characters[$last] == 'V' and $characters[$nbr] == 'W')
        || ($characters[$last] == 'v' and $characters[$nbr] == 'u')
        || ($characters[$last] == 'u' and $characters[$nbr] == 'v')
        || ($characters[$last] == 'V' and $characters[$nbr] == 'U')
        || ($characters[$last] == 'U' and $characters[$nbr] == 'V')) {

            $nbr = ($nbr+10)%l;

        
        }
        $last = $nbr;
        $randomString .= $characters[$last];
    }
    return $randomString;
}
////////////////////////

function curPageURL() {
    $ext = "/test/partagemdp/v1/index.php";

    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$ext;
    }
    return $pageURL;
}






if(isset($_GET['id']) and isset($_GET['mdp']) and isset($_SESSION['admin'])){
    $nbr=generateRandomString(15);
    $id = htmlspecialchars($_GET['id'], ENT_COMPAT,'ISO-8859-1', true);
    $mdp = htmlspecialchars($_GET['mdp'], ENT_COMPAT,'ISO-8859-1', true);

    
    $rsa = new Crypt_RSA();
    extract($rsa->createKey(1500));
    $rsa->loadKey($publickey);
    
    $resID = base64_encode($rsa->encrypt($id));
    $resMDP = base64_encode($rsa->encrypt($mdp));
    
    
    $lien = curPageURL()."?code=$nbr&time=".time()."";
    $pk = generateRandomString(8);
    $des = new Crypt_AES();
    $des->setKey($pk);
    
    $cle = base64_encode($des->encrypt($privatekey));
    if(!file_put_contents("file/key/$nbr.crt","$resID;$resMDP"))//on enregistre le resultat dans le fichier de sortie
        echo ('Exception reçue : erreur ecriture dans le fichier<br/>');
?>
<div class="row">
<div class="large-12 columns">
<?php
echo "
<table style=\"table-layout:fixed;\">
<tr>
<td>Identifiant</td>
<td>$id</td>
</tr>
<tr>
<tr>
<td>Clé RSA à communiquer au client par email</td>
<td>$cle</td>
</tr>
<td>Clé AES</td>
<td>$pk<br/><br/></td>
</tr>
<tr>
<tr>
<td>Lien</td>
<td>$lien</td>
</tr>
</table>
";
?>
</div>
</div>
<?php
}else {


?>
    <form action="index.php" method="GET">
    <p><label>Identifiant: </label><input name="id" type="text"/></p>

    <p><label>Mot de passe: </label><input name="mdp" type="text"/></p>
    <p><input class="button" type="submit" value="valider"/>
    </form>
<?php } ?>
