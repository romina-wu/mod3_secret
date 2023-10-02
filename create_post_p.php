<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post Processor</title>
</head>
<body>
    <h1>Create PHP page</h1>
    <?php
        session_start();

            $user = $_SESSION['username'];
            
            if(!hash_equals($_SESSION['token'], $_POST['token'])){
                die("Request forgery detected");
            }

            if(isset($_POST['title']) and isset($_POST['body'])){
                $title = $_POST['title'];
                $body = $_POST['body'];
            } else {
                echo "you need a title and body to post";
            }

            if(isset($_POST['link'])){
                $link = $_POST['link'];
            } else {
                $link = NULL;
            }

            if(isset($_POST['categories'])){
                $categories = $_POST['categories'];
            } else {
                $categories = NULL;
            }

            require_once "config.php";
            $stmt = $con->prepare("insert into posts (username, title, body, link, categories) VALUES (?, ?, ?, ?, ?)");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $con->error);
                exit;
            }

            $stmt->bind_param('sssss', $user, $title, $body, $link, $categories);

            $stmt->execute();

            $stmt->close();

            $stmt=$con->prepare("insert into categories (categories) values (?)");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $con->error);
                exit;
            }
            $stmt->bind_param('s', $categories);
            $stmt->execute();
            $stmt->close();

            header("Location: registered_home.php");

            // if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $title) ){
            //     header("Location: view_post.php?title=$title");
            //     exit;
            // } else{
            //     echo "Upload failed";
            // }

    ?>

</body>
</html>

