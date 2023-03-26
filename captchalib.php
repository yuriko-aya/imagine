<?php
    session_start();
    error_reporting(0);

    $image = @imagecreatetruecolor(160, 45) or die("Cannot Initialize GD Image Stream");

    $background = imagecolorallocate($image, 0x66, 0xCC, 0xFF);
    imagefill($image, 0, 0, $background);
    $linecolor =  imagecolorallocate($image, 0x33, 0x99, 0xCC);
    $textcolor1 = imagecolorallocate($image, 0x00, 0x00, 0x00);
    $textcolor2 = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);

    for ($i=0; $i < 8; $i++) {
        imagesetthickness($image, rand(1,3));
        imageline($image, rand(0,160), 0, rand(0,160), 45, $linecolor);
    }

    $font = dirname(__FILE__) . '/assets/opensans.ttf';

    $captcha = '';
    for ($x = 10; $x <= 130; $x += 30) {
        $textcolor = rand(1,2) == 1 ? $textcolor1 : $textcolor2;
        $captcha .= ($num = rand(0,9));
        imagettftext($image, 20, rand(-30,30), $x, rand(20,42), $textcolor, $font, $num);
    }

    $_SESSION['captcha'] = $captcha;

    header('Content-type: image/png');
    header("Cache-Control: no-store, no-cache, must-revalidate");
    imagepng($image);
    imagedestroy($image);
?>
