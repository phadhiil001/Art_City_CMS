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
        <div class="container singlepost_container">
            <h2 class="post_title"><?= $post['title'] ?></h2>
            <div class="post_author">
                <?php
                // Fetch author information
                $author_id = $post['author_id'];
                $authors_query = "SELECT * FROM artcityusers WHERE id = :author_id";
                $authors_stmt = $db->prepare($authors_query);
                $authors_stmt->bindParam(":author_id", $author_id, PDO::PARAM_INT);
                $authors_stmt->execute();
                $author = $authors_stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="post_author_img">
                    <!-- Display user icon -->
                    <img src="logo/user.png" alt="" />
                </div>
                <div class="post_author_info">
                    <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                    <small><?= date("M d, Y - H:i", strtotime($post['created_date'])) ?></small>
                </div>
            </div>
            <?php if (isset($post['thumbnail'])) : ?>
                <div class="singlepost_thumbnail">
                    <img src="./uploads/<?= $post['thumbnail'] ?>" alt="Post Image" />
                </div>
            <?php endif; ?>
            <div class="post_info">
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

        </div>
    </section>
</body>

</html>