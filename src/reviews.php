<?php
include('config.php');
include_once "navbar.php";
include_once "bookheader.php";

if (isset($_GET['book_id'])) {
  $book_id = $_GET['book_id'];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>BookHub</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="js/bootstrap.bundle.js">
        <link rel="stylesheet" href="css/searchresult.css" />
    </head>

    <body>
    <header class="header">
      <div class="container">
        <div class="book-name" style="padding-top:20px;">
          <div class="row" style="margin-top:0px;">
            <div class="col-md-9">
              <h2>Reviews</h2>
            </div>
          </div>
          <hr>
        </div>
      </div>
    </header>

    <div class="container-fluid gedf-wrapper">
        <div class="row justify-content-center" style="padding-top:20px; margin-left:48px;">
            <script src="js/bootstrap.js"></script>

            <div class="col-md-6 gedf-main">
                <?php
                  $reviews_query = "select *
                                    from post P natural join user U
                                    where P.book_id = '$book_id'
                                    order by P.date desc";

                  $query_run = mysqli_query($db, $reviews_query);
                  while ($row = mysqli_fetch_array($query_run)) {
                    echo "<div class=\"card gedf-card\">";
                        echo "<div class=\"card-header\">";
                            echo "<div class=\"d-flex justify-content-between align-items-center\">";
                                echo "<div class=\"d-flex justify-content-between align-items-center\">";
                                    echo "<div class=\"mr-2\">";
                                        echo "<img class=\"rounded-circle\" width=\"45\" src=\"images/reader.png\" alt=\"\">";
                                    echo "</div>";
                                    echo "<div class=\"ml-2\" style=\"margin-left: 10px;\">";
                                    echo "<div class=\"h5 m-0\"><a style=\"color:orange; text-decoration: none;\" href=\"userprofile.php?uname=".$row['username']."\">".$row['name']." ". $row['surname']."</a></div>";
                                    echo "<div class=\"h7 text-muted\"><a style=\"text-decoration: none;color:#A9A9A9;\" href=\"userprofile.php?uname=".$row['username']."\">@".$row['username']."</a></div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                    echo "<div class=\"card-body\" onclick=\"location.href='review.php?post_id=".$row['post_id']."';\" style=\"cursor: pointer;\">";
                        echo "<p class=\"card-text\">";
                            echo "<div class=\"h7 m-0\"><strong>Review:</strong></div>";
                            echo $row['content'];
                        echo "</p>";
                        echo "<p class=\"card-text\">";
                            echo "<div class=\"h7 mb-1\"><strong>Rating:</strong></div>";
                                for ($i = 0; $i < $row['rate']; $i++) {
                                  echo "<span class=\"fa fa-star checked\" style=\"font-size:30px\"></span>";
                                }
                                for ($i = 0; $i < 5 - $row['rate']; $i++) {
                                  echo "<span class=\"fa fa-star\" style=\"font-size:30px\"></span>";
                                }
                            echo "</p>";
                            echo "<div class=\"text-muted h7 mb-2 pull-right\"> <i class=\"fa fa-clock-o\"></i> ".$row['date']."</div>";
                        echo "</div>";
                        echo "<div class=\"card-footer\">";
                            echo "<p style=\"vertical-align: middle; display:inline;\"><i class=\"fa fa-thumbs-o-up\" style=\"color:orange;\"></i> ".$row['like_count']." likes";
                            echo "&emsp;<i class=\"fa fa-comment-o\" style=\"color:orange;\"></i> ".$row['comment_count']." comments";
                            echo "<form style=\"display:inline;\" action=\"comment_post.php\" method=\"post\">";
                            echo "<div class=\"form-group\" style=\"margin-top:20px; margin-bottom:20px;\">";
                                echo "<input class=\"form-control\" name= \"content\" id=\"message\" rows=\"3\" placeholder=\"Comment here...\"></input>";
                            echo "</div>";
                            echo "<button type=\"submit\" name=\"comment_button\" value=\"reviews.php?book_id=".$row['book_id']."-". $row['post_id']. "\" class=\"btn btn-warning pull-right\" style=\"margin-left: 10px; margin-bottom:10px;\"><i class=\"fa fa-comment-o\"></i> Comment</button>";
                            echo "</form>";
                            $liked_sql = "select * from likes_post where post_id = " . $row['post_id']. " and user_id = ". $_SESSION['user_id'];
                            if(mysqli_num_rows(mysqli_query($db,$liked_sql)) == 0) {
                              echo "<form style=\"display:inline;\" action=\"like.php\" method=\"post\">";
                              echo "<button type=\"submit\" name=\"like_button\" value=\"reviews.php?book_id=".$row['book_id']."-".$row['post_id'] ."\" class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Like</button></p>";
                              echo "</form>";
                            }
                            else {
                              echo "<form style=\"display:inline;\" action=\"unlike.php\" method=\"post\">";
                              echo "<button type=\"submit\" name=\"like_button\" value=\"reviews.php?book_id=".$row['book_id']."-". $row['post_id']. "\" class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Unlike</button></p>";
                              echo "</form>";
                            }
                        echo "</div>";
                    echo "</div>";
                    echo "</a>";
                    echo "<br/>";
                    echo "<br/>";
                  }
                ?>
            </div>
        </div>
    </div>
  </header>
    </body>
</html>
