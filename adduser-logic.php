<?php
include('header.php');

if (isset($_POST['submit'])) {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $firstname = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $createpassword = filter_input(INPUT_POST, 'createPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_input(INPUT_POST, 'userrole', FILTER_SANITIZE_NUMBER_INT);



    // Validate input
    if (!$firstname) {
        $_SESSION['add-user'] = "Please enter your first name.";
        $_SESSION['save'] = $_POST; // Save form data to session
        header('Location: add-user.php');
        exit();
    } elseif (!$lastname || strlen($lastname) < 2) {
        $_SESSION['add-user'] = "Please enter a valid last name.";
        $_SESSION['save'] = $_POST; // Save form data to session
        header('Location: add-user.php');
        exit();
    } elseif ($username == "") {
        $_SESSION['add-user'] = "Enter a Username";
        $_SESSION['save'] = $_POST; // Save form data to session
        header('Location: add-user.php');
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $_SESSION['add-user'] = "Username can only contain letters and numbers.";
        $_SESSION['save'] = $_POST; // Save form data to session
        header('Location: add-user.php');
        exit();
    } elseif (!$email) {
        $_SESSION['add-user'] = "Email is invalid.";
        $_SESSION['save'] = $_POST; // Save form data to session
        header('Location: add-user.php');
        exit();
    } else if (strlen($createpassword) < 8) {
        $_SESSION['add-user'] = "Password is too short. It must be at least 8 characters long.";
        $_SESSION['save'] = $_POST; // Save form data to session
        header('Location: add-user.php');
        exit();
    } else {
        // Check that passwords match
        if ($createpassword !== $confirmpassword) {
            $_SESSION['add-user'] = "Passwords Mismatch";
            $_SESSION['save'] = $_POST; // Save form data to session
            header('Location: add-user.php');
            exit();
        } else {
            $hashed_password  = password_hash($createpassword, PASSWORD_DEFAULT);
        }

        // Adding user to database and checking for error

        // Prepare the SQL statement
        $query_check = "SELECT * FROM artcityusers WHERE username=? OR email=?";
        $stmt = $db->prepare($query_check);

        // Bind parameters
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $email);

        // Execute the query
        $stmt->execute();

        // Check if username or email already exist in the database
        if ($stmt->rowCount() > 0) {
            // Loop through the results
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($username === $row["username"]) {
                    $_SESSION['add-user'] = "Username already taken.";
                } elseif ($email === $row["email"]) {
                    $_SESSION['add-user'] = "Email address already registered.";
                }
            }
        }

        // If no errors have been set yet then add the user to the database
        if (isset($_SESSION['add-user'])) {
            $_SESSION['save'] = $_POST; // Save form data to session
            header('Location: add-user.php');
            exit();
        } else {
            // Create a new record in the database 
            $query_insert =  "INSERT INTO artcityusers (firstname, lastname, username, email, password, is_admin) VALUES (:firstname, :lastname, :username, :email, :hashed_password, :is_admin)";
            $user_insert = $db->prepare($query_insert);

            // Bind the  parameter to the place holder in the template 
            $user_insert->bindValue(':firstname', $firstname);
            $user_insert->bindValue(':lastname', $lastname);
            $user_insert->bindValue(':username', $username);
            $user_insert->bindValue(':email', $email);
            $user_insert->bindValue(':hashed_password', $hashed_password);
            $user_insert->bindValue(':is_admin', $is_admin);

            // Execute the INSERT 
            if ($user_insert->execute()) {
                // Redirect the user to the login page after successful registration and destroy the session
                $_SESSION['registration'] = "New user $firstname $lastname added successfully";
                header('Location: manage-users.php');
                exit();
            } else {
                $_SESSION['add-user'] = "Unable to register user, please try again later.";
                $_SESSION['save'] = $_POST; // Save form data to session
                header('Location: add-user.php');
                exit();
            }
        }
    }
} else {
    header('Location: add-user.php');
    exit();
}
