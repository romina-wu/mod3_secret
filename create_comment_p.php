<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Comment Processor</title>
</head>
<body>
    <h1>Create Comment page</h1>
    <?php
        session_start();
        $user = $_SESSION['username'];
        $post_id = $_SESSION['post_id'];
        if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected");
        }
        if(!preg_match('/^[a-zA-Z0-9_!? ]+$/', trim($_POST["body"]))){
            echo
            "<!DOCTYPE HTML>
            <html lang=\"en\">
            <head>
            <title>
                Error
            </title>
            </head>
            <p>
                Invalid comment (please only put letters, numbers, and underscores);
            </p>
            <p>
                <INPUT TYPE=\"button\" VALUE=\"Return\" onClick=\"history.go(-1);\">
            </p>";
        }
        else{
            if(isset($_POST['body'])){
                $body = $_POST['body'];
            } else {
                echo "Enter a comment.";
            }

            require_once "config.php";
            $stmt = $con->prepare("insert into comments (username, post_id, comment) VALUES (?, ?, ?)");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $con->error);
                exit;
            }

            $stmt->bind_param('sss', $user, $post_id, $body);

            $stmt->execute();

            $stmt->close();

           header("Location: view_post.php?post_id=$post_id");
        }

    ?>

</body>
</html>