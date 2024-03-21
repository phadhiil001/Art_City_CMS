<?php

session_start();
require('connect.php');

if (isset($_POST['submit'])) {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$title) {
        $_SESSION['error'] = "Please enter a title.";
        $_SESSION['add-category-data'] = $_POST; // Store form data in session
        header('Location: add-categories.php');
        exit();
    } elseif (!$description) {
        $_SESSION['error'] = "Please enter a description.";
        $_SESSION['add-category-data'] = $_POST; // Store form data in session
        header('Location: add-categories.php');
        exit();
    }

    // Build the parameterized SQL query and bind to the above sanitized values.
    $query = "INSERT INTO artcitycategories (title, description) VALUES (:title, :description)";
    $statement = $db->prepare($query);

    // Bind values to the parameters
    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);

    // Execute the prepared statement
    if ($statement->execute()) {
        // Redirect the user to the manage categories page after successful registration and destroy the session
        $_SESSION['add-category'] = "$title category added successfully";
        header('Location: manage-categories.php');
        exit();
    } else {
        $_SESSION['error'] = "Unable to add category, please try again later.";
        header('Location: add-category.php');
        exit();
    }
} else {
    // Handle case where form was not submitted
}
