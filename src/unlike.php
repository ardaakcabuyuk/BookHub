<?php
session_start();
include('config.php');
if (isset($_POST['like_button'])) {
  list($url, $post_id) = explode("-", $_POST['like_button'], 2);
  $delete_like_sql = "delete from likes_post where user_id = ".$_SESSION['user_id']." and post_id = $post_id";
}
else if (isset($_POST['like_button_quote'])) {
  list($url, $quote_id) = explode("-", $_POST['like_button_quote'], 2);
  $delete_like_sql = "delete from likes_quote where user_id = ".$_SESSION['user_id']." and quote_id = $quote_id";
}
$delete_like_query = mysqli_query($db, $delete_like_sql);
header("location: $url");
?>
