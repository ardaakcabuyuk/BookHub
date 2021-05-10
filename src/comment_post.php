<?php
session_start();
include('config.php');

if (isset($_POST['comment_button'])) {
  list($url, $post_id) = explode("-", $_POST['comment_button'], 2);
  if(empty($_POST['content']))
    echo "<script type='text/javascript'>alert('Comment content cannot be empty!');window.location.href='$url';</script>";

  $content = trim($_POST['content']);

  if(empty($_POST['content']))
    echo "<script type='text/javascript'>alert('Comment content cannot be empty!');window.location.href='$url';</script>";

  $insert_com_sql = "insert into comment(user_id, post_id, content) values(".$_SESSION['user_id'].", $post_id, \"$content\")";
  #echo $insert_com_sql;
}
$insert_com_query = mysqli_query($db, $insert_com_sql);

echo "<script type='text/javascript'>alert('Comment successfully added!');window.location.href='$url';</script>";
?>
