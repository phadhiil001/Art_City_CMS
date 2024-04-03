<?php
include('header.php');

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
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add Category</h2>

            <?php if (isset($_SESSION['add-category'])) : ?>
                <div class="alert__message error">
                    <p><?= $_SESSION['add-category']; ?></p>
                </div>
                <?php unset($_SESSION['add-category']); ?>
            <?php elseif (isset($_SESSION['error'])) : ?>
                <div class="alert__message error">
                    <p><?= $_SESSION['error']; ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif ?>

            <form action="add-category-logic.php" method="post">
                <input type="text" name="title" placeholder="Title" value="<?= $title ?>">
                <textarea rows="4" type="text" name="description" placeholder="Description" value="<?= $description ?>"></textarea>


                <button type="submit" name="submit" class="btn">Add Category</button>

            </form>
        </div>
    </section>
</body>

</html>