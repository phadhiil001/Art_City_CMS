<?php
session_start();
require('connect.php');

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the sign-in page or any other appropriate page
    header('Location: signin.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Fetch category details from the database based on the provided ID
    $query = "SELECT * FROM artcitycategories WHERE id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    // Delete the category if it exists in the database
    if ($category) {
        // Delete the category
        $deleteCategoryQuery = "DELETE FROM artcitycategories WHERE id=:id";
        $delStmt = $db->prepare($deleteCategoryQuery);
        $delStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $delStmt->execute();
        $_SESSION['success'] = "Category '{$category['title']}' deleted successfully. Posts moved to 'Uncategorized' category.";
        if ($result) {
            // Move posts from deleted category to "Uncategorized" category
            $uncategorizedCategoryId = 1; // Adjust this ID based on your "Uncategorized" category ID
            $updatePostsQuery = "UPDATE artcityposts SET category_id=:uncategorizedCategoryId WHERE category_id=:deletedCategoryId";
            $updateStmt = $db->prepare($updatePostsQuery);
            $updateStmt->bindParam(':uncategorizedCategoryId', $uncategorizedCategoryId, PDO::PARAM_INT);
            $updateStmt->bindParam(':deletedCategoryId', $id, PDO::PARAM_INT);
            $updateResult = $updateStmt->execute();

            if ($updateResult) {
                $_SESSION['success'] = "Category '{$category['title']}' deleted successfully. Posts moved to 'Uncategorized' category.";
            } else {
                $_SESSION['error'] = "Failed to move posts to 'Uncategorized' category.";
            }
        } else {
            $_SESSION['error'] = "Failed to delete category.";
        }
    } else {
        $_SESSION['error'] = "Category not found.";
    }

    // Redirect to manage-categories.php regardless of success or failure
    header('Location: manage-categories.php');
    exit();
}
