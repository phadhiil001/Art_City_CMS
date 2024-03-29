<?php
include('header.php');

if (isset($_GET['id'])) {
    // Fetch the post details from the database based on the provided ID
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM artcityposts WHERE id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the post exists
    if (!$post) {
        header('Location: dashboard.php');
        exit();
    }


    // Assign post details to variables
    $title = htmlspecialchars($post['title']);
    $content = htmlspecialchars($post['content']);
    $category_id = $post['category_id'];
    $is_featured = $post['is_featured'];
    $thumbnail = $post['thumbnail']; // Make sure $thumbnail is defined

    // Fetch categories from the database
    $query_categories = "SELECT * FROM artcitycategories ORDER BY title ASC";
    $stmt_categories = $db->query($query_categories);
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are no categories
    if (empty($categories)) {
        $noCategoryMessage = "No category found in the database.";
    }
} else {
    header('Location: edit-post.php');
    exit();
}
// Unset the saved values from session to prevent them from persisting after use
unset($_SESSION['save']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>

<body>
    <h2>Edit Post</h2>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="error-message">
            <p><strong><?= $_SESSION['error']; ?></strong></p>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif ?>
    <form action="edit-post-logic.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br><br>

        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50"><?php echo $content; ?></textarea><br><br>

        <label for="category">Category:</label><br>
        <select id="category" name="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $category_id) ? 'selected' : ''; ?>>
                    <?php echo $category['title']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="thumbnail">Thumbnail:</label><br>
        <img src="<?php echo $thumbnail; ?>" alt="Thumbnail" style="width: 100px;"><br>
        <input type="file" id="thumbnail" name="thumbnail"><br><br>

        <label for="is_featured">Featured:</label>
        <input type="checkbox" id="is_featured" name="is_featured" <?php echo ($is_featured == 1) ? 'checked' : ''; ?>><br><br>

        <input type="submit" name="submit" value="Submit">
    </form>
</body>

</html>