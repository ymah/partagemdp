<?php
$_SESSION['index']++;
session_save_path('temp');
session_start();
$_SESSION['index']++;

var_dump($_SESSION);
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
$_SESSION['index']++;
print_r($_SESSION['captcha']['code']);
echo "<br/>";
$_SESSION['index']++;
print_r($_POST['code']);
print_r("<br/>".$_SESSION['index']);
?>


</body>
</html>
