<?php
include('header.php');

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
    <section class="form__section">
        <div class="container form__section-container">
            <button class="btn"><a href="manage-users.php">Back</a></button>
            <h2>Add User</h2>

            <?php if (isset($_SESSION['add-user'])) : ?>
                <div class="alert__message error">
                    <p><?= $_SESSION['add-user']; ?></p>
                </div>
                <?php unset($_SESSION['add-user']); ?>
            <?php endif ?>
            <form action="adduser-logic.php" method="post">
                <input type="text" name="firstName" placeholder="First Name" value="<?= $firstname ?>">
                <input type="text" name="lastName" placeholder="Last Name" value="<?= $lastname ?>">
                <input type="text" name="userName" placeholder="User Name" value="<?= $username ?>">
                <input type="text" name="email" placeholder="Email Address" value="<?= $email ?>">
                <input type="password" name="createPassword" placeholder="Create Password" value="<?= $createpassword ?>">
                <input type="password" name="confirmPassword" placeholder="Confirm Password" value="<?= $confirmpassword ?>">

                <select name="userrole">
                    <option value="0">Artist</option>
                    <option value="1">Admin</option>
                </select>

                <button type="submit" name="submit" class="btn">Add User</button>

            </form>
        </div>
    </section>
</body>

</html>