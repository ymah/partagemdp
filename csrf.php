<?php 
session_start();

$i = 0;
while($i < 128) {
    $c = mt_rand(1, 9); // On génère le nombre aléatoire
    $cs[$i] = $c;
    $i++;
}

$csrf=null;
foreach ($cs as $caractere) {
    $csrf .= $caractere;
}
echo ($_SESSION['csrf'] = $csrf);

?>