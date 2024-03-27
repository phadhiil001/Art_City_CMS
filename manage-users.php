<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the signin page
    header('Location: signin.php');
    exit();
}

// Get current user ID
$current_user = $_SESSION['user_id'];

// Establish database connection
require('connect.php');
include('nav.php');

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the sign-in page or any other appropriate page
    header('Location: signin.php');
    exit;
}

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
                                <td><a href="edit-user.php?id=<?= $row['id'] ?>">Edit</a></td>
                                <td><a href="delete-user.php?id=<?= $row['id'] ?>">Delete</a></td>
                                <td><?= $row['is_admin'] ? 'Yes' : 'No'; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
    </div>
</section>