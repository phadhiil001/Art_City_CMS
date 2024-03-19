<?php
session_start();
require('config/db_connect.php');

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Fetch user details from the database based on the provided ID
    $query = "SELECT * FROM artcityusers WHERE id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Delete the user if they exist in the database
    if ($user) {
        $deleteUserQuery = "DELETE FROM artcityusers WHERE id=:uid";
        $delStmt = $db->prepare($deleteUserQuery);
        $delStmt->bindParam(':uid', $id, PDO::PARAM_INT);
        $result = $delStmt->execute();

        if ($result) {
            $_SESSION['success'] = "User {$user['firstname']} {$user['lastname']} deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete user.";
        }
    } else {
        $_SESSION['error'] = "User not found.";
    }

    // Redirect to manage-users.php if 'id' parameter is missing
    header('Location: manage-users.php');
    exit();
}
