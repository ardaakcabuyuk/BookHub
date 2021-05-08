<?php
session_start();
include('config.php');
list($url, $post_id) = explode("-", $_POST['like_button'], 2);
echo "id: $post_id, name: $url";
$insert_like_sql = "insert into likes_post values(".$_SESSION['user_id'].", $post_id)";
$insert_like_query = mysqli_query($db, $insert_like_sql);

header("location: $url");
?>
