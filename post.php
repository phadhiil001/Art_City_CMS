<?php
session_start();
require('connect.php');
include('nav.php');

// Fetch post from database
if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM artcityposts WHERE id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: index.php");
    exit();
}

// Retrieve saved values from session
$author = isset($_SESSION['save']['author']) ? $_SESSION['save']['author'] : '';
$comment = isset($_SESSION['save']['comment']) ? $_SESSION['save']['comment'] : '';

// Unset the saved values from session to prevent them from persisting after use
unset($_SESSION['save']);

// Fetch comments associated with the specific post ID
$query = "SELECT * FROM artcitycomments WHERE post_id=:post_id ORDER BY created_date DESC";
$stmt = $db->prepare($query);
$stmt->bindParam(':post_id', $id, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $post['title'] ?></title>
</head>

<body>
    <section class="singlepost">
        <div class="container singlepost__container">
            <h2><?= $post['title'] ?></h2>
            <div class="post__author">

                <?php
                // Fetch author information
                $author_id = $post['author_id'];
                $authors_query = "SELECT * FROM artcityusers WHERE id = :author_id";
                $authors_stmt = $db->prepare($authors_query);
                $authors_stmt->bindParam(":author_id", $author_id, PDO::PARAM_INT);
                $authors_stmt->execute();
                $author_info = $authors_stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="post__author-avatar">
                    <!-- Display user icon -->
                    <img src="logo/user.png" alt="" />
                </div>
                <div class="post__author-info">
                    <h5>By: <?= "{$author_info['firstname']} {$author_info['lastname']}" ?></h5>
                    <small><?= date("M d, Y - H:i", strtotime($post['created_date'])) ?></small>
                </div>
            </div>
            <?php if (isset($post['thumbnail'])) : ?>
                <div class="singlepost__thumbnail">
                    <img src="./uploads/<?= $post['thumbnail'] ?>" alt="Post Image" />
                </div>
            <?php endif; ?>

            <!-- Fetch category title -->
            <?php
            $category_id = $post["category_id"];
            $cat_query = 'SELECT * FROM artcitycategories WHERE id = ?';
            $cat_stmt = $db->prepare($cat_query);
            $cat_stmt->execute([$category_id]);
            $category = $cat_stmt->fetch(PDO::FETCH_ASSOC);
            $category_title =  $category['title'];
            ?>
            <a href="category-post.php?id=<?= $category_id ?>"><?= $category_title ?></a>

            <p class="post_content"><?= $post['content'] ?></p>

        </div>
    </section>

    <?php if (isset($_SESSION['registration']) || isset($_SESSION['error'])) : ?>
        <div class="container">
            <?php if (isset($_SESSION['registration'])) : ?>
                <div class="alert__message success">
                    <p><?= $_SESSION['registration']; ?></p>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="alert__message error">
                    <p><?= $_SESSION['error']; ?></p>
                </div>
            <?php endif; ?>
        </div>
        <?php unset($_SESSION['registration']); ?>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="container form__section-container">

        <?php foreach ($comments as $comment) : ?>
            <div class="post__author-avatar">
                <!-- Display user icon -->
                <img src="logo/user.png" alt="" />
            </div>
            <div class="post__author-info">
                <h5><strong><?= htmlspecialchars($comment['author']) ?>:</strong> <?= htmlspecialchars($comment['comment']) ?></h5>
                <small>Posted on: <?= $comment['created_date'] ?></small>
            </div>
            <div>
                <?php if (isset($_SESSION['user_is_admin'])) : ?>
                    <ul class="admin-actions">
                        <!-- Delete Button -->
                        <li><a href="delete-comment.php?id=<?= $comment['id'] ?>" class="btn sm danger">Delete</a></li>
                    </ul>
                <?php endif; ?>
            </div><br>
        <?php endforeach; ?>


        <h3>Add a Comment:</h3>
        <form action="comment-logic.php" method="post">
            <input type="hidden" name="post_id" value="<?= $id ?>">
            <input type="text" name="author" placeholder="Enter your name" value="<?= isset($author) && is_string($author) ? htmlspecialchars($author) : '' ?>">
            <textarea rows="10" name="comment" placeholder="Enter your comment"><?= isset($comment) && is_string($comment) ? htmlspecialchars($comment) : '' ?></textarea>


            <button type="submit" name="submit" class="btn">Submit</button>
        </form>
    </div>

    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php
            $categories_query = "SELECT * FROM artcitycategories ORDER BY title ASC";
            $categories_stmt = $db->query($categories_query);
            ?>

            <?php while ($cat = $categories_stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                <a href="category-post.php?id=<?= $cat['id'] ?>" class="category__button"><?= $cat['title'] ?></a>
            <?php endwhile; ?>
        </div>
    </section>
</body>

</html>