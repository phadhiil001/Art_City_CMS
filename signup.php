<?php
session_start();
require('connect.php');
include('nav.php');

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
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>SignUp</title>
</head>

<body>
    <section class="sign_up">
        <div class="signup-container">
            <h2 class="sign_in_head">Sign Up</h2>
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="error-message">
                    <p><?= $_SESSION['error']; ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif ?>

            <form action="signup-logic.php" method="post" class="sign_in_form">
                <input type="text" name="firstName" placeholder="First Name" value="<?= htmlspecialchars($firstname) ?>">

                <input type="text" name="lastName" placeholder="Last Name" value="<?= htmlspecialchars($lastname) ?>">

                <input type="text" name="userName" placeholder="User Name" value="<?= htmlspecialchars($username) ?>">

                <input type="text" name="email" placeholder="Email Address" value="<?= htmlspecialchars($email) ?>">

                <input type="password" name="createPassword" placeholder="Create Password" value="<?= htmlspecialchars($createpassword) ?>">

                <input type="password" name="confirmPassword" placeholder="Confirm Password" value="<?= htmlspecialchars($confirmpassword) ?>">

                <button type="submit" name="submit">Sign Up</button>
                <small>Already have an account? <a href="signin.php">Sign In</a></small>
            </form>
        </div>
    </section>
</body>

</html>