<?php
include('config.php');
session_start();
require_once "navbar.php";

if(isset($_GET['list_id'])) {
  $list_id = $_GET['list_id'];
  $list_sql = "select * from booklist natural join user where list_id = $list_id";
  $list_query = mysqli_query($db,$list_sql);
  $list = mysqli_fetch_array($list_query);
}
else {
  echo "<script type='text/javascript'>alert('Bad credentials!');window.location.href='index.php';</script>";
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



        <header class="header">
            <div class="container">

                <div class="row justify-content-center" style="margin-top:20px;">
                    <div class="col-md-3"> <!-- Image -->
                      <h5 style="text-align: center;"> <strong><?php echo $list['list_name']; ?></strong></h2>
                      <h5 style="text-align: center;">Readlist by <strong><?php echo $list['name']. " " . $list['surname']; ?></strong></h2>
                    </div>
                  </div>
            </div>
        </header>


        <div class="container bootstrap snippets bootdey">

            <div class="row">
                        <?php
                        $book_in_list_sql = "select * from contains natural join book where list_id=$list_id";
                        $book_in_list_query = mysqli_query($db,$book_in_list_sql);
                        while( $row = mysqli_fetch_array($book_in_list_query)) {
                          echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">";
                          echo "<br/>";
                          echo "<br/>";
                          echo "<hr>";

                          echo "<div class=\"well search-result\">";
                          echo "<div class=\"row\">";

                          echo "<div class=\"col-xs-6 col-sm-9 col-md-9 col-lg-10 title\">";
                          echo "<h3> ". $row['book_name']. "</h3>";
                          echo "<h5> by ". $row['author']. "</h3>";
                          echo "<h5>". $row['year']. "</h3>";

                          echo "<span class=\"fa fa-star checked\"></span>  <!--Parlak yıldızlar için bunu kullanıcaz-->";
                          echo "<span class=\"fa fa-star checked\"></span>";
                          echo "<span class=\"fa fa-star checked\"></span>";
                          echo "<span class=\"fa fa-star\"></span><!--Parlak olmayan yıldızlar için bunu kullanıcaz-->";
                          echo "<span class=\"fa fa-star\"></span>";
                          echo "<label>Average Ratings (BURASI YAPILACAK!)</label>";
                          echo "<br>";
                          echo "<br>";
                          echo "<div class=\"btn-group me-2\" role=\"group\" aria-label=\"First group\">";
                          echo "<button type=\"button\" class=\"btn btn-primary\">1</button>";
                          echo "<button type=\"button\" class=\"btn btn-primary\">2</button>";
                          echo "<button type=\"button\" class=\"btn btn-primary\">3</button>";
                          echo "<button type=\"button\" class=\"btn btn-primary\">4</button>";
                          echo "<button type=\"button\" class=\"btn btn-primary\">5</button>";
                          echo "<label>Rate this Book</label>";
                          echo "</div>";
                          echo "<br/>";
                          echo "<br/>";
                          echo "<a href=\"./bookprofile.php?book_id=". $row['book_id']. "\" class=\"btn btn-info\" role=\"button\">Book Page</a>";

                          echo "</div>";
                          echo "</div>";
                        }
                        ?>
                    </div>

                    <hr>

                </div>
            </div>
        </div>

    </body>

</html>
