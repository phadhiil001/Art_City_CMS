<?php
session_start();
require('connect.php');
include('nav.php');
?>

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