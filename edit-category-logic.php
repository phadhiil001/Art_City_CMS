<?php
session_start();
require('connect.php');

if (isset($_POST['submit'])) {
    $id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    $title  = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description   = filter_input(INPUT_POST, "description", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$title || !$description) {
        $_SESSION['error'] =  "Both fields are required";
        $_SESSION['form_data'] = $_POST; // Store form data in session
        header("Location: edit-category.php?id=$id");
        exit();
    } else {
        // Update category information in the database
        $sql = "UPDATE artcitycategories SET title=?, description=? WHERE id=?";
        $update = $db->prepare($sql);

        // Bind values to placeholders
        $update->bindValue(1, $title);
        $update->bindValue(2, $description);
        $update->bindValue(3, $id);

        // Execute the prepared statement
        $success = $update->execute();

        if ($success && $update->rowCount() == 1) {
            $_SESSION['add-category'] = "Category $title has been updated successfully.";
        } else {
            $_SESSION['error'] = "An error occurred while updating the category. Please try again later.";
        }

        header("Location: manage-categories.php");
        exit();
    }
} else {
    header('Location: manage-categories.php');
    exit();
}
