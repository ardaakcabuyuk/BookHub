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
        <link rel="stylesheet" href="searchresult.css" />

    </head>

    <body>

        <div class="container bootstrap snippets bootdey">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <br/>
                    <br/>
                    <form class="form-inline" action="searchresult.php" method="post">
                      <?php
                        if (isset($_POST['search_book_button'])) {
                          echo "<div class=\"form-group mb-2\">";
                          echo "<input type=\"search\" class=\"form-control rounded\" placeholder=\"Search Books\" aria-label=\"Search\"";
                            echo "aria-describedby=\"search-addon\" name=\"search_book\">";
                          echo "</div>";
                          echo "<div class=\"form-group mb-2\">";
        						        echo "<button class=\"btn btn-warning mb-2 pull-right\" type=\"submit\" name=\"search_book_button\">";
        					                 echo "Search";
        						        echo "</button>";
                          echo "</div>";
                        }
                        else if (isset($_POST['search_author_button'])) {
                          echo "<div class=\"form-group mb-2\">";
                          echo "<input type=\"search\" class=\"form-control rounded\" placeholder=\"Search Authors\" aria-label=\"Search\"";
                            echo "aria-describedby=\"search-addon\" name=\"search_author\">";
                          echo "</div>";
                          echo "<div class=\"form-group mb-2\">";
        						        echo "<button class=\"btn btn-warning mb-2 pull-right\" type=\"submit\" name=\"search_author_button\">";
        					                 echo "Search";
        						        echo "</button>";
                          echo "</div>";
                        }
                        else if (isset($_POST['search_user_button'])) {
                          echo "<div class=\"form-group mb-2\">";
                          echo "<input type=\"search\" class=\"form-control rounded\" placeholder=\"Search Users\" aria-label=\"Search\"";
                            echo "aria-describedby=\"search-addon\" name=\"search_user\">";
                          echo "</div>";
                          echo "<div class=\"form-group mb-2\">";
        						        echo "<button class=\"btn btn-warning mb-2 pull-right\" type=\"submit\" name=\"search_user_button\">";
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
                      if(isset($_POST['search_book_button'])) {
                        $searchkey = $_POST['search_book'];
                        if ($searchkey != "") {
                          $search_book_query = "select * from book where book_name like '%$searchkey%'";
                          $search_book = mysqli_query($db, $search_book_query);
                          if (mysqli_num_rows($search_book) != 0) {
                            while ($row = mysqli_fetch_array($search_book)) {
                              echo "<div class=\"well search-result\">";
                                  echo "<div class=\"row\">";
                                      echo "<div class=\"col-xs-6 col-sm-9 col-md-9 col-lg-10 title\">";
                                          echo "<h3>".$row['book_name']."</h3>";
                                          echo "<h5>by ".$row['author']."</h5>";
                                          echo "<p>".$row['description']."</p>";

                                          echo "<!-- todo post post gezip rating hesapla -->";
                                          echo "<span class=\"fa fa-star checked\"></span>";
                                          echo "<span class=\"fa fa-star checked\"></span>";
                                          echo "<span class=\"fa fa-star checked\"></span>";
                                          echo "<span class=\"fa fa-star\"></span>";
                                          echo "<span class=\"fa fa-star\"></span>";
                                          echo "<br>";
                                          echo "<p>Average Ratings (3.2)</p>";
                                          echo "<p>Rate Book:</p>";
                                          echo "<div class=\"btn-group me-2\" role=\"group\" aria-label=\"First group\">";
                                            echo "<button type=\"button\" class=\"btn bg-transparent\"><span class=\"fa fa-star\"></span></button>";
                                            echo "<button type=\"button\" class=\"btn bg-transparent\"><span class=\"fa fa-star\"></span></button>";
                                            echo "<button type=\"button\" class=\"btn bg-transparent\"><span class=\"fa fa-star\"></span></button>";
                                            echo "<button type=\"button\" class=\"btn bg-transparent\"><span class=\"fa fa-star\"></span></button>";
                                            echo "<button type=\"button\" class=\"btn bg-transparent\"><span class=\"fa fa-star\"></span></button>";
                                          echo "</div>";
                                          echo "<br/>";
                                          echo "<br/>";
                                          echo "<a href=\"#link\" class=\"btn btn-warning\" role=\"button\">Show Detailed Info</a>";
                                      echo "</div>";
                                  echo "</div>";
                              echo "</div>";
                              echo "<hr>";
                            }
                          }
                          else {
                            echo "<p>No results.</p>";
                          }
                        }
                      }
                      else if(isset($_POST['search_author_button'])) {
                        $searchkey = $_POST['search_author'];
                        if ($searchkey != "") {
                          $search_author_query = "select * from author natural join user where name or surname like '%$searchkey%'";
                          $search_author = mysqli_query($db, $search_author_query);
                          if (mysqli_num_rows($search_author) != 0) {
                            while ($row = mysqli_fetch_array($search_author)) {
                              echo "<div class=\"well search-result\">";
                                  echo "<div class=\"row\">";
                                      echo "<div class=\"col-xs-6 col-sm-9 col-md-9 col-lg-10 title\">";
                                          echo "<h3>".$row['name']." ".$row['surname']."</h3>";
                                          echo "<h5>Books: ".$row['num_book']."</h5>";
                                          echo "<br/>";
                                          echo "<br/>";
                                          echo "<a href=\"./authorprofile.php?uname=".$row['username']."\" class=\"btn btn-warning\" role=\"button\">Profile</a>";
                                      echo "</div>";
                                  echo "</div>";
                              echo "</div>";
                              echo "<hr>";
                            }
                          }
                          else {
                            echo "<p>No results.</p>";
                          }
                        }
                      }
                    ?>
                </div>
            </div>
        </div>

    </body>

</html>
