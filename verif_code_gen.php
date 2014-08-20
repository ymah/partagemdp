<?php

// Là, on définit le header de la page pour la transformer en image
header ("Content-type: image/jpeg");
// Là, on crée notre image
$_img = imagecreatefromjpeg('noir.jpg');

// On définit maintenant les couleurs
// Couleur de fond :
$arriere_plan = imagecolorallocate($_img, 0, 0, 0); // Au cas où on n'utiliserait pas d'image de fond, on utilise cette couleur-là.
// Autres couleurs :

$r = mt_rand(120,255);
$v = mt_rand(120,255);
$b = mt_rand(120,255);
$avant_plan = imagecolorallocate($_img, $r, $v, $b); // Couleur des chiffres

$nbr_chiffres = 12;
$i = 0;
while($i < $nbr_chiffres) {
    $chiffre = mt_rand(0,9); // On génère le nombre aléatoire
    $chiffres[$i] = $chiffre;
    $i++;
}

$nombre = null;

foreach ($chiffres as $caractere) {
    $nombre .= $caractere;
}
##### On a fini de créer le nombre aléatoire, on le rentre maintenant dans une variable de session #####

// On détruit les variables inutiles :

$x = mt_rand(1,35);
$y = mt_rand(1,35);

imagestring($_img, 15, $x, $y , $nombre, $avant_plan);
unset($chiffre);
unset($i);
unset($caractere);
unset($chiffres);
unset($r);
unset($v);unset($b);
unset($x);unset($y);

imagejpeg($_img);
$_SESSION['captcha'] = $nombre;

?>