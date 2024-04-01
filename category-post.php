<?php
session_start();
require('connect.php');
include('nav.php');

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM artcityposts WHERE category_id=:id ORDER BY created_date DESC";
    $category = $db->prepare($query);
    $category->bindParam(":id", $id, PDO::PARAM_INT);
    $result = $category->execute();
    // Check if category exists
    if (!$result) {
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}

// Fetch category title
$cat_query = 'SELECT * FROM artcitycategories WHERE id = ?';
$cat_stmt = $db->prepare($cat_query);
$cat_stmt->execute([$id]);
$category = $cat_stmt->fetch(PDO::FETCH_ASSOC);
$category_title = $category['title'];
?>

<header class="category_title">
    <h1><?= $category_title ?></h1>
</header>

<section class="posts">
    <div class="container post_container">
        <?php
        // Fetch regular posts
        $regular_posts_query = "SELECT * FROM artcityposts WHERE category_id=:category_id ORDER BY created_date DESC";
        $regular_posts_stmt = $db->prepare($regular_posts_query);
        $regular_posts_stmt->bindParam(":category_id", $id, PDO::PARAM_INT);
        $regular_posts_stmt->execute();
        $regular_posts = $regular_posts_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach ($regular_posts as $post) : ?>
            <article class="post">
                <?php if (isset($post['thumbnail'])) : ?>
                    <div class="post_thumbnail">
                        <img src="./uploads/<?= $post['thumbnail'] ?>" alt="Post Image" />
                    </div>
                <?php endif; ?>
                <div class="post_info">
                    <a href="post.php?id=<?= $post['id'] ?>">
                        <h2 class="post_title"><?= $post['title'] ?></h2>
                    </a>
                    <p class="post_content"><?= substr($post['content'], 0, 150) . '...' ?></p>
                </div>
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
                        <img src="logo/user.png" alt="Author Image" />
                    </div>
                    <div class="post_author_info">
                        <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                        <small><?= date("M d, Y - H:i", strtotime($post['created_date'])) ?></small>
                    </div>
                </div>
            </article>
            <br><br>
            <hr>
        <?php endforeach; ?>
    </div>
</section>



<section class="category_buttons">
    <div class="container category_buttons">
        <?php
        $categories_query = "SELECT * FROM artcitycategories ORDER BY title ASC";
        $categories_stmt = $db->query($categories_query);
        ?>

        <?php while ($cat = $categories_stmt->fetch(PDO::FETCH_ASSOC)) : ?>
            <a href="category-post.php?id=<?= $cat['id'] ?>"><?= $cat['title'] ?></a>
        <?php endwhile; ?>
    </div>
</section>