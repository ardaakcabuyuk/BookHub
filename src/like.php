<?php
session_start();
include('config.php');

if (isset($_POST['like_button'])) {
  list($url, $post_id) = explode("-", $_POST['like_button'], 2);
  $insert_like_sql = "insert into likes_post values(".$_SESSION['user_id'].", $post_id)";
}
else if (isset($_POST['like_button_quote'])) {
  list($url, $quote_id) = explode("-", $_POST['like_button_quote'], 2);
  $insert_like_sql = "insert into likes_quote values(".$_SESSION['user_id'].", $quote_id)";
}
else if (isset($_POST['like_comment_button'])) {
  list($url, $comment_id) = explode("-", $_POST['like_comment_button'], 2);
  $insert_like_sql = "insert into likes_comment values(".$_SESSION['user_id'].", $comment_id)";
}
$insert_like_query = mysqli_query($db, $insert_like_sql);

header("location: $url");
?>
