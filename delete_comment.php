<?php
session_start();

$user = $_SESSION['username'];
$comment_id = $_POST["comment_id"];
$post_id = $_SESSION["post_id"];
// echo $_SESSION['token'];
// echo "-----------------------";
// echo $_POST['token'];
// echo "-----------------------";
// echo $comment_id;

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	echo "die";
	die("Request forgery detected");
}

require_once "config.php";
$stmt = $con->prepare("delete from comments where comment_id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $con->error);
	exit;
}

$stmt->bind_param('i', $comment_id);

$stmt->execute();

// $stmt->bind_result($post_id, $username, $title, $body, $link);

$stmt->close();
?>
<h2>Comment Deleted</h2>
<input type="button" value="Return" onClick="history.go(-1);">
