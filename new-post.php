<?php
include('header.php');

// Prepare and execute query to fetch categories ordered by title
$query = "SELECT * FROM artcitycategories ORDER BY title ASC";
$categories = $db->query($query);

// get back form
$title = $_SESSION['save']['title'] ?? null;
$content = $_SESSION['save']['content'] ?? null;

// Check if there are no categories
if ($categories->rowCount() == 0) {
    $noCategoryMessage = "No category found in the database.";
}

unset($_SESSION['save']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
</head>

<body>
    <section>
        <div>
            <h2>New Post</h2>
            <?php if (isset($_SESSION['success'])) : // show success update 
            ?>
                <div class="error-message">
                    <p><?= $_SESSION['success']; ?></p>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php elseif (isset($_SESSION['add-post'])) : // show succe message for new post
            ?>
                <div class="error-message">
                    <p><?= $_SESSION['add-post']; ?></p>
                </div>
                <?php unset($_SESSION['add-post']); ?>
            <?php elseif (isset($_SESSION['error'])) : // show error message
            ?>
                <div class="error-message">
                    <p><?= $_SESSION['error']; ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif ?>

            <form class="edit-form" method="post" action="new-post-logic.php" enctype="multipart/form-data">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($title) ?>" placeholder="Add a Title">
                <br />
                <select name="category_id">
                    <?php while ($row = $categories->fetch(PDO::FETCH_ASSOC)) : ?>
                        <option value="<?= $row['id'] ?>">
                            <?= $row['title']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="content">Content</label>
                <textarea rows="10" id="content" name="content" value="<?= htmlspecialchars($content) ?>" placeholder="Add Content"></textarea>

                <?php if (isset($_SESSION['user_is_admin'])) : ?>
                    <div>
                        <label for="is_featured">Featured</label>
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" checked>
                    </div>
                <?php endif; ?>
                <div>
                    <label for="thumbnail">Add thumbnail</label>
                    <input type="file" id="thumbnail" name="thumbnail">
                </div>

                <button type="submit" name="submit">Add Post</button>
            </form>
        </div>
    </section>
</body>

</html>