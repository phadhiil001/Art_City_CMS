<link rel="stylesheet" href="main.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">




<nav>
    <div class="container nav__container">
        <a href="index.php" class="nav__logo">Art City Inc.</a>
        <ul class="nav__items">
            <li><a href="index.php">Home</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="logo/user.png" alt="">
                    </div>
                    <ul>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="logout.php">Log out</a></li>
                    </ul>
                </li>
            <?php else : ?>
                <li>
                    <a href="signin.php">Sign in |</a>
                    <a href="signup.php">| Sign up</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>