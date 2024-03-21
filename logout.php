<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the sign-in page or any other appropriate page
header('Location: signin.php');
exit;
