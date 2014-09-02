<?php
$pathSession = 'file/temp';

if (headers_sent()) die ("Headers have already been sent");

if ( !file_exists($pathSession) ) {
    mkdir ($pathSession, 0770);
}
$dir = 'file/key';

if ( !file_exists($dir) ) {
    mkdir ($dir, 0770);
}
session_save_path($pathSession);
session_start();

$identifiantAdmin = 'runiso';
$passAdmin = '123456';

if(isset($_POST['IDADMIN']) and isset($_POST['MDPADMIN'])){
        
    $idadmin = htmlspecialchars($_POST['IDADMIN'], ENT_COMPAT,'ISO-8859-1', true);
    $mdpadmin = htmlspecialchars($_POST['MDPADMIN'], ENT_COMPAT,'ISO-8859-1', true);
    ;
    if(($idadmin == $identifiantAdmin) and ($mdpadmin == $passAdmin)){
        
        $_SESSION['admin']= $idadmin;
        header('Location : index.php');

 
    }
        
}
if(isset($_GET['clean']) and isset($_SESSION['admin'])){

foreach(glob("file/key/*.crt") as $filename){
	unlink($filename);

}


}
if(isset($_GET['deconnexion']) and isset($_SESSION['admin'])){
session_start();
session_destroy();
header('Location: index.php');
exit;

}
?>





<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
    <html class="no-js" lang="en" >

    <head>
    <meta charset="utf-8">
    <!-- If you delete this meta tag World War Z will become a reality -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partage mot de passe</title>

    <!-- If you are using the CSS version, only link these 2 files, you may add app.css to use for your overrides if you like -->
    <link rel="stylesheet" href="zurb/css/normalize.css">
    <link rel="stylesheet" href="zurb/css/foundation.css">

    <!-- If you are using the gem version, you need this only -->
    <link rel="stylesheet" href="zurb/css/app.css">

    <script src="zurb/js/vendor/modernizr.js"></script>

    </head>
    <body>



<?php
    include('navbar.php');
include('header.php');
?>
<div id ="contenu" class="large-12-columns">
<div class="row">
    <br/><br/>

    <script src="zurb/js/vendor/jquery.js"></script>
    <script src="zurb/js/foundation.min.js"></script>
    <script>
    $(document).foundation();
</script>

<?php
    
if(isset($_GET['code']) and isset($_GET['time'])){
    
    include('client.php');

}else if(isset($_POST['code'])){
    include('validation.php');

}else if(isset($_GET['codeError']) && $_GET['codeError']==2){
    include('expiration.php');
}else if(isset($_SESSION['admin']) and ($_SESSION['admin'] == $identifiantAdmin)) {
    include('create.php');
}else {
    include('connexion.php');

}


?>
</div>
</div>
<?php include('footer.php');?>
</body>
</html>
