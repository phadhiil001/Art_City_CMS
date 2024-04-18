<?php
session_start();
require('connect.php');
include('nav.php');

// Fetch 9 regular posts from the database
$query_regular = 'SELECT * FROM artcityposts WHERE is_featured = 0 ORDER BY created_date DESC';
$regular_posts =  $db->query($query_regular)->fetchAll(PDO::FETCH_ASSOC);
?>



<section class="search__bar">
    <form class="container search__bar-container" action="search.php" method="GET">
        <div>
            <i class="uil uil-search"></i>
            <input type="search" name="q" placeholder="Search">
        </div>
        <button type="submit" class="btn">Go</button>
    </form>
</section>




<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
        $categories_query = "SELECT * FROM artcitycategories ORDER BY title ASC";
        $categories_stmt = $db->query($categories_query);
        ?>

        <h1>All Categories</h1>
        <?php while ($cat = $categories_stmt->fetch(PDO::FETCH_ASSOC)) : ?>
            <a href="category-post.php?id=<?= $cat['id'] ?>" class="category__button"><?= $cat['title'] ?></a>
        <?php endwhile; ?>
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





<footer>
    <div class="footer__socials">
        <a href="https://youtube.com/" target="_blank"><i class="uil uil-youtube"></i></a>
        <a href="https://facebook.com" target="_blank"><i class="uil uil-facebook-f"></i></a>
        <a href="https://instagram.com" target="_blank"><i class="uil uil-instagram-alt"></i></a>
        <a href="https://linkedin.com" target="_blank"><i class="uil uil-linkedin"></i></a>
        <a href="https://twitter.com" target="_blank"><i class="uil uil-twitter"></i></a>
    </div>
    <div class="footer__copyright">
        <small>Copyright &copy; Fadlullah</small>
    </div>
</footer>