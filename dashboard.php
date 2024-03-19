<?php

session_start();
require('config/db_connect.php');

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
                    <a href="manage-post.php">
                        <h5>Manage Post</h5>
                    </a>
                </li>
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
            </ul>
        </aside>
        <main>
            <h2>Manage Categories</h2>
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