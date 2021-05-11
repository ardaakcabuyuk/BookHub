<?php
session_start();
include('config.php');

if (isset($_POST['reply_button'])) {
  list($url, $post_id) = explode("-", $_POST['reply_button'], 2);
  if(empty($_POST['content']))
    echo "<script type='text/javascript'>alert('Reply content cannot be empty!');window.location.href='$url';</script>";

  $content = trim($_POST['content']);

  if(empty($_POST['content']))
    echo "<script type='text/javascript'>alert('Reply content cannot be empty!');window.location.href='$url';</script>";

  $insert_com_sql = "insert into replies(author_id, post_id, reply) values(".$_SESSION['a_id'].", $post_id, \"$content\")";
  echo $insert_com_sql;
}
$insert_com_query = mysqli_query($db, $insert_com_sql);
if(!$insert_com_query)
  echo "<script type='text/javascript'>alert('You can add one reply!');window.location.href='$url';</script>";
echo "<script type='text/javascript'>alert('Reply successfully added!');window.location.href='$url';</script>";
?>
