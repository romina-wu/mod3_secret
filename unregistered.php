<!DOCTYPE html>
<html lang='en'>
<head>
    <title>
        Not Logged In Home Page
    </title>
</head>
<body>
    <div class = 'wrapper'>
        <form action="login2.php" method="post">
            <div class="form-group">
                Username 
                <input type="text" name ='username' class="form-control" required>
                Password 
                <input type="text" name ='password' class="form-control" required> 
                <button type = "submit" class="btn btn-primary">Login</button>
            </div>
            <div>
                Don't Have An Account? <a href="create.html">
                    Sign Up
                </a>
            </div>
        </form>
    </div>

<?php
session_start();
require_once "config.php";

echo "FILTERS:";
$stmt = $con->prepare("select categories from categories");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $con->error);
	exit;
}
$stmt->execute();
$stmt->bind_result($categories);
echo "<ul>\n";
while($stmt->fetch()){
    echo "<li><a class='cat-button' target ='_blank' href=\"filter.php?categories={$categories}\">$categories</a></li>";
    echo "\n";
}
echo "</ul>\n";
$stmt->close();

echo "POSTS: ";
$stmt = $con->prepare("select * from posts");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $con->error);
	exit;
}
$stmt->execute();
$stmt->bind_result($post_id, $username, $title, $body, $link, $categories);
echo "<ul>\n";
while($stmt->fetch()){
	printf("\t<li>%s : %s</li>\n",
		htmlspecialchars($username),
		htmlspecialchars($title),
        htmlspecialchars($body),
        htmlspecialchars($link),
		htmlspecialchars($categories)
	);
    echo "<li><a class='view-button' target ='_blank' href=\"view_post.php?post_id={$post_id}\">View Post</a></li>";
}
echo "</ul>\n";
$stmt->close();
?>

</body>
</html>