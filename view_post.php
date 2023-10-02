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

    $post_id = $_GET['post_id'];
    $_SESSION["post_id"] = $post_id;

    require_once "config.php";
    $stmt = $con->prepare("select * from posts where post_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $con->error);
        exit;
    }
    $stmt->bind_param('i', $post_id);

    $stmt->execute();

    $stmt->bind_result($id, $username, $title, $body, $link, $categories);

    echo "<ul>\n";
    while($stmt->fetch()){
        printf("\t<li>%s <h4>%s</h4> <p>%s</p> <p>%s%s</p>\n",
            htmlspecialchars($username),
            htmlspecialchars($title),
            htmlspecialchars($body),
            "Category: ", 
            htmlspecialchars($categories)
        );
        if($categories == NULL){
            print('No Categories Listed.');
            print('<br><br>');
        }
        if(!$link == NULL){
            printf("\t<a href=%s/>Link</a></li>\n",
            htmlspecialchars($link)
            );
        }
        
        if(isset($_SESSION['loggedin'])){
            echo '<br>';
            echo "<a class='comment-button' href=\"create_comment.php\"> Create Comment</a>";
            if($_SESSION['username'] == $username) { ?>
                    <form action="edit_post.php" method="POST">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                        <input type="hidden" name="post_id" value="<?php echo $post_id;?>" />
                        <input type="submit" value="Edit Post">
                    </form>
                <?php
                echo "<br>";
                ?>
                    <form action="delete.php" method="POST">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                        <input type="hidden" name="post_id" value="<?php echo $post_id;?>" />
                        <input type="submit" value="Delete Post">
                    </form>
                <?php
                echo "<br>";
            }
        }

    } 
    echo "</ul>\n";
    $stmt->close();
    

    // $comment_id = $_GET['comment_id'];
    // $_SESSION['comment_id'] = $comment_id;

    $stmt=$con->prepare("select * from comments where post_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $con->error);
        exit;
    }
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $stmt->bind_result($comment_id, $username, $post_id, $comment);
    echo "<br>COMMENTS:";
    $counter = 0;
    echo "<ul>\n";
    while($stmt->fetch()){
        printf("\t<li>%s - <br> %s</li>\n",
            htmlspecialchars($username),
            htmlspecialchars($comment)
        );
        $counter++;
        if(isset($_SESSION['loggedin'])){
            if($_SESSION['username'] == $username) {?>
                <form action="delete_comment.php" method="POST">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                    <input type="hidden" name="comment_id" value="<?php echo $comment_id;?>" />
                    <input type="submit" value="Delete Comment">
                </form>
                <?php
                echo "<br>";
                // echo "<a class='edit-button' href=\"edit_comment.php?comment_id={$comment_id}\">Edit Comment</a>"; ?>
                <form action="edit_comment.php" method="POST">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                    <input type="hidden" name="comment_id" value="<?php echo $comment_id;?>" />
                    <input type="submit" value="Edit Comment">
                </form> <?php
                echo "<br>";
            }
        }
    } 
    if($counter == 0){
        echo "No Comments";
    }
    echo "</ul>\n";
    $stmt->close();
?>
</body>
</html>