<?php
session_start();
require('connect.php');

// Check if the post ID is provided via GET
if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

// Fetch the post details from the database based on the provided ID
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT * FROM artcityposts WHERE id=:id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the post exists
if (!$post) {
    $_SESSION['error'] = "Post not found.";
    header('Location: dashboard.php');
    exit();
}

// Store the thumbnail path
$thumbnail_name = $post['thumbnail'];
$thumbnail_path = 'uploads/' . $thumbnail_name;

// Delete the post from the database
$query_delete = "DELETE FROM artcityposts WHERE id=:id";
$stmt_delete = $db->prepare($query_delete);
$stmt_delete->bindParam(':id', $id, PDO::PARAM_INT);
$delete_result = $stmt_delete->execute();

if ($delete_result) {
    // Delete the thumbnail from the filesystem if it exists
    if (!empty($thumbnail_name) && file_exists($thumbnail_path)) {
        unlink($thumbnail_path);
    }

    $_SESSION['success'] = "Post deleted successfully.";
    header('Location: dashboard.php');
    exit();
} else {
    $_SESSION['error'] = "Failed to delete post. Please try again.";
    header('Location: dashboard.php');
    exit();
}
