<?php
include('config.php');
session_start();
if(isset($_POST['button'])) {
  $username = $_POST['username'];
  $password = $_POST['pass'];
  if(empty($_POST['username'])) {
    echo "<script type='text/javascript'>alert('Username cannot be empty!');window.location.href='index.php';</script>";
  }
  else if(empty($_POST['pass'])) {
    echo "<script type='text/javascript'>alert('Password cannot be empty!');window.location.href='index.php';</script>";
  }
  else {
    $username = $_POST['username'];
    $password = $_POST['pass'];
    $sql = "select * from user where username='$username' and password='$password'";
    $user = mysqli_query($db,$sql);

    if(mysqli_num_rows($user) == 1) {
      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['user_id'] = mysqli_fetch_array($user)['user_id'];
      $user_id = $_SESSION['user_id'];
      echo "<script type='text/javascript'>alert('Successfully logged in!, user_id = $user_id');window.location.href='home.php';</script>";
    }
    else {
      echo "<script type='text/javascript'>alert('Invalid username or password!');window.location.href='index.php';</script>";
    }
    $author_check_sql = "select * from Author where user_id = '$user_id'";
    $author = mysqli_query($db, $author_check_sql);

    $librarian_check_sql = "select * from Librarian where user_id = '$user_id'";
    $librarian = mysqli_query($db, $librarian_check_sql);

    if(mysqli_num_rows($author) == 1) {
      $_SESSION['type'] = "author";
      $_SESSION['a_id'] = mysqli_fetch_array($author)['author_id'];
    }
    else if(mysqli_num_rows($librarian) == 1) {
      $_SESSION['type'] = "librarian";
      $_SESSION['l_id'] = mysqli_fetch_array($librarian)['librarian_id'];
    }
    else {
      $_SESSION['type'] = "user";
    }
  }
}



?>
