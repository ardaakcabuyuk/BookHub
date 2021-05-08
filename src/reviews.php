<?php
include('config.php');
include_once "navbar.php";

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

    <br/>
    <br/>
    <header class="header">
      <div class="container">
        <div class="book-name" style="padding-top:20px;">
          <div class="row" style="margin-top:0px;">
          <?php
            $get_book_info_query = "select * from book natural join author where book_id = $book_id";
            $get_book = mysqli_query($db, $get_book_info_query);
            $book = mysqli_fetch_array($get_book);
            echo "<div class=\"col-md-9\">";
              echo "<h2 style=\"font-size:38px\"><strong>".$book['book_name']."</strong></h2>";
              echo "<h3>by <strong>". $book['author'] ."</strong></h3>";
              echo "<h5>Genre: <strong>". $book['genre']. " </strong></h5>";
              echo "<h5>". $book['year'] ."</h5>";
            echo "</div>";
          echo "</div>";
        echo "</div>";

        echo "<div class=\"row\" style=\"margin-top:20px;\">";
          echo "<div class=\"col-md-3\"> <!-- Image -->";
            echo "<a href=\"#\"> <img class=\"img-responsive\" src=\"https://picsum.photos/200\" alt=\"Kamal\" style=\"width:200px;height:200px\"></a>";
          echo "</div>";

        echo "<div class=\"col-md-6\"> <!-- Rank & Qualifications -->";
          echo "<h5>Description:</h5>";
          echo "<small>".$book['description']."</small>";
        echo "</div>";
          ?>
        </div>
      </div>
    </header>

    <br/>
    <br/>

    <div class="container-fluid gedf-wrapper">

        <div class="row justify-content-center">
            <script src="js/bootstrap.js"></script>

            <div class="col-md-6 gedf-main">
              <h2>Reviews</h2>
              <hr>
                <?php
                  $friends_query = "select *
                                    from post P natural join user U
                                    where P.user_id in (select friend_id
                                                        from user U2 natural join friends F
                                                        where F.user_id ='" . $_SESSION['user_id'] . "')
                                    or P.user_id ='". $_SESSION['user_id'] . "'
                                    order by P.date desc";

                  $query_run = mysqli_query($db, $friends_query);
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
                                echo "<h5 class=\"card-title\">".$book['book_name']."</h5>";
                            echo "</a>";
                            echo "<p class=\"card-text\">";
                                echo $row['content'];
                            echo "</p>";
                            echo "<p class=\"card-text\">";
                                echo "Rating:  ";
                                for ($i = 0; $i < $row['rate']; $i++) {
                                  echo "<span class=\"fa fa-star checked\"></span>";
                                }
                                for ($i = 0; $i < 5 - $row['rate']; $i++) {
                                  echo "<span class=\"fa fa-star\"></span>";
                                }
                            echo "</p>";
                            echo "<div class=\"text-muted h7 mb-2 pull-right\"> <i class=\"fa fa-clock-o\"></i> ".$row['date']."</div>";
                        echo "</div>";
                        echo "<div class=\"card-footer\">";
                            echo "<p style=\"vertical-align: middle;\"><i class=\"fa fa-thumbs-o-up\" style=\"color:orange;\"></i> ".$row['like_count']." likes";
                            echo "&emsp;<i class=\"fa fa-comment-o\" style=\"color:orange;\"></i> ".$row['comment_count']." comments";
                            echo "<button type=\"submit\" class=\"btn btn-warning pull-right\" style=\"margin-left: 10px;\"><i class=\"fa fa-comment-o\"></i> Comment</button>";
                            echo "<button type=\"submit\" class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Like</button></p>";
                        echo "</div>";

                        echo "<div class=\"form-group\">";
                            echo "<textarea class=\"form-control\" id=\"message\" rows=\"3\" placeholder=\"Comment here...\"></textarea>";
                        echo "</div>";
                    echo "</div>";

                    echo "<br/>";
                    echo "<br/>";
                  }
                ?>
            </div>
        </div>
    </div>
    </body>
</html>
