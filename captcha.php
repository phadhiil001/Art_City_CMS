<?php
session_start();

// Generate a random CAPTCHA code
$captcha = generateRandomString(6); // Adjust the length as needed

// Save the CAPTCHA code in the session
$_SESSION['captcha'] = $captcha;

// Output the CAPTCHA image
$width = 80; // Adjust the width of the image
$height = 20; // Adjust the height of the image
$font_size = 4; // Adjust the font size

$im = imagecreatetruecolor($width, $height);
$bgColor = imagecolorallocate($im, 255, 255, 255);
$textColor = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $bgColor);
imagestring($im, $font_size, 10, 5, $captcha, $textColor); // Adjust the position of the text

header('Content-type: image/png');
imagepng($im);
imagedestroy($im);

// Function to generate a random string
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charLength - 1)];
    }
    return $randomString;
}

// Check if the submitted CAPTCHA is correct
if (isset($_POST['captcha_submit'])) {
    if (isset($_POST['captcha_input']) && !empty($_POST['captcha_input'])) {
        if ($_POST['captcha_input'] === $_SESSION['captcha']) {
            // CAPTCHA is correct, process the comment
            $comment = $_POST['comment']; // Assuming 'comment' is the name of your comment input field
            // Process the comment here
            echo "Comment submitted successfully: " . $comment;
        } else {
            // CAPTCHA is incorrect, provide another chance without re-entering the comment
            echo "Incorrect CAPTCHA. Please try again.";
            // You can output the CAPTCHA image again here if needed
        }
    } else {
        echo "Please enter the CAPTCHA code.";
        // You can output the CAPTCHA image again here if needed
    }
}
