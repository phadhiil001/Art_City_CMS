<?php
session_start();
require('connect.php');
include('nav.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css?v=<?php echo time(); ?>">
    <title>Categories</title>
</head>

<body>

    <header class="category__title">
        <h2>About Us</h2>
    </header>

    <main>
        <section class="singlepost">
            <div class="container singlepost__container">

                <p>Welcome to Art City Inc.! We are a passionate community of artists dedicated to promoting creativity and artistic expression.</p>
                <p>Our mission is to provide a platform for artists of all backgrounds to showcase their work, connect with fellow creatives, and inspire others through their art.</p>
                <p>Join us on our journey as we explore the vibrant world of art and culture.</p>
            </div>
        </section>
    </main>

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

    <script src="main.js"></script>

</body>

</html>