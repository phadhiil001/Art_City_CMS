<?php

session_start();
require('connect.php');
include('nav.php');

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the sign-in page or any other appropriate page
    header('Location: signin.php');
    exit;
}

?>

<section class="dashboard">
    <?php if (isset($_SESSION['success'])) : // show success update 
    ?>
        <div class="error-message">
            <p><?= $_SESSION['success']; ?></p>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php elseif (isset($_SESSION['error'])) : // show error, if any
    ?>
        <div class="error-message">
            <p><?= $_SESSION['error']; ?></p>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif ?>
    <div class="dashboard-container">
        <aside>
            <ul>
                <li>
                    <a href="new-post.php">
                        <h5>Add New Post</h5>
                    </a>
                </li>
                <li>
                    <a href="manage-posts.php">
                        <h5>Manage Post</h5>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_is_admin'])) : ?>
                    <li>
                        <a href="add-user.php">
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-users.php">
                            <h5>Manage Users</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php">
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-categories.php">
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Posts</h2>
            <table>
                <thead>
                    <tr>Title</tr>
                    <tr>Edit</tr>
                    <tr>Delete</tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </main>
    </div>
</section>