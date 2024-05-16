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

<header class="category__title">
    <h2><?= $category_title ?></h2>
</header>

<section class="posts">
    <div class="container posts__container">
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
                    <div class="post__thumbnail">
                        <img src="./uploads/<?= $post['thumbnail'] ?>" alt="Post Image" />
                    </div>
                <?php endif; ?>
                <div class="post__info">
                    <h3 class="post__title">
                        <a href="post.php?id=<?= $post['id'] ?>" class="category__button"><?= $post['title'] ?></a>
                    </h3>

                    <p class="post__body"><?= substr($post['content'], 0, 150) . '...' ?></p>

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
                            <img src="logo/user.png" alt="Author Image" />
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <small><?= date("M d, Y - H:i", strtotime($post['created_date'])) ?></small>
                        </div>
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


<footer>
    <div class="footer__socials">
        <a href="https://youtube.com" target="_blank"><i class="uil uil-youtube"></i></a>
        <a href="https://facebook.com" target="_blank"><i class="uil uil-facebook-f"></i></a>
        <a href="https://instagram.com" target="_blank"><i class="uil uil-instagram-alt"></i></a>
        <a href="https://linkedin.com" target="_blank"><i class="uil uil-linkedin"></i></a>
        <a href="https://twitter.com" target="_blank"><i class="uil uil-twitter"></i></a>
    </div>
    <div class="footer__copyright">
        <small>Copyright &copy; Fadlullah</small>
    </div>
</footer>

<script src="/js/main.js"></script>