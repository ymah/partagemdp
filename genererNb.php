<?php
$i = 0;
while($i < $nbr_chiffres) {
    $chiffre = mt_rand(0, 9); // On génère le nombre aléatoire
    $chiffres[$i] = $chiffre;
    $i++;
}

$nombre = null;
// On explore le tableau $chiffres afin d'y afficher toutes les entrées qui s'y trouvent
foreach ($chiffres as $caractere) {
    $nombre .= $caractere;
}


##### On a fini de créer le nombre aléatoire, on le rentre maintenant dans une variable de session #####
$_SESSION['captcha'] = $nombre;

?>