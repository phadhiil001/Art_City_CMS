<?php
session_start();
require('connect.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {

    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);
    $author = isset($_SESSION['user_id']) ? $_SESSION['username'] : (isset($_POST['author']) ? filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS) : 'Anonymous');
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_SPECIAL_CHARS);
    $captcha = filter_input(INPUT_POST, 'captcha', FILTER_SANITIZE_SPECIAL_CHARS);

    // Save user input in session variables
    $_SESSION['comment_text'] = $comment;

    // Check if all fields are filled
    if (!$post_id || !$comment) {
        $_SESSION['error'] = "Please fill in all the required fields.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    // Validate CAPTCHA code if user is not logged in
    if (!isset($_SESSION['user_id']) && $_POST['captcha'] !== $_SESSION['captcha']) {
        $_SESSION['error'] = "Incorrect CAPTCHA code. Please try again.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    // Prepare and execute the query to insert the comment
    $query = "INSERT INTO artcitycomments (post_id, author, comment) VALUES (:post_id, :author, :comment)";
    $insert = $db->prepare($query);

    // Bind parameters
    $insert->bindParam(':post_id', $post_id);
    $insert->bindParam(':author', $author);
    $insert->bindParam(':comment', $comment);

    // Execute the query
    if ($insert->execute()) {
        $_SESSION['registration'] = "Comment added successfully";
        // Clear comment session variables
        unset($_SESSION['comment_author']);
        unset($_SESSION['comment_text']);
    } else {
        $_SESSION["error"] = "Error adding the comment. Please try again later.";
    }

    // Redirect back to the referring page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
