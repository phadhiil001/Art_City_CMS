<?php
session_start();       // Start a new session
require('connect.php');  // Connect to the database

// Fetch user from the database if logged in
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id']; // Get user ID from session
    $query = "SELECT * FROM artcityusers WHERE id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirect to sign-in page if not logged in
    header('Location: signin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
</head>

<body>
    <?php include('nav.php'); ?>

</body>

</html>