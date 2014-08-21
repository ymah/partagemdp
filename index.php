<?php
$pathSession = 'temp';

if ( !file_exists($pathSession) ) {
    mkdir ($pathSession, 0770);
}

session_save_path('temp/');
if(!isset($_SESSION)){
    session_start();
}?>

<!DOCTYPE html>
<html>
<meta charset="utf-8" />
    <title>Partage Mot de passe</title>
    <head>
    <title>Inscription</title>
    </head>
    <body>






<?php
    
if(isset($_GET['id'])){
    
    include('client.php');

}else if(isset($_POST['key'])){
    include('verif_client.php');
}else {
    include('create.php');
}


?>
</body>
</html>
