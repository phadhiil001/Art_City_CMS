<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
</head>

<body>
    <section>
        <div>
            <h2>New Post</h2>

            <form class="edit-form" method="post" action="new_post.php">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="Add a Title">

                <label for="content">Content</label>
                <input type="text" id="content" name="content" placeholder="Add Content">


                <button type="submit" name="submit">Add Post</button>

            </form>
        </div>
    </section>
</body>

</html>