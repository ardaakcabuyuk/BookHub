<?php
include('config.php');
include_once "navbar.php";
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

        <div class="container bootstrap snippets bootdey">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <br/>
                    <br/>
                    <form class="form-inline" action="rangesearchbook.php" method="post">
                      <?php
                      if (isset($_POST['range_search_book_button'])) {
                          echo "<div class=\"form-group mb-2\">";
                          echo "<label for=\"min\">Range Search:</label>";
                          echo "<br>";
                          echo "<input type=\"search\" id=\"min\" class=\"form-control rounded\" placeholder=\"Year (min)\" aria-label=\"Search\"";
                            echo "aria-describedby=\"search-addon\" name=\"year_min\" required>";
                          echo "</div>";
                          echo "<div class=\"form-group mb-2\">";
                          echo "<input type=\"search\" class=\"form-control rounded\" placeholder=\"Year (max)\" aria-label=\"Search\"";
                            echo "aria-describedby=\"search-addon\" name=\"year_max\" required>";
                          echo "</div>";
                          echo "<div class=\"form-group mb-2\">";
                            echo "<button class=\"btn btn-warning mb-2 pull-right\" type=\"submit\" name=\"range_search_book_button\">";
                                   echo "Search";
                            echo "</button>";
                          echo "</div>";
                        }
                        ?>
                      </form>

                      <br/>
                      <br/>

                      <h2>Search Results</h2>
                      <hr>
                      <?php
                      if(isset($_POST['year_min']) && isset($_POST['year_max'])) {
                        $year_min = $_POST['year_min'];
                        $year_max = $_POST['year_max'];
                        $search_book_query = "select * from book where year between $year_min and $year_max";
                        $search_book = mysqli_query($db, $search_book_query);
                        if (mysqli_num_rows($search_book) != 0) {
                          while ($row = mysqli_fetch_array($search_book)) {
                            echo "<div class=\"well search-result\">";
                                echo "<div class=\"row\">";
                                    echo "<div class=\"col-xs-6 col-sm-9 col-md-9 col-lg-10 title\">";
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
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                            echo "<hr>";
                          }
                        }
                      }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
