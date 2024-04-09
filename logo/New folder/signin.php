<?php

session_start();
require('connect.php');
include('nav.php');

// Retrieve saved values from session
$username_email = $_SESSION['save']['username_email'] ?? null;
$password = $_SESSION['save']['password'] ?? null;

// Unset the saved values from session to prevent them from persisting after use
unset($_SESSION['save']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Sign In</title>
</head>

<body>
    <section class="form__section">
        <div class="container form__section-container">

            <h2>Sign In</h2>

            <?php if (isset($_SESSION['registration'])) : ?>
                <div class="alert__message success">
                    <p><?= $_SESSION['registration']; ?></p>
                </div>
                <?php unset($_SESSION['registration']); ?>

            <?php elseif (isset($_SESSION['error'])) : ?>
                <div class="alert__message success">
                    <p><?= $_SESSION['error']; ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif ?>


            <form action="signin-logic.php" method="post">
                <input type="text" id="userName" name="username_email" value="<?= htmlspecialchars($username_email) ?>" placeholder="User Name or Email">

                <input type="password" id="enterPassword" name="password" value="<?= htmlspecialchars($password) ?>" placeholder="Enter Password">


                <button type="submit" name="submit" class="btn">Sign In</button>
                <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
            </form>
        </div>
    </section>
</body>

</html>