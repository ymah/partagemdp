<?php
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
    $nom=time();
    if(!file_put_contents("key/$nom.dat",$_POST['id']."|".$_POST['mdp']))//on enregistre le resultat dans le fichier de sortie
        echo 'Exception reçue : erreur ecriture dans le fichier<br/>';

    $lien = curPageURL()."index.php?id=$nom";
    echo $lien;

}else {


?>
    <form action="" method="POST">
    <p><label>Identifiant: </label><input name="id" type="text"/></p>

    <p><label>Mot de passe: </label><input name="mdp" type="text"/></p>
    <p><input type="submit" value="valider"/>
    </form>







<?php } ?>