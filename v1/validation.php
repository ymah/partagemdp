<?php
//session_save_path('file/temp');
//session_start();




$code = htmlspecialchars($_POST['code'], ENT_COMPAT,'ISO-8859-1', true);
$aes = htmlspecialchars($_POST['aes'], ENT_COMPAT,'ISO-8859-1', true);
$rsa = htmlspecialchars($_POST['rsa'], ENT_COMPAT,'ISO-8859-1', true);
$_SESSION['aes'] = $aes;
$_SESSION['rsa'] = $rsa;
if($_SESSION['aleat_nbr']== $code 
and !empty($aes) and !empty($rsa)){

include('traitement.php');    
}else{
     header('Location: '.$_SESSION['url'].'&codeError=1');
}
?>


