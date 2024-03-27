<?php
session_start();
require('connect.php');
require('config/ImageResize.php');  // Include the Image Resizing Class
require('config/ImageResizeException.php');   // Include the Exception class

// Default upload path is an 'uploads' sub-folder in the current folder.
function file_upload_path($original_filename, $upload_subfolder_name = 'uploads')
{
    $current_folder = dirname(__FILE__);

    // Build an array of paths segment names to be joins using OS specific slashes.
    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

    // The DIRECTORY_SEPARATOR constant is OS specific.
    return join(DIRECTORY_SEPARATOR, $path_segments);
}

// file_is_valid() - Checks the mime-type & extension of the uploaded file.
function file_is_allowed_file($temporary_path, $new_path)
{
    $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type        = mime_content_type($temporary_path);

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid && $mime_type_is_valid;
}

// Resize image using PHP Image Resize library
function resize_file($original_filename, $new_path, $max_width)
{
    $image = new \Gumlet\ImageResize($original_filename);
    $image->resizeToWidth($max_width);
    $image->save($new_path);
}

$file_upload_detected = isset($_FILES['thumbnail']) && ($_FILES['thumbnail']['error'] === 0);
$upload_error_detected = isset($_FILES['thumbnail']) && ($_FILES['thumbnail']['error'] > 0);

if ($file_upload_detected) {
    $thumbnail_filename        = $_FILES['thumbnail']['name'];
    $temporary_thumbnail_path  = $_FILES['thumbnail']['tmp_name'];
    $new_thumbnail_path        = file_upload_path($thumbnail_filename);

    if (file_is_allowed_file($temporary_thumbnail_path, $new_thumbnail_path)) {
        move_uploaded_file($temporary_thumbnail_path, $new_thumbnail_path);
        $message = "File uploaded successfully.";

        // Extract file extension from the original filename
        $file_extension = pathinfo($thumbnail_filename, PATHINFO_EXTENSION);
        $file_name = pathinfo($thumbnail_filename, PATHINFO_FILENAME);

        // Resize images
        $medium_thumbnail_path = file_upload_path($file_name . "_medium." . $file_extension);
        $thumbnail_thumbnail_path = file_upload_path($file_name . "_thumbnail." . $file_extension);

        // Resize original to max width 400px
        resize_file($new_thumbnail_path, $medium_thumbnail_path, 400);

        // Resize original to max width 50px for the thumbnail
        resize_file($new_thumbnail_path, $thumbnail_thumbnail_path, 50);
    } else {
        $message = "Invalid file type. Only GIF, JPG, JPEG, and PNG files are allowed.";
    }
}

if (isset($_POST['submit'])) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $author_id = $_SESSION['user_id'];
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_input(INPUT_POST, 'is_featured', FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0; // Check if the post is featured
    $thumbnail = $new_thumbnail_path; // Use the path of the uploaded thumbnail

    // Validate input
    if (!$title) {
        $_SESSION['save'] = $_POST;
        $_SESSION['error'] = "Title is required.";
        header('Location: new-post.php');
        exit();
    } elseif (!$content) {
        $_SESSION['save'] = $_POST;
        $_SESSION['error'] = "Content is required.";
        header('Location: new-post.php');
    } elseif (!$category_id) {
        $_SESSION['save'] = $_POST;
        $_SESSION['error'] = "Select a category";
        header('Location: new-post.php');
    } elseif (!$thumbnail) {
        $_SESSION['error'] = "Thumbnail image is required.";
        header('Location: new-post.php?upload=false');
        exit();
    }

    // Prepare the SQL statement to insert a new post into the database
    $query = "INSERT INTO artcityposts (author_id, title, content, category_id, is_featured, thumbnail) VALUES (:author_id, :title, :content, :category_id, :is_featured, :thumbnail)";
    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(':author_id', $author_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':is_featured', $is_featured);
    $stmt->bindParam(':thumbnail', $thumbnail);

    // Execute the query
    if ($stmt->execute()) {
        if ($is_featured == 1) {
            $_zero = "UPDATE artcityposts SET is_featured = 0";
            $zero_stmt = $db->prepare($_zero);
            $zero_stmt->execute();
        }
        $_SESSION['success'] = "$title post added successfully.";
        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['add-post']  = $_POST;
        $_SESSION['error'] = "Failed to add post. Please try again later.";
        header('Location: new-post.php');
        exit();
    }
} else {
    // If the request method is not POST, redirect to the new-post page
    header('Location: new-post.php');
    exit();
}
