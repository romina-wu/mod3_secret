<?php
session_start();

$user = $_SESSION['username'];

$new_body = $_GET['new_body'];
$comment_id = $_SESSION['comment_id'];
$post_id = $_SESSION['post_id'];

require_once "config.php";
$stmt = $con->prepare("update comments set comment=? where  comment_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $con->error);
	exit;
}

$stmt->bind_param('si', $new_body, $comment_id);

$stmt->execute();

// $stmt->bind_result($username, $title, $body, $link);

$stmt->close();

header("Location: view_post.php?post_id=$post_id");

?>