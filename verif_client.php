<?php
session_start();
var_dump($_SESSION);
echo "<br/><br/><br/><br/><br/>";

var_dump($_POST);
echo "<br/><br/><br/><br/><br/>";

if((isset($_POST['key']))
&& (isset($_POST['verif_code']) and ($_POST['verif_code'] == $_SESSION['captcha']))
&& (isset($_POST['csrf']) and ($_POST['csrf'] == $_SESSION['csrf']))){
    echo "<h1 style=\"color:green;\">ok, ouf..</h1>";
}else {
    echo "<h1 style=\"color:red;\">pas ok punaise !!</h1>";
}
?>