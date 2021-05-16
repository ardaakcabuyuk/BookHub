<?php
include('config.php');
include_once "navbar.php";
include_once "bookheader.php";

if (isset($_GET['book_id'])) {
  $book_id = $_GET['book_id'];
  $user_id = $_SESSION['user_id'];

  if (isset($_POST['addProgressButton'])) {
    list($edition_no, $page_count) = explode("-", $_POST['addProgressButton'], 2);
    $page_no = $_POST['pageno'];
    $add_progress_query = "insert into reads_book (book_id, edition_no, user_id, progress)
                            values ($book_id, $edition_no, ".$_SESSION['user_id'].", $page_no)";
    $update_challenge_progress = "update participate P
                                  set P.challlenge_progress = P.challlenge_progress +1
                                  where P.user_id = ".$_SESSION['user_id'] ." and exists (select *
                                                from book B natural join edition E
                                                where B.book_id = " .$book_id."
                                                and E.edition_no = " .$edition_no ."
                                                and E.page_count = " .$page_no.")
                                                and P.challenge_id in (select C.challenge_id
                                                                      from challenge C
                                                                      where C.end_date > CURRENT_DATE)";
    $result_update_challenge_progress = mysqli_query($db, $update_challenge_progress);

    $read = false;
    $read_sql = "select * from reads_book natural join edition where user_id = $user_id and edition_no = $edition_no and book_id = $book_id and page_count = progress";
    $read_query = mysqli_query($db,$read_sql);

    if(mysqli_num_rows($read_query) != 0) {
      $read = true;
    }

    if(!$result_update_challenge_progress) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }

    if ($page_no < 0 || $page_no > $page_count || $read) {
      echo "<script type='text/javascript'>alert('Bad credentials!');window.location.href='bookprofile.php?book_id=$book_id';</script>";
    }
    else {
      $query_run = mysqli_query($db, $add_progress_query);
    }
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Main container -->
      <div class="container">

    <!-- Section:Biography -->
      <div class="row">
            <div class="col-md-12">
              <div class="card card-block text-xs-left" style="border:none;">
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
                        $i = 0;
                        while ($edition = mysqli_fetch_array($edition_run)) {
                          echo "<tr>";
                          $read = false;
                          $read_sql = "select * from reads_book natural join edition where user_id = $user_id and edition_no =". $edition['edition_no'] ." and book_id = $book_id and page_count = progress";
                          $read_query = mysqli_query($db,$read_sql);

                          if(mysqli_num_rows($read_query) != 0) {
                            $read = true;
                          }
                            echo "<th scope=\"row\">".$edition['edition_no']."</th>";
                            echo "<td>".$edition['publisher']."</td>";
                            echo "<td>".$edition['page_count']."</td>";
                            echo "<td>".$edition['format']."</td>";
                            echo "<td>".$edition["language"]."</td>";
                            if ($_SESSION['type'] != "librarian") {
                              echo "<td>";
                              echo "<div class=\"button\">";
                                  echo "<a href=\"erroneousinforequest.php?book_id=".$book_id."&edition_no=".$edition['edition_no']."\" class=\"btn btn-sm btn-outline-success pull-right\">Erroneous Info Request</a>";
                                  if ($_SESSION['type'] == "user" && !$read) echo "<button type=\"button\" data-toggle=\"modal\" data-target=\"#addProgress$i\" class=\"btn btn-outline-success btn-sm pull-right\" style=\"margin-right:10px;\">Add Progress</button>";
                              echo "</div>";
                              echo "</td>";
                            }
                          echo "</tr>";
                          echo "<div class=\"modal fade\" id=\"addProgress$i\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"addProgressLabel\" aria-hidden=\"true\">"; $i++; ?>
                            <form id="add_form" action="" method="POST">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="addProgressLabel">Add Progress</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                            		    <label for="pageno">Page Number</label><br/>
                            		    <input type="text" class="form-control" id="pageno" name="pageno" required/><br/>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="addProgressButton" value="<?php echo $edition['edition_no']. "-" . $edition['page_count']; ?>" class="btn btn-success">Add</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                      <?php } ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
    <!-- End:Biography -->
    <br>
    <br>
    <?php
      if($_SESSION['type'] == "user") {
     ?>
    <div class="row">
        <div class="col-md-12">
          <div class="card card-block text-xs-left" style="border:none;">
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

                    <?php
                    $progress_query = "select * from reads_book where user_id =".$_SESSION['user_id']." and book_id = $book_id order by date desc";
                    $query_run = mysqli_query($db, $progress_query);
                    while ($row = mysqli_fetch_array($query_run)) {
                      echo "<tr>";
                      echo "<th scope=\"row\">".$row['date']."</th>";
                      echo "<td>".$row['edition_no']."</td>";
                      echo "<td>".$row['progress']."</td>";
                      echo "</tr>";
                    }
                    ?>
                </tbody>
              </table>
          </div>
        </div>
      </div>
      <?php
        } 
       ?>
      <br>
      <br>
      <?php
        $sequel_query = "select *
                        from series inner join book
                        on series.sequel_id = book.book_id
                        where original_id = $book_id
                        order by year asc";
        $query_run = mysqli_query($db, $sequel_query);
        if(mysqli_num_rows($query_run) != 0) {
        echo "<div class=\"row\">";
          echo "<div class=\"col-md-12\">";
            echo "<div class=\"card card-block text-xs-left\" style=\"border:none;\">";
              echo "<h2 class=\"card-title\" style=\"color:#009688\">Sequels</h2>";
              echo "<div style=\"height: 15px;\"></div>";
              echo "<table class=\"table\">";
                  echo "<thead class=\"thead-dark\">";
                    echo "<tr>";
                      echo "<th scope=\"col\">Year</th>
                      <th scope=\"col\">Series Name</th>
                      <th scope=\"col\">Title</th>
                      <th scope=\"col\">Author</th>
                    </tr>
                  </thead>
                  <tbody>";
                      while ($row = mysqli_fetch_array($query_run)) {
                        echo "<tr>";
                        echo "<th scope=\"row\">".$row['year']."</th>";
                        echo "<td>".$row['series_name']."</td>";
                        echo "<td><a style=\"color:black; text-decoration: none;\" href=\"bookprofile.php?book_id=".$row['book_id']."\">".$row['book_name']."</a></td>";
                        echo "<td>".$row['author']."</td>";
                        echo "</tr>";
                      }
                      echo "</tbody>";
                    echo "</table>";
                echo "</div>";
              echo "</div>";
            echo "</div>";
            }
            ?>
        <?php
          $orig_query = "select *
                          from series inner join book
                          on series.original_id = book.book_id
                          where sequel_id = $book_id
                          order by year asc";
          $query_rrun = mysqli_query($db, $orig_query);
          if(mysqli_num_rows($query_rrun) != 0) {
          echo "<div class=\"row justify-content-center\">";
            echo "<div class=\"col-md-12\">";
              echo "<div class=\"card card-block text-xs-left\" style=\"border:none;\">";
                echo "<h2 class=\"card-title\" style=\"color:#009688\">Sequel Of</h2>";
                echo "<div style=\"height: 15px;\"></div>";
                echo "<table class=\"table\">";
                    echo "<thead class=\"thead-dark\">";
                      echo "<tr>";
                        echo "<th scope=\"col\">Year</th>
                        <th scope=\"col\">Series Name</th>
                        <th scope=\"col\">Title</th>
                        <th scope=\"col\">Author</th>
                      </tr>
                    </thead>
                    <tbody>";
                        /*$sequel_query = "select *
                                        from series inner join book
                                        on series.sequel_id = book.book_id
                                        where original_id = $book_id
                                        order by year asc";
                        $query_run = mysqli_query($db, $sequel_query);*/
                        while ($row = mysqli_fetch_array($query_rrun)) {
                          echo "<tr>";
                          echo "<th scope=\"row\">".$row['year']."</th>";
                          echo "<td>".$row['series_name']."</td>";
                          echo "<td><a style=\"color:black; text-decoration: none;\" href=\"bookprofile.php?book_id=".$row['book_id']."\">".$row['book_name']."</a></td>";
                          echo "<td>".$row['author']."</td>";
                          echo "</tr>";
                        }

                    echo "</tbody>";
                  echo "</table>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
          }
          ?>
<!-- End:Biography -->
<br>
<br>



    <!-- End:Publications -->

    </div> <!--End of Container-->

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
    </body>
</html>
