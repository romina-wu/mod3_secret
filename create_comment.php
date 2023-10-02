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
    <h1>Create Comment Page</h1>

    <form action="create_comment_p.php" method="POST">
        <label>Comment:</label>
        <textarea id="body" name="body" placeholder="Type your post here..." rows="10" cols="50"></textarea><br>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" value="Post">
    </form>
</body>
</html>
 