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
    <link rel="stylesheet" href="js/bootstrap.bundle.js">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/searchresult.css" />
</head>

<body>
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
                        <th scope="col"></th>
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
                            if ($_SESSION['type'] != "librarian") {
                              echo "<td>";
                              echo "<div class=\"button\">";
                                  echo "<a href=\"erroneousinforequest.php?book_id=".$book_id."&edition_no=".$edition['edition_no']."\" class=\"btn btn-sm btn-outline-success pull-right\">Erroneous Info Request</a>";
                              echo "</div>";
                              echo "</td>";
                            }
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
            <h2 class="card-title" style="color:#009688"><i class="fa fa-newspaper-o fa-fw"></i> Progress Steps<?php
            if ($_SESSION['type'] == "user") echo "<a href=\"#\" class=\"btn btn-outline-success btn-sm\" style=\"margin-left:10px;\">Add Progress</a>"?></h2>
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
