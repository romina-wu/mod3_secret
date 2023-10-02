<?php
session_start();

$user = $_SESSION['username'];

$new_title = $_POST['new_title'];
$new_body = $_POST['new_body'];
$new_link = $_POST['new_link'];
$new_categories = $_POST['new_categories'];
$post_id = $_SESSION['post_id'];

require_once "config.php";
$stmt = $con->prepare("update posts set title=?, body=?, link=?, categories=? where post_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $con->error);
	exit;
}

$stmt->bind_param('ssssi', $new_title, $new_body, $new_link, $new_categories, $post_id);

$stmt->execute();

// $stmt->bind_result($username, $title, $body, $link);

$stmt->close();

header("Location: view_post.php?post_id=$post_id");

?>