<?php
session_save_path('file/temp');
session_start();
if(!$_SESSION['expire']){
    header('Location: index.php');
} 







?>

<p>La session a expiré, votre demande ne peut plus etre traitée.</p>


<?php
    unset($_SESSION['fichier']);
session_unset();

?>