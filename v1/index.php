<?php
$pathSession = 'temp';

if ( !file_exists($pathSession) ) {
    mkdir ($pathSession, 0770);
}
$dir = 'key';

if ( !file_exists($dir) ) {
    mkdir ($dir, 0770);
}
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8" />
    <title>Partage Mot de passe</title>
    <head>
    <title>Inscription</title>
    </head>
    <body>






<?php
    
    if(isset($_GET['code']) and isset($_GET['temp'])){
    
        include('client.php');

    }else if(isset($_POST['key'])){
        include('verif_client.php');
    }else {
        include('create.php');
    }


?>
</body>
</html>
