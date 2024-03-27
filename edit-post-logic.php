<?php
session_start();
require('connect.php');
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

    return in_array($actual_file_extension, $allowed_file_extensions) && in_array($actual_mime_type, $allowed_mime_types);
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
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = "";
    $previous_thumbnail = filter_input(INPUT_POST, 'previous_thumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $file_upload_detected = isset($_FILES['thumbnail']) && ($_FILES['thumbnail']['error'] === 0);

    if ($file_upload_detected) {
        $thumbnail_filename = $_FILES['thumbnail']['name'];
        $temporary_thumbnail_path = $_FILES['thumbnail']['tmp_name'];
        $new_thumbnail_path = file_upload_path($thumbnail_filename);

        if (file_is_allowed_file($temporary_thumbnail_path, $new_thumbnail_path)) {
            move_uploaded_file($temporary_thumbnail_path, $new_thumbnail_path);
            $thumbnail = $new_thumbnail_path;

            $file_extension = pathinfo($thumbnail_filename, PATHINFO_EXTENSION);
            $file_name = pathinfo($thumbnail_filename, PATHINFO_FILENAME);

            $medium_thumbnail_path = file_upload_path($file_name . "_medium." . $file_extension);
            $thumbnail_thumbnail_path = file_upload_path($file_name . "_thumbnail." . $file_extension);

            resize_file($new_thumbnail_path, $medium_thumbnail_path, 400);
            resize_file($new_thumbnail_path, $thumbnail_thumbnail_path, 50);
        } else {
            $_SESSION['error'] = "Invalid file type. Only GIF, JPG, and JPEG files are allowed.";
            header('Location: edit-post.php?id=' . $_POST['id']);
            exit();
        }
    } else {
        $thumbnail = $previous_thumbnail;
    }

    if (!$title || !$content || !$category_id) {
        $_SESSION['error'] = "Please fill in all the required fields.";
        header('Location: edit-post.php?id=' . $_POST['id']);
        exit();
    }

    $query = "UPDATE artcityposts SET title = :title, content = :content, category_id = :category_id, is_featured = :is_featured";
    if ($file_upload_detected) {
        $query .= ", thumbnail = :thumbnail";
    }
    $query .= " WHERE id = :id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':is_featured', $is_featured, PDO::PARAM_INT);
    if ($file_upload_detected) {
        $stmt->bindParam(':thumbnail', $thumbnail, PDO::PARAM_STR);
    }
    $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Post updated successfully.";
        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['error'] = "Failed to update post. Please try again.";
        header('Location: edit-post.php?id=' . $_POST['id']);
        exit();
    }
} else {
    header('Location: edit-post.php');
    exit();
}
