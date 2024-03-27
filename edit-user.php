<?php
include('header.php');



// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the sign-in page or any other appropriate page
    header('Location: signin.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    // Fetch user details from the database based on the provided ID
    $query = "SELECT * FROM artcityusers WHERE id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        // Handle case where user with provided ID does not exist
        header('Location: manage-users.php');
        exit();
    }
    // Assign user details to variables for use in the form
    $firstname = $user['firstname'];
    $lastname = $user['lastname'];
    $is_admin = $user['is_admin']; // Fetch is_admin field from the database
} else {
    // Redirect to manage-users.php if 'id' parameter is missing
    header('Location: manage-users.php');
    exit();
}
?>

<section class="form section">
    <div class="container form section-container">
        <h2>Edit User</h2>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error-message">
                <p><?= $_SESSION['error']; ?></p>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif ?>

        <form action="edit-user-logic.php" method="post">
            <input type="text" value="<?= htmlspecialchars($firstname) ?>" name="firstname" placeholder="First Name">
            <input type="text" value="<?= htmlspecialchars($lastname) ?>" name="lastname" placeholder="Last Name">

            <select name="userrole">
                <option value="0" <?php echo $is_admin == 0 ? 'selected' : ''; ?>>Artist</option>
                <option value="1" <?php echo $is_admin == 1 ? 'selected' : ''; ?>>Admin</option>
            </select>
            <input type="hidden" name="user_id" value="<?= $id ?>">
            <button type="submit" name="submit">Update User</button>
        </form>
    </div>
</section>