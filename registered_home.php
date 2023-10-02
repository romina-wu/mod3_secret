<!DOCTYPE html>
<html lang='en'>
	<head>
		<title>
			Registered User page
		</title>
	</head>
	<body>
		<p>
			<a href='mod3logout.php'>Log Out</a>
		</p>
		<p>
			<a href='create_post.php'>Create Post</a>
		</p>
		<h1>
				Welcome <?php session_start(); echo $_SESSION['username'];?>,
		</h1>

<?php
if(!isset($_SESSION['loggedin'])){
	header('Location: unregistered.php');
	exit;
}

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


echo "POSTS:";
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
    echo "<a class='view-button' target ='_blank' href=\"view_post.php?post_id={$post_id}\">View Post</a>";
	echo "<br>";
}


echo "</ul>\n";

$stmt->close();
?>

</body>
</html>