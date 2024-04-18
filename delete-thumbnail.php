<?php
session_start();
require('connect.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_is_admin'])) {
    header("Location: index.php"); // Redirect unauthorized users
    exit();
}

// Check if thumbnail ID is provided and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $thumbnail_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Fetch the thumbnail filename from the database
    $query_thumbnail = "SELECT thumbnail FROM artcityposts WHERE id = :thumbnail_id";
    $stmt_thumbnail = $db->prepare($query_thumbnail);
    $stmt_thumbnail->bindParam(':thumbnail_id', $thumbnail_id, PDO::PARAM_INT);
    $stmt_thumbnail->execute();
    $thumbnail = $stmt_thumbnail->fetchColumn();

    // Delete the thumbnail from the database
    $query_delete_thumbnail = "UPDATE artcityposts SET thumbnail = NULL WHERE id = :thumbnail_id";
    $stmt_delete_thumbnail = $db->prepare($query_delete_thumbnail);
    $stmt_delete_thumbnail->bindParam(':thumbnail_id', $thumbnail_id, PDO::PARAM_INT);
    $stmt_delete_thumbnail->execute();

    // Delete the thumbnail file from the file system
    if ($thumbnail) {
        $thumbnail_path = 'uploads/' . $thumbnail; // Assuming the thumbnails are stored in the 'uploads' folder
        if (file_exists($thumbnail_path)) {
            unlink($thumbnail_path); // Delete the file
        }
    }

    // Redirect back to the previous page after deletion
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    // If thumbnail ID is not provided or is invalid, redirect to the homepage
    header("Location: index.php");
    exit();
}
