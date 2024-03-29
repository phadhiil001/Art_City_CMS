<link rel="stylesheet" href="style.css">

<nav>
    <div class="nav__container">
        <a href="index.php"><img src="logo/logo-transparent-png.png" alt="Art City Logo" class="logo"></a>
        <ul class="nav_items">
            <li><a href="index.php">Home</a></li>
            <li><a href="events.php">Events</a></li>
            <li><a href="workshops.php">Workshops</a></li>
            <li><a href="artists.php">Artists</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <li class="nav_profile">
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