<?php
include('Crypt/RSA.php');
include('Crypt/AES.php');

function  generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    $l = strlen($characters);
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, $l - 1)];
    }
    return $randomString;
}

function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}






if(isset($_POST['id']) and isset($_POST['mdp'])){
    $var=generateRandomString(10);
    $id = htmlspecialchars($_POST['id'], ENT_COMPAT,'ISO-8859-1', true);
    $mdp = htmlspecialchars($_POST['mdp'], ENT_COMPAT,'ISO-8859-1', true);

    
    $rsa = new Crypt_RSA();
    extract($rsa->createKey(1500));
    $rsa->loadKey($publickey);
    
    $resID = $rsa->encrypt($id);
    $resMDP = $rsa->encrypt($mdp);
    
    if(!file_put_contents("key/$var.crt","$resID;$resMDP"))//on enregistre le resultat dans le fichier de sortie
        echo 'Exception reçue : erreur ecriture dans le fichier<br/>';
    
    $lien = curPageURL()."client.php?code=$var&temp=".time()."";
    $pk = generateRandomString(8);
    echo $pk;
    $des = new Crypt_AES();
    $des->setKey($pk);
    $cle = base64_encode($des->encrypt($privatekey));
    
    echo "<table>
<tr>
<td>Identifiant</td>
<td>$id</td>
</tr>
<tr>
<td>Clé privée de decryptage</td>
<td>$cle<br/><br/></td>
</tr>
<tr>
<td>Clé des</td>
<td>$pk<br/><br/></td>
</tr>
<tr>
<tr>

<td>Lien</td>
<td>$lien</td>
</tr>

</table>";
}else {


?>
    <form action="" method="POST">
    <p><label>Identifiant: </label><input name="id" type="text"/></p>

    <p><label>Mot de passe: </label><input name="mdp" type="text"/></p>
    <p><input type="submit" value="valider"/>
    </form>
<?php } ?>