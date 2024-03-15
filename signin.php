<?php

session_start();
require('config/db_connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
</head>

<body>
    <section>
        <div>
            <h2>Sign In</h2>
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="error-message">
                    <p><?= $_SESSION['error']; ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif ?>
            
            <form action="" enctype="multipart/form-data">
                <input type="text" id="userName" placeholder="User Name">
                <span class="error-message">
                    <!-- <p>Please enter your username</p> -->
                </span>
                <input type="password" id="enterPassword" placeholder="Enter Password">
                <span class="error-message">
                    <!-- <p>Incorrect Password</p> -->
                </span>

                <button type="submit">Sign In</button>
                <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
            </form>
        </div>
    </section>
</body>

</html>