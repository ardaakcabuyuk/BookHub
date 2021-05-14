<?php
  include('config.php');
  session_start();
  if(isset($_GET['book_id']) && isset($_GET['recommender_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = $_GET['book_id'];
    $rec_id = $_GET['recommender_id'];
    $delete_recommend_sql = "delete from recommend_book where book_id=$book_id and recommender_id=$rec_id and recommended_id=$user_id";

    $query = mysqli_query($db,$delete_recommend_sql);
    if(!$query) {
      echo "<script type='text/javascript'>alert('Error in deleting!');window.location.href='recommendations.php';</script>";
    }
    echo "<script type='text/javascript'>alert('Successfully deleted!');window.location.href='recommendations.php';</script>";
  }
 ?>
