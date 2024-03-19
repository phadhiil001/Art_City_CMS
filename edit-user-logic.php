<?php
session_start();
require('config/db_connect.php');

if (isset($_POST['submit'])) {
    $id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $firstname  = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname   = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin  = filter_input(INPUT_POST, 'userrole', FILTER_SANITIZE_NUMBER_INT);

    if (!$firstname || !$lastname) {
        $_SESSION['error'] =  "Both fields are required";
        $_SESSION['form_data'] = $_POST; // Store form data in session
        header("Location: edit-user.php?id=$id");
        exit();
    } else {
        // Update user information in the database
        $sql = "UPDATE artcityusers SET firstName=?, lastName=?, is_admin=? WHERE id=? LIMIT 1";
        $update = $db->prepare($sql);

        // Bind values to placeholders
        $update->bindValue(1, $firstname);
        $update->bindValue(2, $lastname);
        $update->bindValue(3, $is_admin, PDO::PARAM_INT); // Ensure it's bound as an integer
        $update->bindValue(4, $id);

        // Execute the prepared statement
        $success = $update->execute();

        if ($success && $update->rowCount() == 1) {
            $_SESSION['success'] = "User $firstname $lastname has been updated successfully.";
        } else {
            $_SESSION['error'] = "An error occurred while updating the user. Please try again later.";
        }

        header("Location: manage-users.php?id=$id");
        exit();
    }
} else {
    header('Location: manage-users.php');
    exit();
}
