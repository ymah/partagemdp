<?php

include('Crypt/RSA.php');


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
    extract($rsa->createKey(2048));
    $rsa->loadKey($publickey);
    
    $resID = base64_encode($rsa->encrypt($id));
    $resMDP = base64_encode($rsa->encrypt($mdp));
    
    
    $lien = curPageURL()."?code=$nbr&time=".time()."";
    $pk = generateRandomString(8);


    $resID = base64_encode($rsa->encrypt($id));
    $resMDP = base64_encode($rsa->encrypt($mdp));
    
    if(!file_put_contents("file/key/".$pk.$nbr.".crt","$resID;$resMDP")){//on enregistre le resultat dans le fichier de sortie;
        echo ('Exception reçue : erreur ecriture dans le fichier<br/>');
}
?>
<div class="row">
<div class="large-12 columns">
<?php
echo "
<p style=\"color:black\">Partagez ces informations avec le client concerné, de maniere preferable, envoyer la clé AES via un autre canal.</p> 
<table style=\"table-layout:auto;\">
<thead>
<th>
Fiche à envoyer
</th>

</thead>
<tbody>
<tr>
<tr>
<td>Clé RSA à communiquer au client par email</td>
<td>$privatekey</td>
</tr>
<td>Code unique à communiquer via un autre canal (SMS ou telephone)</td>
<td>$pk<br/><br/></td>
</tr>
<tr>
<tr>
<td>Lien</td>
<td>$lien</td>
</tr>
</tbody>
</table>
";
?>
</div>
</div>
<?php
}else {


?>
    
<p style="color:black">Veuillez noter ici l'identifiant et le mot de passe que vous desirez partager.</p>
<form action="index.php" method="GET">
    <p><label>Identifiant: </label><input name="id" type="text"/></p>

    <p><label>Mot de passe: </label><input name="mdp" type="text"/></p>
    <p><input class="button" type="submit" value="valider"/>
    </form>
<?php } ?>
