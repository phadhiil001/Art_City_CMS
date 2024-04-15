<?php
session_start();
require('connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Save user input in session variables
    $_SESSION['comment_author'] = $_POST['author'];
    $_SESSION['comment_text'] = $_POST['comment'];

    // Check if all fields are filled
    if (
        isset($_POST['post_id'], $_POST['author'], $_POST['comment'], $_POST['captcha'])
        && !empty($_POST['post_id']) && !empty($_POST['author']) && !empty($_POST['comment']) && !empty($_POST['captcha'])
    ) {

        // Validate CAPTCHA code
        if ($_POST['captcha'] === $_SESSION['captcha']) {

            // Retrieve data from the form
            $post_id = $_POST['post_id'];
            $author = $_POST['author'];
            $comment = $_POST['comment'];

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
            } else {
                $_SESSION["error"] = "Error adding the comment. Please try again later.";
            }
        } else {
            $_SESSION['error'] = "Incorrect CAPTCHA code. Please try again.";
        }
    } else {
        $_SESSION["error"] = "Please fill out all fields.";
    }
}

// Redirect back to the referring page
header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
