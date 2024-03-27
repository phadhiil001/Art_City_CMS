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

// fetch posts of current user along with category name
$current_user = $_SESSION['user_id'];
$query = "SELECT p.id, p.title, c.title AS category_title 
          FROM artcityposts p 
          JOIN artcitycategories c ON p.category_id = c.id 
          WHERE p.author_id = :current_user 
          ORDER BY p.id DESC";

$post = $db->prepare($query);
$post->bindParam(":current_user", $current_user, PDO::PARAM_INT);
$result = $post->execute();

// Check if there are any posts
if ($result && $post->rowCount() > 0) {
    $posts = $post->fetchAll(PDO::FETCH_ASSOC);
} else {
    $no_post_message = "No posts found.";
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
                    <a href="dashboard.php">
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
            <?php if (isset($no_post_message)) : ?>
                <div class="error-message">
                    <p><?= $no_post_message; ?></p>
                </div>
            <?php else : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post) : ?>
                            <tr>
                                <td><?= $post['title']; ?></td>
                                <td><?= $post['category_title']; ?></td>
                                <td><a href="edit-post.php?id=<?= $post['id'] ?>">Edit</a></td>
                                <td><a href="delete-post.php?id=<?= $post['id'] ?>">Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
    </div>
</section>