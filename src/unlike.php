<?php
session_start();
include('config.php');
list($url, $post_id) = explode("-", $_POST['like_button'], 2);
echo "id: $post_id, name: $url";
$delete_like_sql = "delete from likes_post where user_id = ".$_SESSION['user_id']." and post_id = $post_id";
#echo $delete_like_sql;

$delete_like_query = mysqli_query($db, $delete_like_sql);

header("location: $url");
?>
