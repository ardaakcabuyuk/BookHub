<?php
include('config.php');
session_start();
if(isset($_POST['create'])) {
    $url = "userprofile.php?uname=". $_SESSION['username'];
    $create_bookl_sql = "insert into booklist(list_name, description, user_id, num_books) ".
                        "values('".$_POST['list_name']."', '". $_POST['desc'] ."', ". $_SESSION['user_id'].", 0)";

    $q1 = mysqli_query($db, $create_bookl_sql);
    if($q1) {
      echo "<script type='text/javascript'>alert('Booklist created successfully!');window.location.href='$url';</script>";
    }
    else {
      echo "<script type='text/javascript'>alert('Error in booklist creation!');window.location.href='$url';</script>";
    }
}
 ?>
