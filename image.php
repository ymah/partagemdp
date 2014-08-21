<?php
//header ("Content-type: image/png");
session_start();
include('verif_code_gen.php');
imagepng($_SESSION['img']);
unset($_SESSION['captcha']);

?>