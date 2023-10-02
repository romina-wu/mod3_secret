<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
</head>
<body>
    <a href="registered_home.php">Back to home</a>
<?php
    session_start();

    $comment_id = $_POST['comment_id'];
    $_SESSION["comment_id"] = $comment_id;

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    require_once "config.php";
    $stmt = $con->prepare("select * from comments where comment_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $con->error);
        exit;
    }
    $stmt->bind_param('i', $comment_id);

    $stmt->execute();

    $stmt->bind_result($comment_id, $username, $post_id, $comment);

    echo "<ul>\n";
    while($stmt->fetch()){
        ?>
        <form action="edit_comment_p.php" method="GET">
            <label>Comment:</label>
            <?php 
                echo "<textarea id='body' name='new_body' rows='10' cols='50'>$comment</textarea><br>";
            ?>
            <input type="submit" value="Edit">
        </form>
        <?php
    } 

    echo "</ul>\n";

    $stmt->close();
?>
</body>
</html>