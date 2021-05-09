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
              <h2>Quotes</h2>
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
                  $quotes_query = "select *
                                    from Quote Q natural join user U
                                    where Q.book_id = '$book_id'
                                    order by Q.q_date desc";

                  $query_run = mysqli_query($db, $quotes_query);
                  while ($row = mysqli_fetch_array($query_run)) {
                    echo "<div class=\"card gedf-card\">";
                        echo "<div class=\"card-header\">";
                            echo "<div class=\"d-flex justify-content-between align-items-center\">";
                                echo "<div class=\"d-flex justify-content-between align-items-center\">";
                                    echo "<div class=\"mr-2\">";
                                        echo "<img class=\"rounded-circle\" width=\"45\" src=\"images/reader.png\" alt=\"\">";
                                    echo "</div>";
                                    echo "<div class=\"ml-2\" style=\"margin-left: 10px;\">";
                                        echo "<div class=\"h5 m-0\">".$row['name']." ". $row['surname']."</div>";
                                        echo "<div class=\"h7 text-muted\" style=\"color:#A9A9A9;\">@".$row['username']."</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        echo "<div class=\"card-body\">";
                            echo "<a class=\"card-link\" href=\"bookprofile.php?book_id=".$row['book_id']."\" style=\"color:orange;\">";
                                $book_name_query = "select * from book where book_id ='".$row['book_id']."'";
                                $result = mysqli_query($db, $book_name_query);
                                $book = mysqli_fetch_array($result);
                            echo "</a>";
                            echo "<p class=\"card-text\">";
                                echo $row['text'];
                            echo "</p>";
                            echo "<div class=\"text-muted h7 mb-2 pull-right\"> <i class=\"fa fa-clock-o\"></i> ".$row['q_date']."</div>";
                        echo "</div>";
                        echo "<div class=\"card-footer\">";
                            echo "<p style=\"vertical-align: middle; display:inline;\"><i class=\"fa fa-thumbs-o-up\" style=\"color:orange;\"></i> ".$row['q_like_count']." likes";
                            $liked_sql = "select * from likes_quote where quote_id = " . $row['quote_id']. " and user_id = ". $_SESSION['user_id'];
                            if(mysqli_num_rows(mysqli_query($db,$liked_sql)) == 0) {
                              echo "<form style=\"display:inline;\" action=\"like.php\" method=\"post\">";
                              echo "<button type=\"submit\" name=\"like_button_quote\" value=\"quotes.php?book_id=".$row['book_id']."-". $row['quote_id'] ."\" class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Like</button></p>";
                              echo "</form>";
                            }
                            else {
                              echo "<form style=\"display:inline;\" action=\"unlike.php\" method=\"post\">";
                              echo "<button type=\"submit\" name=\"like_button_quote\" value=\"quotes.php?book_id=".$row['book_id']."-". $row['quote_id']. "\" class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Unlike</button></p>";
                              echo "</form>";
                            }
                        echo "</div>";
                    echo "</div>";

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
