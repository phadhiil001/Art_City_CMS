<?php
session_start();
require('connect.php'); // Assuming this file contains the database connection

if (isset($_POST['submit'])) {
    // Validate and sanitize form data
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Check if required fields are not empty
    if (empty($name) || empty($email) || empty($content)) {
        $_SESSION['error'] = "Please fill out all the required fields.";
        $_SESSION['save'] = $_POST;
        header("Location: contact.php");
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: contact.php");
        exit;
    }

    // Insert data into the database
    $query = "INSERT INTO artcitycontact (name, email, content) VALUES (:name, :email, :content)";
    // $stmt = $db->prepare($sql);

    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['success'] = "Your message has been stored successfully. We will get back to you soon!";
    } else {
        $_SESSION['error'] = "Oops! Something went wrong. Please try again later.";
    }

    header("Location: contact.php");
    exit;
}
?>


<?php
include('nav.php');
?>

<header class="category__title">
    <h2>Contact Us</h2>
</header>

<main>


    <section class="form_section">
        <div class="container form__section-container">
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="alert__message success">
                    <p><?= $_SESSION['success']; ?></p>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php elseif (isset($_SESSION['error'])) : ?>
                <div class="alert__message error">
                    <p><?= $_SESSION['error']; ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <h3>Have a question or feedback? We'd love to hear from you!</h3>
            <h4>Please feel free to reach out to us using the form below or via email.</h4><br>

            <form action="contact.php" method="post">
                <input type="text" id="name" name="name" placeholder="Your Name">
                <input type="email" id="email" name="email" placeholder="Your Email Address">
                <textarea id="message" name="content" placeholder="Your Message"></textarea>
                <button type="submit" name="submit" class="btn">Send Message</button>
            </form>
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