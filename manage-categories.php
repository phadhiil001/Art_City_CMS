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
                        <a href="manage-categories.php" class="active">
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
                                <td><a href="edit-category.php?id=<?= $row['id'] ?>">Edit</a></td>
                                <td><a href="delete-category.php?id=<?= $row['id'] ?>">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
    </div>
</section>