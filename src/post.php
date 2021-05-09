<?php
session_start();
include('config.php');

if (isset($_POST['post_review_button'])) {
  list($url, $book_id) = explode("-", $_POST['post_review_button'], 2);
  $content = addslashes($_POST['content']);
  if (isset($_POST['star'])) {
    $rate = $_POST['star'];
    $post_sql = "insert into post (book_id, content, rate, user_id) values($book_id, '$content', $rate, ".$_SESSION['user_id'].")";
  }
  else {
    $post_sql = "insert into post (book_id, content, rate, user_id) values($book_id, '$content', 0, ".$_SESSION['user_id'].")";
  }
}
else if (isset($_POST['post_quote_button'])) {
  list($url, $book_id) = explode("-", $_POST['post_quote_button'], 2);
  $content = addslashes($_POST['content']);
  echo $content;
  $tags = $_POST['tags'];
  echo $tags;
  $post_sql = "insert into quote (text, tag, book_id, user_id) values('$content', '$tags', $book_id, ".$_SESSION['user_id'].")";
}

$post_query = mysqli_query($db, $post_sql);
echo $post_sql;
header("location: $url?book_id=$book_id");
?>
