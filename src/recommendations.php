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
      $recommend_sql = "select * from recommend_book natural join book, user U where U.user_id = recommender_id and recommended_id = $user_id";
      $search_books = mysqli_query($db, $recommend_sql);
      if (mysqli_num_rows($search_books) != 0) {
        while ($row = mysqli_fetch_array($search_books)) {
          echo "<div class=\"well search-result\">";
              echo "<div class=\"row\">";
                  echo "<div class=\"col-xs-6 col-sm-9 col-md-9 col-lg-10 title\">";
                      echo "<a style=\"color:black; text-decoration: none;\" href=\"./userprofile.php?uname=". $row['username']. "\"><h4>Recommended by ".$row['name']." " . $row['surname']. "</h4></a>";
                      echo "<h3>".$row['book_name']."</h3>";
                      echo "<h5>by ".$row['author']."</h5>";
                      echo "<p>".$row['description']."</p>";

                      $rating_query = "select ifnull(avg(rate),0) as rating
                                        from book
                                        left join post
                                        on book.book_id = post.book_id
                                        where book.book_id =".$row['book_id']."
                                        group by book.book_id";
                      $query_run = mysqli_query($db, $rating_query);
                      $rate = mysqli_fetch_array($query_run)['rating'];
                      for ($i = 0; $i < (int)$rate; $i++) {
                        echo "<i class=\"fa fa-star fa-lg checked\"></i>";
                      }
                      for ($i = 0; $i < 5 - (int)$rate; $i++) {
                        echo "<i class=\"fa fa-star fa-lg\"></i>";
                      }
                      echo "  (".number_format($rate, 2, '.', '').")";
                      echo "<br/>";
                      echo "<a href=\"bookprofile.php?book_id=" .$row['book_id']. "\" class=\"btn btn-warning\" role=\"button\" style=\"margin-top:20px;\">Show Detailed Info</a>";
                      echo "<a style=\"margin-left: 10px; margin-top:20px\" href=\"delete_recommend.php?book_id=" .$row['book_id']. "&recommender_id=". $row['user_id']. "\" class=\"btn btn-warning\" role=\"button\" style=\"margin-top:20px;\">Delete</a>";
                  echo "</div>";
              echo "</div>";
          echo "</div>";
          echo "<hr>";
        }
      }
      else {
        echo "<p>No results.</p>";
      }
    ?>
    </body>
    </html>
