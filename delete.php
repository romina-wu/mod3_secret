<?php
session_start();
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$user = $_SESSION['username'];
$post_id = $_POST["post_id"];

echo $post_id;

require_once "config.php";
$stmt2 = $con->prepare("delete from comments where post_id=?");
if(!$stmt2){
	printf("Query Prep Failed: %s\n", $con->error);
	exit;
}
$stmt2->bind_param('i', $post_id);

$stmt2->execute();

$stmt2->close();

$stmt = $con->prepare("delete from posts where post_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $con->error);
	exit;
}
$stmt->bind_param('i', $post_id);

$stmt->execute();

// $stmt->bind_result($post_id, $username, $title, $body, $link);

$stmt->close();
?>

<h2>Post Deleted</h2>
<a href="registered_home.php">Back to home</a>
