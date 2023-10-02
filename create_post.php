<?php
        session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>
<body>
    <h1>Create post page TEST</h1>

    <form action="create_post_p.php" method="POST">
        <label>Title:</label>
        <input type="text" id="title" name="title"><br><br>
        <label>Post:</label>
        <textarea id="body" name="body" placeholder="Type your post here..." rows="10" cols="50"></textarea><br><br>
        <label>Link (optional):</label>
        <input type="url" name="link"><br><br>
        <label>Category (Optional):</label>
        <input type="text" id="categories" name="categories"><br><br>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" value="Post">
    </form>
</body>
</html>
