<?php

function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}



$_SESSION['url']= curPageURL();
if(isset($_GET['codeError']) and $_GET['codeError']==1){
    echo '<h2 style="color:red">Erreur recommencez !</h2>';
}

$id = htmlspecialchars($_GET['code'], ENT_COMPAT,'ISO-8859-1', true);
$temp = htmlspecialchars($_GET['time'], ENT_COMPAT,'ISO-8859-1', true);
$_SESSION['id'] =  $id;
if((time() - $temp) > 1200){
    $_SESSION['expire']=true;
    $_SESSION['fichier']="file/key/$id.crt";
    header('Location: index.php?codeError=2');
    
} 
?>


    <form action="index.php" method= "POST" >
    <p><label>Clé privée RSA fournie</label></p>
    <p><textarea name="rsa"></textarea></p>	
    <p><label>Clé privée AES fournie</label></p>
    <p><input type="text" name="aes"/></p>
    <p><label>Veuillez reproduire les numéros présents sur le captcha</label><p>
<?php

    echo '<img src="captcha2.php" alt="CAPTCHA" />';

?>
<p><input type="text" name ="code"/></p>

<p><input class="button" type="submit" value="valider"/></p>
