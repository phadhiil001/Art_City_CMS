<?php
session_start();
require('connect.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_is_admin'])) {
    header("Location: index.php"); // Redirect unauthorized users
    exit();
}

// Check if comment ID is provided and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $comment_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Delete the comment from the database
    $query = "DELETE FROM artcitycomments WHERE id = :comment_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the previous page after deletion
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    // If comment ID is not provided or is invalid, redirect to the homepage
    header("Location: index.php");
    exit();
}
