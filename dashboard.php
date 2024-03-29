<?php
include('header.php');

// Check if the user is an admin
if (!isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin'] !== true) {
    // Redirect to the dashboard or show an error message
    header("Location: dashboard.php");
    exit; // Make sure to exit after a redirect to prevent further execution
}

// Fetch all posts along with category name for admin
$query_all_posts = "SELECT p.id, p.title, c.title AS category_title 
                    FROM artcityposts p 
                    JOIN artcitycategories c ON p.category_id = c.id 
                    ORDER BY p.id DESC";
$all_posts_stmt = $db->query($query_all_posts);
$all_posts = $all_posts_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch posts of current user along with category name for artist
$current_user = $_SESSION['user_id'];
$query_user_posts = "SELECT p.id, p.title, c.title AS category_title 
                     FROM artcityposts p 
                     JOIN artcitycategories c ON p.category_id = c.id 
                     WHERE p.author_id = :current_user 
                     ORDER BY p.id DESC";
$user_posts_stmt = $db->prepare($query_user_posts);
$user_posts_stmt->bindParam(":current_user", $current_user, PDO::PARAM_INT);
$user_posts_result = $user_posts_stmt->execute();

// Check if there are any posts for the current user
if ($user_posts_result && $user_posts_stmt->rowCount() > 0) {
    $user_posts = $user_posts_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $no_post_message = "No posts found.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>

<body>


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
                            <h5>
                                <img src="logo/pen.png" alt="">
                                Add New Post
                            </h5>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard.php">

                            <h5>
                                <img src="logo/manage-post.png" alt="">
                                Manage Post
                            </h5>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_is_admin'])) : ?>
                        <li>
                            <a href="add-user.php">
                                <h5>
                                    <img src="logo/add-user.png" alt="">
                                    Add User
                                </h5>
                            </a>
                        </li>
                        <li>
                            <a href="manage-users.php">
                                <h5>
                                    <img src="logo/manage-user.png" alt="">
                                    Manage Users
                                </h5>
                            </a>
                        </li>
                        <li>
                            <a href="add-category.php">
                                <h5>
                                    <img src="logo/add-category.png" alt="">
                                    Add Category
                                </h5>
                            </a>
                        </li>
                        <li>
                            <a href="manage-categories.php">
                                <h5>
                                    <img src="logo/manage-category.png" alt="">
                                    Manage Categories
                                </h5>
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
                            <?php if (isset($_SESSION['user_is_admin'])) : ?>
                                <!-- Display all posts for admin -->
                                <?php foreach ($all_posts as $post) : ?>
                                    <tr>
                                        <td><?= $post['title']; ?></td>
                                        <td><?= $post['category_title']; ?></td>
                                        <td><a href="edit-post.php?id=<?= $post['id'] ?>">Edit</a></td>
                                        <td><a href="delete-post.php?id=<?= $post['id'] ?>">Delete</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <!-- Display posts of the current user (artist) -->
                                <?php foreach ($user_posts as $post) : ?>
                                    <tr>
                                        <td><?= $post['title']; ?></td>
                                        <td><?= $post['category_title']; ?></td>
                                        <td><a href="edit-post.php?id=<?= $post['id'] ?>">Edit</a></td>
                                        <td><a href="delete-post.php?id=<?= $post['id'] ?>">Delete</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </main>
        </div>
    </section>


</body>

</html>