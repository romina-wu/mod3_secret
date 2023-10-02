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
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    $post_id = $_POST['post_id'];
    $_SESSION["post_id"] = $post_id;

    require_once "config.php";
    $stmt = $con->prepare("select * from posts where post_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $con->error);
        exit;
    }
    $stmt->bind_param('i', $post_id);

    $stmt->execute();

    $stmt->bind_result($post_id, $username, $title, $body, $link, $categories);

    echo "<ul>\n";
    while($stmt->fetch()){
        ?>
        <form action="edit_processor.php" method="POST">
            <label>Title</label>
            <?php 
                echo "<input type='text' id='title' value='$title' name='new_title'></input><br><br>";
            ?>
            <label>Post:</label>
            <?php 
                echo "<textarea id='body' name='new_body' rows='10' cols='50'>$body</textarea><br><br>";
            ?>
            <label>Link (optional):</label>
            <?php 
                echo "<input type='url' name='new_link' value='$link'><br><br>";
            ?>
            <label>Category (Optional):</label>
            <?php
                echo "<input type='text' id='categories' value='$categories' name='new_categories'></input><br><br>";
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