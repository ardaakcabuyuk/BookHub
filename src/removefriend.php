<?php
include('config.php');
session_start();
$url = "userprofile.php?uname=". $_SESSION['username'];
if(isset($_POST['remove_button'])) {
  $user_id = $_SESSION['user_id'];
  $friend_id = $_POST['remove_button'];

  $remove_f_sql = "delete from friends where friend_id = $friend_id and user_id = $user_id";
  $remove_s_sql = "delete from friends where friend_id = $user_id and user_id = $friend_id";

  $q1 = mysqli_query($db,$remove_f_sql);
  $q2 = mysqli_query($db,$remove_s_sql);

  if( $q1 && $q2) {
    echo "<script type='text/javascript'>alert('Friend removed successfully!');window.location.href='$url';</script>";
  }
  echo "<script type='text/javascript'>alert('Friend removal failed!');window.location.href='$url';</script>";
}
 ?>
