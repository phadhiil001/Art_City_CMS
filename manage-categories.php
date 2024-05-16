<?php
// Start session
include('header.php');

// Prepare and execute query to fetch categories ordered by title
$query = "SELECT * FROM artcitycategories ORDER BY title ASC";
$categories = $db->query($query);

// Check if there are no categories
if ($categories->rowCount() == 0) {
    $noCategoryMessage = "No categories found in the database.";
}
?>

<section class="dashboard">
    <?php if (isset($_SESSION['success'])) : // show success update 
    ?>
        <div class="error-message">
            <p><?= $_SESSION['success']; ?></p>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php elseif (isset($_SESSION['add-category'])) : // show error, if any
    ?>
        <div class="error-message">
            <p><?= $_SESSION['add-category']; ?></p>
        </div>
        <?php unset($_SESSION['add-category']); ?>
    <?php elseif (isset($_SESSION['error'])) :
    ?>
        <div class="error-message">
            <p><?= $_SESSION['error']; ?></p>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif ?>
    <div class="container dashboard__container">
        <aside>
            <ul>
                <li>
                    <a href="new-post.php"><i class="uil uil-pen"></i>
                        <h5>Add New Post</h5>
                    </a>
                </li>
                <li>
                    <a href="dashboard.php"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_is_admin'])) : ?>
                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-users.php"><i class="uil uil-users-alt"></i>
                            <h5>Manage User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-edit"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-categories.php" class="active"><i class="uil uil-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Categories</h2>
            <?php if (isset($noCategoryMessage)) : ?>
                <div class="error-message">
                    <p><?= $noCategoryMessage; ?></p>
                </div>
            <?php else : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $categories->fetch(PDO::FETCH_ASSOC)) : ?>
                            <tr>
                                <td><?= $row['title']; ?></td>
                                <td><a href="edit-category.php?id=<?= $row['id'] ?>" class="btn sm">Edit</a></td>
                                <td><a href="delete-category.php?id=<?= $row['id'] ?>" class="btn sm danger">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
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