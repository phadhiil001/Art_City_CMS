<?php
session_start();
require('connect.php');

include('nav.php');

if (isset($_GET['q'])) {
    $search_query = '%' . $_GET['q'] . '%';

    // Search for pages that include the provided word or phrase
    $query = "SELECT * FROM artcityposts WHERE title LIKE ? OR content LIKE ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$search_query, $search_query]);
    $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>



<?php if (isset($search_results) && count($search_results) > 0) : ?>
    <section class="posts section__extra-margin">
        <div class="container posts__container">
            <?php foreach ($search_results as $post) : ?>
                <article class="post">
                    <?php if (isset($post['thumbnail'])) : ?>
                        <div class="post__thumbnail">
                            <img src="./uploads/<?= $post['thumbnail'] ?>" alt="Post Image" />
                        </div>
                    <?php endif; ?>
                    <div class="post__info">
                        <?php
                        // fetch category from categories table using category_id of post
                        $category_id = $post['category_id'];
                        $category_query = "SELECT * FROM artcitycategories WHERE id=:category_id";
                        $category_stmt = $db->prepare($category_query);
                        $category_stmt->execute(array(':category_id' => $category_id));
                        $category = $category_stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <a href="category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
                        <h3 class="post__title">
                            <a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                        </h3>
                        <p class="post__body"><?= substr($post['content'], 0, 150) . '...' ?></p>
                        <div class="post__author">
                            <?php
                            // fetch author from users table using author_id
                            $author_id = $post['author_id'];
                            $author_query = "SELECT * FROM artcityusers WHERE id=:author_id";
                            $author_stmt = $db->prepare($author_query);
                            $author_stmt->execute(array(':author_id' => $author_id));
                            $author = $author_stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div class="post__author-avatar">
                                <img src="logo/user.png" alt="<?= $author['username'] ?>">
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
<?php else : ?>
    <div class="alert__message error lg section__extra-margin">
        <p>No posts found for this search</p>
    </div>
<?php endif ?>
<!--====================== END OF POSTS ====================-->

<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
        $all_categories_query = "SELECT * FROM artcitycategories";
        $all_categories = $db->query($all_categories_query);
        ?>
        <?php while ($category = $all_categories->fetch(PDO::FETCH_ASSOC)) : ?>
            <a href="category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
        <?php endwhile ?>
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