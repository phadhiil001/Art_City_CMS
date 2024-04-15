<?php
session_start();

// Function to generate a random CAPTCHA code
function generateRandomString($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charLength - 1)];
    }
    return $randomString;
}

// Generate a random CAPTCHA code
$captcha = generateRandomString(); // Default length is 6 characters

// Save the CAPTCHA code in the session
$_SESSION['captcha'] = $captcha;

// Output the CAPTCHA image
$width = 120; // Adjust the width of the image
$height = 40; // Adjust the height of the image
$font_size = 20; // Adjust the font size

$im = imagecreatetruecolor($width, $height);
$bgColor = imagecolorallocate($im, 255, 255, 255);
$textColor = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $bgColor);
imagestring($im, $font_size, 10, 10, $captcha, $textColor); // Adjust the position of the text

header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
