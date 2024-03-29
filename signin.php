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
    <section class="sign_in">
        <div class="signin-container">

            <div class="sign_in_head">
                <h2>Create an account</h2>
                <h4>Enter your email to sign up for this app</h4>
            </div>

            <?php if (isset($_SESSION['registration'])) : ?>
                <div class="error-message">
                    <p><?= $_SESSION['registration']; ?></p>
                </div>
                <?php unset($_SESSION['registration']); ?>

            <?php elseif (isset($_SESSION['error'])) : ?>
                <div class="error-message">
                    <p><?= $_SESSION['error']; ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif ?>


            <form action="signin-logic.php" method="post" class="sign_in_form">
                <input type="text" id="userName" name="username_email" value="<?= htmlspecialchars($username_email) ?>" placeholder="User Name or Email">

                <input type="password" id="enterPassword" name="password" value="<?= htmlspecialchars($password) ?>" placeholder="Enter Password">


                <button type="submit" name="submit">Sign In</button>
                <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
            </form>
        </div>
    </section>
</body>

</html>