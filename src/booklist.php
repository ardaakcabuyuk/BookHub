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
  echo "<script type='text/javascript'>alert('Bad credentials!');window.location.href='home.php';</script>";
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
                      <h2 style="text-align: center;"> <strong><?php echo $list['list_name']; ?></strong></h2>
                      <h5 style="text-align: center;">Book List by <strong><?php echo $list['name']. " " . $list['surname']; ?></strong></h5>
                    </div>
                  </div>
            </div>
        </header>


        <div class="container bootstrap snippets bootdey">

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <br/>
                <br/>
                <hr/>
                <?php
                $book_in_list_sql = "select * from contains natural join book where list_id=$list_id";
                $book_in_list_query = mysqli_query($db,$book_in_list_sql);
                while( $row = mysqli_fetch_array($book_in_list_query)) {
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
                              echo "<a href=\"bookprofile.php?book_id=" .$row['book_id']. "\" class=\"btn btn-warning\" role=\"button\">Show Detailed Info</a>";
                          echo "</div>";
                      echo "</div>";
                  echo "</div>";
                  echo "<hr>";
                }
                ?>
              </div>

            </div>
          </div>
        </div>
    </body>
</html>
