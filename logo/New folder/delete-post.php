<?php
session_start();
require('connect.php');

// Fetch the comment ID from the URL parameter
$comment_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Check if the comment ID is provided
if (!$comment_id) {
    header('Location: dashboard.php');
    exit();
}

// Delete the comment from the database
$query_delete = "DELETE FROM artcitycomments WHERE id=:id";
$stmt_delete = $db->prepare($query_delete);
$stmt_delete->bindParam(':id', $comment_id, PDO::PARAM_INT);
$stmt_delete->execute();

// Redirect the user back to the dashboard
header('Location: dashboard.php');
exit();
?>
