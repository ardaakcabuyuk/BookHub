<?php
include('config.php');
include_once "navbar.php";
if (isset($_GET['edit_id'])) {
  $edit_id = $_GET['edit_id'];
  $req_sql = "select * from edit_request E natural join User U, book B where edit_id=$edit_id and B.book_id=E.book_id";

  $edit = mysqli_fetch_array(mysqli_query($db,$req_sql));

}
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <title>BookHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="js/bootstrap.bundle.js">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="searchresult.css" />

</head>

<body>
  <br>
    <div class="container">
        <form class="form-inline" method="POST" action="actionreq.php">
            <h2>Erroneous Information Request from <?php echo " ". $edit['name']. " ". $edit['surname']; ?></h2>
            <?php
              echo "<h5><strong>".$edit['book_name']."</strong> by <strong>".$edit['author']." Edition no: ". $edit['old_edition_no']. "</strong></h5>";
            ?>
            <br>
            <div class="row">
              <div class="col">
                  <label for="title" class="col-xs-6 control-label">Requested Title</label>
                  <?php
                    echo "<p id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control\">". $edit['new_book_name']. " </p>";
                  ?>
              </div>
              <div class="col">
                  <label for="edition" class="col-xs-6 control-label">Requested Edition No</label>
                  <?php
                    echo "<p id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control\">". $edit['new_book_edition_no']. " </p>";
                  ?>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                  <label for="author" class="col-xs-6 control-label">Requested Author Name</label>
                  <?php
                    echo "<p id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control\">". $edit['new_book_author']. " </p>";
                  ?>
              </div>
              <div class="col">
                  <label for="Height" class="col-xs-6 control-label">Requested Publisher </label>
                  <?php
                    echo "<p id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control\">". $edit['new_book_publisher']. " </p>";
                  ?>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label for="password" class="col-xs-6 control-label">Requested Genre</label>
                <?php
                  echo "<p id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control\">". $edit['new_book_genre']. " </p>";
                ?>
              </div>
              <div class="col">
                <label for="weight" class="col-xs-6 control-label">Requested Language</label>
                <?php
                  echo "<p id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control\">". $edit['new_book_language']. " </p>";
                ?>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label for="password" class="col-xs-6 control-label">Requested Year</label>
                <?php
                  echo "<p id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control\">". $edit['new_book_year']. " </p>";
                ?>
              </div>
              <div class="col">
                <label for="weight" class="col-xs-6 control-label">Requested Page Count</label>
                <?php
                  echo "<p id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control\">". $edit['new_book_page_count']. " </p>";
                ?>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label for="password" class="col-xs-6 control-label">Requested Format</label>
                <?php
                  echo "<p id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control\">". $edit['new_book_format']. " </p>";
                ?>
              </div>
              <div class="col">
                <label for="weight" class="col-xs-6 control-label">Requested Translator</label>
                <?php
                  echo "<p id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control\">". $edit['new_book_translator']. " </p>";
                ?>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label for="weight" class="col-xs-6 control-label">Additional Notes</label>
                <?php
                  echo "<p id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control\">". $edit['additional_notes']. " </p>";
                ?>
              </div>
            </div>
            <br>
            <?php
              echo "<button type=\"submit\" style=\"margin-left:20px;\"name=\"reject\" value=\"$edit_id\" class=\"btn btn-outline-danger pull-right\">Reject</button>";
              echo "<button type=\"submit\" name=\"confirm\" value=\"$edit_id\" class=\"btn btn-outline-success pull-right\">Confirm</button>";
            ?>
            <br>
            <br>
        </form> <!-- /form -->
    </div> <!-- ./container -->



    </body>
</html>
