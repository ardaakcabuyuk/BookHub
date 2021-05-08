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
    <link rel="stylesheet" href="js/bootstrap.bundle.js">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/searchresult.css" />
</head>

<body>

    <!-- ******HEADER****** -->
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
              echo "<div class=\"col-md-3\">";
                if ($_SESSION['type'] == "librarian") {
                  echo "<div class=\"button\" style=\"float:right; margin-left: 10px;\">";
                    echo "<a href=\"#\" class=\"btn btn-outline-success btn-sm\">Prepare Quiz </a>";
                  echo "</div>";
                }
                echo "<div class=\"button\" style=\"float:right; margin-left: 10px;\">";
                  echo "<a href=\"#\" class=\"btn btn-outline-success btn-sm\">Quiz </a>";
                echo "</div>";
                echo "<div class=\"button\" style=\"float:right;\">";
                  echo "<a href=\"#\" class=\"btn btn-outline-success btn-sm\">Recommend </a>";
                echo "</div>";
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
            echo "<div class=\"col-md-3 text-center\"> <!-- Phone & Social -->";
                if ($_SESSION['type'] != "librarian") {
                  echo "<div class=\"button\" style=\"padding-top:18px\">";
                      echo "<a href=\"mailto:ahmkctg@yahoo.com\" class=\"btn btn-outline-success btn-block\">Erroneous Info Request</a>";
                  echo "</div>";
                }
                echo "<div class=\"button\" style=\"padding-top:18px\">";
                    echo "<a href=\"mailto:ahmkctg@yahoo.com\" class=\"btn btn-outline-success btn-block\">Quotes</a>";
                echo "</div>";
                echo "<div class=\"button\" style=\"padding-top:18px\">";
                    echo "<a href=\"reviews.php?book_id=".$book['book_id']."\" class=\"btn btn-outline-success btn-block\">Reviews</a>";
                echo "</div>";
            echo "</div>";
          ?>
          </div>
        </div>
      </header>
        <!--End of Header-->

        <br>
        <br>
    <!-- Main container -->
      <div class="container">

    <!-- Section:Biography -->
      <div class="row">
            <div class="col-md-12">
              <div class="card card-block text-xs-left">
                <h2 class="card-title" style="color:#009688">Editions</h2>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Edition</th>
                        <th scope="col">Publisher</th>
                        <th scope="col">Page Count</th>
                        <th scope="col">Format</th>
                        <th scope="col">Language</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $edition_query = "select * from book natural join edition where book_id = $book_id";
                        $edition_run = mysqli_query($db, $edition_query);
                        while ($edition = mysqli_fetch_array($edition_run)) {
                          echo "<tr>";
                            echo "<th scope=\"row\">".$edition['edition_no']."</th>";
                            echo "<td>".$edition['publisher']."</td>";
                            echo "<td>".$edition['page_count']."</td>";
                            echo "<td>".$edition['format']."</td>";
                            echo "<td>".$edition["language"]."</td>";
                          echo "</tr>";
                        }
                      ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
    <!-- End:Biography -->
    <br>
    <br>

    <div class="row">
        <div class="col-md-12">
          <div class="card card-block text-xs-left">
            <h2 class="card-title" style="color:#009688"><i class="fa fa-newspaper-o fa-fw"></i> Progress Steps</h2>
            <div style="height: 15px"></div>
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Edition</th>
                    <th scope="col">Progress</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">10.02.2021</th>
                    <td>249</td>
                    <td>217</td>
                  </tr>
                </tbody>
              </table>
          </div>
        </div>
      </div>
<!-- End:Biography -->
<br>
<br>



    <!-- End:Publications -->

    </div> <!--End of Container-->

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
    </body>
</html>
