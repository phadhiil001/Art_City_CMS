<?php
include('header.php');


if (isset($_POST['submit'])) {
    //  Get the data from form
    $username_email = filter_input(INPUT_POST, 'username_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username_email) {
        $_SESSION['error'] = "Username or Email required";
        $_SESSION['save'] = $_POST; // Save form data to session
        header('Location: signin.php');
        exit();
    } elseif (!$password) {
        $_SESSION['error'] = "Password is required.";
        $_SESSION['save'] = $_POST;
        header('Location: signin.php?err=pass');
    } else {
        // Check user credentials in database
        $query_check = "SELECT * FROM artcityusers  WHERE username= :username_email OR email= :username_email";
        $stmt = $db->prepare($query_check);

        // Bind parameters
        $stmt->bindParam(':username_email', $username_email);

        // Execute the query
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // User found, verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct and access control
                $_SESSION['user_id'] = $user['id'];
                // Set session if user is an admin 
                if ($user['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }
                $_SESSION['username'] = $user['username'];
                $_SESSION['success'] = "Welcome $username_email.";
                header('Location: dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = "Invalid password";
                $_SESSION['save'] = $_POST;
                header('Location: signin.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "User not found";
            $_SESSION['save'] = $_POST;
            header('Location: signin.php');
            exit();
        }
    }
} else {
    header('Location: signin.php');
    exit();
}
