<?php
session_start();       // Start a new session
require('connect.php');  // Connect to the database

// Fetch user from the database if logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to the dashboard or home page if the user is already logged in
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art City Inc.</title>
</head>

<body>

    <?php include('nav.php'); ?>


</body>

</html>