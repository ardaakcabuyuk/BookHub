<?php
include('config.php');
include_once "navbar.php";
if(isset($_SESSION)) {
  $user_id = $_SESSION['user_id'];
}
if(isset($_GET['book_id'])) {
  $book_id = $_GET['book_id'];
}

if(isset($_POST['recommend_button'])) {
  $recommended_id = $_POST['recommend_button'];
  $recom_sql = "insert into recommend_book (book_id, recommended_id, recommender_id) " .
                "values ($book_id, $recommended_id, $user_id)";
  $suc = mysqli_query($db, $recom_sql);
  if($suc) {
    echo "<script type='text/javascript'>alert('Book successfully recommended!');</script>";
  }
}
 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>BookHub</title>
        <link rel="stylesheet" href="js/bootstrap.bundle.js">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/searchresult.css" />

    </head>
    <body>
      <h2>Search Results</h2>
      <hr>
      <?php
      $friend_recommend_sql = "select * from friends F, user U where F.user_id = $user_id and F.friend_id = U.user_id" .
                                                " and F.friend_id not in (select R.recommended_id from recommend_book R where R.book_id=$book_id and R.recommender_id = $user_id)".
                                                " and F.friend_id not in (select user_id from reads_book RB where RB.book_id=$book_id)";
      $search_user = mysqli_query($db, $friend_recommend_sql);
      if (mysqli_num_rows($search_user) != 0) {
        while ($row = mysqli_fetch_array($search_user)) {
          echo "<div class=\"well search-result\">";
              echo "<div class=\"row\">";
                  echo "<div class=\"col-xs-6 col-sm-9 col-md-9 col-lg-10 title\">";
                      echo "<h3>".$row['name']." ".$row['surname']."</h3>";
                      echo "<h6 style=\"color:#A9A9A9;\"\">@".$row['username']."</h6>";
                      echo "<br/>";
                      echo "<br/>";
                      echo "<form action=\"\" method=\"post\">";
                          echo "<a href=\"./userprofile.php?uname=".$row['username']."\" class=\"btn btn-warning\" role=\"button\">Profile</a>";
                          echo "   ";
                          echo "<button class=\"btn btn-warning\" type=\"submit\" name=\"recommend_button\" value=\"". $row['user_id']. "\">";
                                echo "Recommend";
                          echo "</button>";
                      echo "</form>";
                  echo "</div>";
              echo "</div>";
          echo "</div>";
          echo "<hr>";
        }
      }
      else {
        echo "<p>No results.</p>";
      } ?>
    </body>
    </html>
