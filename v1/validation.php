<?php
session_save_path('temp');
session_start();
var_dump($_SESSION['captcha']['code']);
var_dump($_POST['code']);



?>