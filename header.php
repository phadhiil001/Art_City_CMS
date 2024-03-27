<?php
session_start();       // Start a new session
require('connect.php');  // Connect to the database
include('nav.php');

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
