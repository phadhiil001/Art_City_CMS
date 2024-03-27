<?php
include('header.php');

require('config/ImageResize.php');
require('config/ImageResizeException.php');

function file_upload_path($original_filename, $upload_subfolder_name = 'uploads')
{
    $current_folder = dirname(__FILE__);
    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
}

function file_is_allowed_file($temporary_path, $new_path)
{
    $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

    $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type = mime_content_type($temporary_path);

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid && $mime_type_is_valid;
}

function resize_file($original_filename, $new_path, $max_width)
{
    $image = new \Gumlet\ImageResize($original_filename);
    $image->resizeToWidth($max_width);
    $image->save($new_path);
}

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user_id'];
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_input(INPUT_POST, 'is_featured', FILTER_SANITIZE_NUMBER_INT);
    $is_featured = 0; // Initialize is_featured variable to 0

    // Check if a new thumbnail is uploaded
    $file_upload_detected = isset($_FILES['thumbnail']) && ($_FILES['thumbnail']['error'] === 0);

    if ($file_upload_detected) {
        $thumbnail_filename = $_FILES['thumbnail']['name'];
        $temporary_thumbnail_path = $_FILES['thumbnail']['tmp_name'];
        $new_thumbnail_path = file_upload_path($thumbnail_filename);

        if (file_is_allowed_file($temporary_thumbnail_path, $new_thumbnail_path)) {
            move_uploaded_file($temporary_thumbnail_path, $new_thumbnail_path);

            // Set is_featured to 1 if there is no existing featured post
            $existing_featured_post_query = "SELECT id FROM artcityposts WHERE is_featured = 1 LIMIT 1";
            $existing_featured_post_result = $db->query($existing_featured_post_query);

            if (!$existing_featured_post_result || $existing_featured_post_result->rowCount() == 0) {
                $is_featured = 1;
            }

            // Resize and save the image to a width of 600px
            resize_file($new_thumbnail_path, $new_thumbnail_path, 600);
        } else {
            $_SESSION['error'] = "Invalid file type. Only GIF, JPG, and JPEG files are allowed.";
            header('Location: new-post.php');
            exit();
        }
    }

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

    // Insert new post into the database
    $query = "INSERT INTO artcityposts (author_id, title, content, category_id, is_featured, thumbnail) VALUES (:author_id, :title, :content, :category_id, :is_featured, :thumbnail)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':is_featured', $is_featured, PDO::PARAM_INT);
    $stmt->bindParam(':thumbnail', $thumbnail_filename, PDO::PARAM_STR); // Assuming the thumbnail filename is stored in the database
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['success'] = "Post added successfully.";
        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['error'] = "Failed to add post. Please try again.";
        header('Location: new-post.php');
        exit();
    }
}
