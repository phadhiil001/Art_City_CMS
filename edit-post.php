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
    <section class="form__section">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>

        <div class="container form__section-container">

            <h2>Edit Post</h2>
            <button class="btn"><a href="dashboard.php">Back</a></button>
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="alert__message error">
                    <p><strong><?= $_SESSION['error']; ?></strong></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif ?>
            <form action="edit-post-logic.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?= $title; ?>">

                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="20" cols="50"><?= $content; ?></textarea>

                <label for="category">Category:</label>
                <select id="category" name="category_id">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id']; ?>" <?= ($category['id'] == $category_id) ? 'selected' : ''; ?>>
                            <?= $category['title']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="form__control">
                    <label for="thumbnail">Thumbnail:</label>
                    <?php if (!empty($thumbnail)) : ?>
                        <div>
                            <img src="<?= 'uploads/' . $thumbnail; ?>" alt="Thumbnail"><br>
                        </div>
                    <?php endif; ?>
                    <input type="file" id="thumbnail" name="thumbnail">
                </div>


                <div class="form__control inline">
                    <label for="is_featured">Featured:</label>
                    <input type="checkbox" id="is_featured" name="is_featured" <?= ($is_featured == 1) ? 'checked' : ''; ?>>

                    <?php if (!empty($thumbnail)) : ?>
                        <a href="delete-thumbnail.php?id=<?= $post['id'] ?>" class="btn">Delete Thumbnail</a>
                    <?php endif; ?>
                </div>


                <button type="submit" name="submit" class="btn">Update Post</button>
            </form>
        </div>
    </section>

    <script src="main.js"></script>
</body>

</html>