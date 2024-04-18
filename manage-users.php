<?php
// Start session
include('header.php');

// Get current user ID
$current_user = $_SESSION['user_id'];

// Prepare and execute query to fetch users (excluding the current user)
$query = "SELECT * FROM artcityusers WHERE id != :current_user";
$users = $db->prepare($query);
$users->bindParam(':current_user', $current_user, PDO::PARAM_INT);
$users->execute();

// Check if there are no users
if ($users->rowCount() == 0) {
    $noUsersMessage = "No users found in the database.";
}

?>

<section class="dashboard">

    <?php if (isset($_SESSION['success'])) : // show if user was added successfully 
    ?>
        <div class="error-message">
            <p><?= $_SESSION['success']; ?></p>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php elseif (isset($_SESSION['error'])) : // show if there was an error with updating user
    ?>
        <div class="error-message">
            <p><?= $_SESSION['error']; ?></p>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php elseif (isset($_SESSION['registration'])) : // show if there was an error with updating user
    ?>
        <div class="error-message">
            <p><?= $_SESSION['registration']; ?></p>
        </div>
        <?php unset($_SESSION['registration']); ?>
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
                        <a href="manage-users.php" class="active"><i class="uil uil-users-alt"></i>
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
            <h2>Manage Users</h2>
            <?php if (isset($noUsersMessage)) : ?>
                <div class="error-message">
                    <p><?= $noUsersMessage; ?></p>
                </div>
            <?php else : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $users->fetch(PDO::FETCH_ASSOC)) : ?>
                            <tr>
                                <td><?= "{$row['firstname']} {$row['lastname']}" ?></td>
                                <td><?= $row['username']; ?></td>
                                <td><a href="edit-user.php?id=<?= $row['id'] ?>" class="btn sm">Edit</a></td>
                                <td><a href="delete-user.php?id=<?= $row['id'] ?>" class="btn sm danger">Delete</a></td>
                                <td><?= $row['is_admin'] ? 'Yes' : 'No'; ?></td>
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