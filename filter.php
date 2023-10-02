<!DOCTYPE html>
<html lang='en'>
	<head>
		<title>
			Filtered
		</title>
	</head>
    <body>
        <a href="registered_home.php">Back to home</a>
        <br>
        <br>
    

<?php
session_start();

require_once "config.php";

$categories = $_GET['categories'];
$_SESSION["categories"] = $categories;

echo "POSTS:";
$stmt = $con->prepare("select * from posts where categories = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $con->error);
	exit;
}
$stmt->bind_param('s', $categories);

$stmt->execute();

$stmt->bind_result($post_id, $username, $title, $body, $link, $categories);
$counter = 0;
echo "<ul>\n";
while($stmt->fetch()){
    if($_SESSION['categories'] == $categories){
        printf("\t<li>%s : %s</li>\n",
		    htmlspecialchars($username),
		    htmlspecialchars($title),
            htmlspecialchars($body),
            htmlspecialchars($link),
		    htmlspecialchars($categories)
	    );
        echo "<a class='view-button' target ='_blank' href=\"view_post.php?post_id={$post_id}\">View Post</a>";
        $counter++;
    }
}

echo "</ul>\n";

if($counter == 0){
    echo "No Results Found";
}
$stmt->close();
?>

</body>
</html>