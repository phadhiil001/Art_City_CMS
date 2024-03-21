<?php
session_start();
require('connect.php'); // Database connection
include('nav.php');

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the sign-in page or any other appropriate page
    header('Location: signin.php');
    exit;
}

// Retrieve saved values from session
$firstname = $_SESSION['save']['firstName'] ?? null;
$lastname = $_SESSION['save']['lastName'] ?? null;
$username = $_SESSION['save']['userName'] ?? null;
$email = $_SESSION['save']['email'] ?? null;
$createpassword = $_SESSION['save']['createPassword'] ?? null;
$confirmpassword = $_SESSION['save']['confirmPassword'] ?? null;

// Unset the saved values from session to prevent them from persisting after use
unset($_SESSION['save']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
</head>

<body>
    <section>
        <div>
            <h2>Add a user</h2>

            <?php if (isset($_SESSION['add-user'])) : ?>
                <div class="error-message">
                    <p><?= $_SESSION['add-user']; ?></p>
                </div>
                <?php unset($_SESSION['add-user']); ?>
            <?php endif ?>

            <form action="adduser-logic.php" method="post">
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" placeholder="First Name" value="<?= $firstname ?>">
                <br>
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" placeholder="Last Name" value="<?= $lastname ?>">
                <br>
                <label for="userName">Username:</label>
                <input type="text" name="userName" placeholder="User Name" value="<?= $username ?>">
                <br>
                <label for="emailInput">Email Address:</label>
                <input type="text" name="email" placeholder="Email Address" value="<?= $email ?>">
                <br>
                <label for="createPassword">Create Password</label>
                <input type="password" name="createPassword" placeholder="Create Password" value="<?= $createpassword ?>">
                <br>
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" name="confirmPassword" placeholder="Confirm Password" value="<?= $confirmpassword ?>">

                <select name="userrole">
                    <option value="0">Artist</option>
                    <option value="1">Admin</option>
                </select>

                <button type="submit" name="submit">Add User</button>

            </form>
        </div>
    </section>
</body>

</html>