<?php
session_start();
require('connect.php');

// Fetch featured post including its thumbnail
$query = "SELECT * FROM artcityposts WHERE is_featured = 1 LIMIT 1";
$result = $db->query($query);

// Fetch 9 regular posts from the database
$query_regular = 'SELECT * FROM artcityposts WHERE is_featured = 0 ORDER BY created_date DESC LIMIT 9';
$regular_posts =  $db->query($query_regular)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art City Inc.</title>
</head>

<body>

    <?php include('nav.php'); ?>

    <section class="featured">
        <div class="container featured__container">
            <?php if ($result && $result->rowCount() > 0) : ?>
                <?php $featured_post = $result->fetch(PDO::FETCH_ASSOC); ?>
                <div class="post__thumbnail">
                    <img src="./uploads/<?= $featured_post['thumbnail'] ?>" alt="Featured Post Image" />
                </div>
                <div class="post__info">
                    <!-- Fetch category title -->
                    <?php
                    $category_id = $featured_post["category_id"];
                    $cat_query = 'SELECT * FROM artcitycategories WHERE id = ?';
                    $cat_stmt = $db->prepare($cat_query);
                    $cat_stmt->execute([$category_id]);
                    $category = $cat_stmt->fetch(PDO::FETCH_ASSOC);
                    $category_title =  $category['title'];
                    ?>
                    <a href="category-post.php?id=<?= $category['id'] ?>" class="category__button"><?= $category_title ?></a>
                    <h2 class="post__title"><a href="post.php?id=<?= $featured_post['id'] ?>">
                            <?= $featured_post['title'] ?></a></h2>

                    <p class="post__body"><?= substr($featured_post['content'], 0, 200) . '...' ?></p>

                    <div class="post__author">
                        <?php
                        // Fetch author information
                        $author_id = $featured_post['author_id'];
                        $authors_query = "SELECT * FROM artcityusers WHERE id = :author_id";
                        $authors_stmt = $db->prepare($authors_query);
                        $authors_stmt->bindParam(":author_id", $author_id, PDO::PARAM_INT);
                        $authors_stmt->execute();
                        $author = $authors_stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="post__author-avatar">
                            <!-- Display user icon -->
                            <img src="logo/user.png" alt="" />
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <small><?= date("M d, Y - H:i", strtotime($featured_post['created_date'])) ?></small>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </section>

    <section class="posts">
        <div class="container posts__container">
            <?php foreach ($regular_posts as $post) : ?>
                <article class="post">
                    <?php if (isset($post['thumbnail'])) : ?>
                        <div class="post__thumbnail">
                            <img src="./uploads/<?= $post['thumbnail'] ?>" alt="Post Image" />
                        </div>
                    <?php endif; ?>
                    <div class="post__info">
                        <!-- Fetch category title -->
                        <?php
                        $category_id = $post["category_id"];
                        $cat_query = 'SELECT * FROM artcitycategories WHERE id = ?';
                        $cat_stmt = $db->prepare($cat_query);
                        $cat_stmt->execute([$category_id]);
                        $category = $cat_stmt->fetch(PDO::FETCH_ASSOC);
                        $category_title =  $category['title'];
                        ?>
                        <a href="category-post.php?id=<?= $category['id'] ?>" class="category__button"><?= $category_title ?></a>
                        <h3 class="post__title"><a href="post.php?id=<?= $post['id'] ?>">
                                <?= $post['title'] ?></a></h3>

                        <p class="post__body"><?= substr($post['content'], 0, 150) . '...' ?></p>
                    </div>
                    <div class="post__author">
                        <?php
                        // Fetch author information
                        $author_id = $post['author_id'];
                        $authors_query = "SELECT * FROM artcityusers WHERE id = :author_id";
                        $authors_stmt = $db->prepare($authors_query);
                        $authors_stmt->bindParam(":author_id", $author_id, PDO::PARAM_INT);
                        $authors_stmt->execute();
                        $author = $authors_stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="post__author-avatar">
                            <!-- Display user icon -->
                            <img src="logo/user.png" alt="" />
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <small><?= date("M d, Y - H:i", strtotime($post['created_date'])) ?></small>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>




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