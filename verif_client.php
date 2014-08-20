<?php

if((isset($_POST['key']))
&& (isset($_POST['verif_code']) and ($_POST['verif_code'] == $_SESSION['captcha']))
&& (isset($_POST['csrf']) and ($_POST['csrf'] == $_SESSION['csrf']))){
    echo "ok";
}else {
    echo "pas ok";
}
?>