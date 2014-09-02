<<<<<<< HEAD
<?php
// On crée la session avant tout
session_save_path('file/temp');

session_start();

// On définit la configuration :
$nbr_chiffres = 10; // Nombre de chiffres qui formeront le nombre

// Là, on définit le header de la page pour la transformer en image
header ("Content-type: image/png");
// Là, on crée notre image
$_img = imagecreatefromjpeg('noir.jpg');

// On définit maintenant les couleurs
// Couleur de fond :
$arriere_plan = imagecolorallocate($_img, 0, 0, 0); // Au cas où on n'utiliserait pas d'image de fond, on utilise cette couleur-là.
// Autres couleurs :
$r = mt_rand(125,255);
$v = mt_rand(125,255);
$b = mt_rand(125,255);
$avant_plan = imagecolorallocate($_img, $r, $v, $b); // Couleur des chiffres

##### Ici on crée la variable qui contiendra le nombre aléatoire #####
$i = 0;
while($i < $nbr_chiffres) {
    $chiffre = mt_rand(0, 9); // On génère le nombre aléatoire
    $chiffres[$i] = $chiffre;
    $i++;
}
$nombre = null;
// On explore le tableau $chiffres afin d'y afficher toutes les entrées qui s'y trouvent
foreach ($chiffres as $caractere) {
    $nombre .= $caractere;
}
##### On a fini de créer le nombre aléatoire, on le rentre maintenant dans une variable de session #####
$_SESSION['aleat_nbr'] = $nombre;
// On détruit les variables inutiles :
unset($chiffre);
unset($i);
unset($caractere);
unset($chiffres);

$x = mt_rand(1,60);
$y = mt_rand(1,40);

imagestring($_img, 5, $x, $y, $nombre, $avant_plan);

imagepng($_img);
?>
=======
<?php
//
//A simple PHP CAPTCHA script
//
//Copyright 2013 by Cory LaViska for A Beautiful Site, LLC.
//
//See readme.md for usage, demo, and licensing info
//
function captcha($config = array()) {
    
    // Check for GD library
    if( !function_exists('gd_info') ) {
        throw new Exception('Required GD library is missing');
    }
    
    $bg_path = dirname(__FILE__) . '/backgrounds/';
    $font_path = dirname(__FILE__) . '/fonts/';
    
    // Default values
    $captcha_config = array(
        'code' => '',
        'min_length' => 8,
        'max_length' => 8,
        'backgrounds' => array(
            $bg_path . '45-degree-fabric.png',
            $bg_path . 'cloth-alike.png',
            $bg_path . 'grey-sandbag.png',
            $bg_path . 'kinda-jean.png',
            $bg_path . 'polyester-lite.png',
            $bg_path . 'stitched-wool.png',
            $bg_path . 'white-carbon.png',
            $bg_path . 'white-wave.png'
        ),
        'fonts' => array(
            $font_path . 'times_new_yorker.ttf'
        ),
        'characters' => '0123456789',
        'min_font_size' => 14,
        'max_font_size' => 16,
        'color' => '#666',
        'angle_min' => -30,
        'angle_max' => 30,
        'shadow' => true,
        'shadow_color' => '#fff',
        'shadow_offset_x' => -1,
        'shadow_offset_y' => 1
    );
    
    // Overwrite defaults with custom config values
    if( is_array($config) ) {
        foreach( $config as $key => $value ) $captcha_config[$key] = $value;
    }
    
    // Restrict certain values
    if( $captcha_config['min_length'] < 1 ) $captcha_config['min_length'] = 1;
    if( $captcha_config['angle_min'] < 0 ) $captcha_config['angle_min'] = 0;
    if( $captcha_config['angle_max'] > 10 ) $captcha_config['angle_max'] = 10;
    if( $captcha_config['angle_max'] < $captcha_config['angle_min'] ) $captcha_config['angle_max'] = $captcha_config['angle_min'];
    if( $captcha_config['min_font_size'] < 10 ) $captcha_config['min_font_size'] = 10;
    if( $captcha_config['max_font_size'] < $captcha_config['min_font_size'] ) $captcha_config['max_font_size'] = $captcha_config['min_font_size'];
    
    // Use milliseconds instead of seconds
    srand(microtime() * 100);
    
    // Generate CAPTCHA code if not set by user
    if( $captcha_config['code']=='' ) {
        $captcha_config['code'] = '';
        $length = mt_rand($captcha_config['min_length'], $captcha_config['max_length']);
        while( strlen($captcha_config['code']) < $length ) {
            $captcha_config['code'] .= substr($captcha_config['characters'], rand() % (strlen($captcha_config['characters'])), 1);
        }
    }
    

// Generate HTML for image src
    $image_src = '?_CAPTCHA&amp;t=' . urlencode(microtime());
    $nbr = $captcha_config['code'];    
    $_SESSION['_CAPTCHA']['config'] = serialize($captcha_config);

    return array(
        'code' => $nbr,
        'image_src' => $image_src
    );
    
}


if( !function_exists('hex2rgb') ) {
    function hex2rgb($hex_str, $return_string = false, $separator = ',') {
        $hex_str = preg_replace("/[^0-9A-Fa-f]/", '', $hex_str); // Gets a proper hex string
        $rgb_array = array();
        if( strlen($hex_str) == 6 ) {
            $color_val = hexdec($hex_str);
            $rgb_array['r'] = 0xFF & ($color_val >> 0x10);
            $rgb_array['g'] = 0xFF & ($color_val >> 0x8);
            $rgb_array['b'] = 0xFF & $color_val;
        } elseif( strlen($hex_str) == 3 ) {
            $rgb_array['r'] = hexdec(str_repeat(substr($hex_str, 0, 1), 2));
            $rgb_array['g'] = hexdec(str_repeat(substr($hex_str, 1, 1), 2));
            $rgb_array['b'] = hexdec(str_repeat(substr($hex_str, 2, 1), 2));
        } else {
            return false;
        }
        return $return_string ? implode($separator, $rgb_array) : $rgb_array;
    }
}

// Draw the image
if( isset($_GET['_CAPTCHA']) ) {
    
    //session_start();
    
    $captcha_config = unserialize($_SESSION['_CAPTCHA']['config']);
    if( !$captcha_config ) exit();
    
    unset($_SESSION['_CAPTCHA']);
    
    // Use milliseconds instead of seconds
    srand(microtime() * 100);
    
    // Pick random background, get info, and start captcha
    $background = $captcha_config['backgrounds'][rand(0, count($captcha_config['backgrounds']) -1)];
    list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);
    
    $captcha = imagecreatefrompng($background);
    
    $color = hex2rgb($captcha_config['color']);
    $color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);
    
    // Determine text angle
    $angle = rand( $captcha_config['angle_min'], $captcha_config['angle_max'] ) * (rand(0, 1) == 1 ? -1 : 1);
    
    // Select font randomly
    $font = $captcha_config['fonts'][rand(0, count($captcha_config['fonts']) - 1)];
    
    // Verify font file exists
    if( !file_exists($font) ) throw new Exception('Font file not found: ' . $font);
    
    //Set the font size.
    $font_size = rand($captcha_config['min_font_size'], $captcha_config['max_font_size']);
    $text_box_size = imagettfbbox($font_size, $angle, $font, $captcha_config['code']);
    
    // Determine text position
    $box_width = abs($text_box_size[6] - $text_box_size[2]);
    $box_height = abs($text_box_size[5] - $text_box_size[1]);
    $text_pos_x_min = 0;
    $text_pos_x_max = ($bg_width) - ($box_width);
    $text_pos_x = rand($text_pos_x_min, $text_pos_x_max);
    $text_pos_y_min = $box_height;
    $text_pos_y_max = ($bg_height) - ($box_height / 2);
    $text_pos_y = rand($text_pos_y_min, $text_pos_y_max);
    
    // Draw shadow
    if( $captcha_config['shadow'] ){
        $shadow_color = hex2rgb($captcha_config['shadow_color']);
        $shadow_color = imagecolorallocate($captcha, $shadow_color['r'], $shadow_color['g'], $shadow_color['b']);
        imagettftext($captcha, $font_size, $angle, $text_pos_x + $captcha_config['shadow_offset_x'], $text_pos_y + $captcha_config['shadow_offset_y'], $shadow_color, $font, $captcha_config['code']);
    }
    
    // Draw text
    imagettftext($captcha, $font_size, $angle, $text_pos_x, $text_pos_y, $color, $font, $captcha_config['code']);
    
    // Output image
    header("Content-type: image/png");
    imagepng($captcha);
    
}
>>>>>>> 1b053e17c0a55f8b946a30a547e97c3c4a5c22e4
