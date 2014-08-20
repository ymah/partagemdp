<?php
include('Crypt/RSA.php');
$dir = 'key';

if ( !file_exists($dir) ) {
    mkdir ($dir, 0770);
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
    $time=time();
    $id = htmlspecialchars($_POST['id'], ENT_COMPAT,'ISO-8859-1', true);
    $mdp = htmlspecialchars($_POST['mdp'], ENT_COMPAT,'ISO-8859-1', true);


    $rsa = new Crypt_RSA();
    extract($rsa->createKey(1024));
    $rsa->loadKey($publickey);
    
    $resID = $rsa->encrypt($id);
    $resMDP = $rsa->encrypt($mdp);
    
    if(!file_put_contents("key/$time.crt","$resID;$resMDP;$publickey"))//on enregistre le resultat dans le fichier de sortie
        echo 'Exception reçue : erreur ecriture dans le fichier<br/>';

    $lien = curPageURL()."?id=$time";
    

    echo "<table>
<tr>
<td>Identifiant</td>
<td>$id</td>
</tr>
<tr>
<td>Clé privée de decryptage</td>
<td>$privatekey<br/><br/></td>
</tr>
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