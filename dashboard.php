<?php
include('header.php');

// Check if the user is an admin or logged-in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

// Fetch all posts along with category name
$query_all_posts = "SELECT p.id, p.title, p.created_date, c.title AS category_title 
                    FROM artcityposts p 
                    JOIN artcitycategories c ON p.category_id = c.id";

// Add sorting logic based on the selected criteria
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'created_date'; // Default sorting by created_date
$sort_direction = isset($_GET['dir']) && $_GET['dir'] === 'acs' ? 'ASC' : 'DESC'; // Default sorting direction
$valid_sort_columns = ['title', 'created_date', 'category_title'];
if (in_array($sort_by, $valid_sort_columns)) {
    $query_all_posts .= " ORDER BY $sort_by $sort_direction";
}

$all_posts_stmt = $db->query($query_all_posts);
$all_posts = $all_posts_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch posts of the current user
$current_user = $_SESSION['user_id'];
$query_user_posts = "SELECT p.id, p.title, p.created_date, c.title AS category_title 
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
    <link rel="stylesheet" href="main.css?v=<?php echo time(); ?>">
    <title>Dashboard</title>
</head>

<body>


    <section class="dashboard">
        <?php if (isset($_SESSION['success'])) : // show success update 
        ?>
            <div class="alert__message success">
                <p><?= $_SESSION['success']; ?></p>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php elseif (isset($_SESSION['error'])) : // show error, if any 
        ?>
            <div class="alert__message error">
                <p><?= $_SESSION['error']; ?></p>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif ?>


        <div class="container dashboard__container">
            <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
            <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>

            <aside>
                <ul>
                    <li>
                        <a href="new-post.php"><i class="uil uil-pen"></i>
                            <h5>Add New Post</h5>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard.php" class="active"><i class="uil uil-postcard"></i>
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
                            <a href="manage-categories.php"><i class="uil uil-list-ul"></i>
                                <h5>Manage Categories</h5>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </aside>
            <main>
                <h2>Manage Posts</h2>
                <h4>Sort by:
                    <a href="?sort=title&dir=<?php echo ($sort_by === 'title' && $sort_direction === 'ASC') ? 'desc' : 'asc'; ?>" <?php if ($sort_by === 'title') echo 'class="active"'; ?>>
                        Title <?php if ($sort_by === 'title') echo ($sort_direction === 'ASC') ? '&#9650;' : '&#9660;'; ?>
                    </a> |
                    <a href="?sort=created_date&dir=<?php echo ($sort_by === 'created_date' && $sort_direction === 'ASC') ? 'desc' : 'asc'; ?>" <?php if ($sort_by === 'created_date') echo 'class="active"'; ?>>
                        Created Date <?php if ($sort_by === 'created_date') echo ($sort_direction === 'ASC') ? '&#9650;' : '&#9660;'; ?>
                    </a> |
                    <a href="?sort=category_title&dir=<?php echo ($sort_by === 'category_title' && $sort_direction === 'ASC') ? 'desc' : 'asc'; ?>" <?php if ($sort_by === 'category_title') echo 'class="active"'; ?>>
                        Category <?php if ($sort_by === 'category_title') echo ($sort_direction === 'ASC') ? '&#9650;' : '&#9660;'; ?>
                    </a>
                </h4><br>



                <?php if (isset($no_post_message)) : ?>
                    <div class="alert__message error">
                        <p><?= $no_post_message; ?></p>
                    </div>
                <?php else : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Created Date</th>
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
                                        <td><?= $post['created_date']; ?></td>
                                        <td><?= $post['category_title']; ?></td>
                                        <td><a href="edit-post.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                                        <td><a href="delete-post.php?id=<?= $post['id'] ?>" class="btn sm danger">Delete</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <!-- Display posts of the current user (artist) -->
                                <?php foreach ($user_posts as $post) : ?>
                                    <tr>
                                        <td><?= $post['title']; ?></td>
                                        <td><?= $post['created_date']; ?></td>
                                        <td><?= $post['category_title']; ?></td>
                                        <td><a href="edit-post.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                                        <td><a href="delete-post.php?id=<?= $post['id'] ?>" class="btn sm danger">Delete</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
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

    <script src="main.js"></script>

</body>

</html>