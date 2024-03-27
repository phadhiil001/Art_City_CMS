<?php

include('header.php');

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the sign-in page or any other appropriate page
    header('Location: signin.php');
    exit;
}

$title = $_SESSION['add-category-data']['title'] ?? null;
$description = $_SESSION['add-category-data']['description'] ?? null;

unset($_SESSION['save']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
</head>

<body>
    <section>
        <div>
            <h2>Add Category</h2>
            <?php if (isset($_SESSION['add-category'])) : ?>
                <div class="error-message">
                    <p><?= $_SESSION['add-category']; ?></p>
                </div>
                <?php unset($_SESSION['add-category']); ?>
            <?php elseif (isset($_SESSION['error'])) : ?>
                <div class="error-message">
                    <p><?= $_SESSION['error']; ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif ?>

            <form action="add-category-logic.php" method="post">
                <label for="title">Add a Title</label>
                <input type="text" id="title" name="title" placeholder="Title" value="<?= $title ?>">

                <label for="description">Description:</label>
                <input type="text" id="description" name="description" placeholder="Description" value="<?= $description ?>">


                <button type="submit" name="submit">Add Category</button>

            </form>
        </div>
    </section>
</body>

</html>