<?php
session_start();
require('connect.php');
include('nav.php');

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
    if (!$category) {
        // Handle case where category with provided ID does not exist
        header('Location: manage-categories.php');
        exit();
    }
    // Assign category details to variables for use in the form
    $title = htmlspecialchars($category['title']);
    $description = htmlspecialchars($category['description']);
} else {
    // Redirect to manage-categories.php if 'id' parameter is missing
    header('Location: manage-categories.php');
    exit();
}
?>

<section class="form section">
    <div class="container form section-container">
        <h2>Edit Category</h2>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error-message">
                <p><?= $_SESSION['error']; ?></p>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif ?>

        <form action="edit-category-logic.php" method="post">
            <input type="text" value="<?= $title ?>" name="title" placeholder="Title">
            <textarea rows="4" name="description" placeholder="Description"><?= $description ?></textarea>

            <input type="hidden" name="category_id" value="<?= $id ?>">
            <button type="submit" name="submit">Update Category</button>
        </form>
    </div>
</section>