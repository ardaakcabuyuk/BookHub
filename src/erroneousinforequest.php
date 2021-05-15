<?php
include('config.php');
include_once "navbar.php";
if (isset($_GET['book_id']) & isset($_GET['edition_no'])) {
  $book_id = $_GET['book_id'];
  $edition_no = $_GET['edition_no'];
  $book_query = "select * from book natural join edition where book_id = $book_id and edition_no = $edition_no";
  $book = mysqli_fetch_array(mysqli_query($db, $book_query));
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
        <form class="form-inline" method="POST" action="request.php">
            <h2>Erroneous Information Request</h2>
            <?php
              echo "<h5><strong>".$book['book_name']."</strong> by <strong>".$book['author']."</strong></h5>";
            ?>
            <br>
            <div class="row">
              <div class="col">
                  <label for="title" class="col-xs-6 control-label">Title</label>
                  <?php
                    echo "<input type=\"text\" value=\"".$book['book_name']."\" id=\"title\" name=\"title\" placeholder=\"Title\" class=\"form-control input-group-lg\" autofocus>";
                  ?>
              </div>
              <div class="col">
                  <label for="edition" class="col-xs-6 control-label">Edition No</label>
                  <?php
                    echo "<input type=\"text\" value=\"$edition_no\" id=\"edition\" name=\"edition\" placeholder=\"Edition\" class=\"form-control input-group-lg\">";
                  ?>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                  <label for="author" class="col-xs-6 control-label">Author</label>
                  <input type="text" value= "<?php echo $book['author'];?>" id="email" name="author" placeholder="Author" class="form-control input-group-lg">
              </div>
              <div class="col">
                  <label for="Height" class="col-xs-6 control-label">Publisher </label>
                  <input type="text" value= "<?php echo $book['publisher'];?>" id="height" name="publisher" placeholder="Publisher" class="form-control input-group-lg">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label for="password" class="col-xs-6 control-label">Genre</label>
                <input type="text" value= "<?php echo $book['genre'];?>" id="password" name="genre" placeholder="Genre" class="form-control input-group-lg">
              </div>
              <div class="col">
                <label for="weight" class="col-xs-6 control-label">Language</label>
                <input type="text" value= "<?php echo $book['language'];?>" id="weight" name="language" placeholder="Language" class="form-control input-group-lg">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label for="password" class="col-xs-6 control-label">Year</label>
                <input type="text" value= "<?php echo $book['year'];?>" id="password" name="year" placeholder="Year" class="form-control input-group-lg">
              </div>
              <div class="col">
                <label for="weight" class="col-xs-6 control-label">Page Count</label>
                <input type="text" value= "<?php echo $book['page_count'];?>" id="weight" name="page_count" placeholder="Page Count" class="form-control input-group-lg">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label for="password" class="col-xs-6 control-label">Format</label>
                <input type="text" value= "<?php echo $book['format'];?>" id="password" name="format"placeholder="Format" class="form-control input-group-lg">
              </div>
              <div class="col">
                <label for="weight" class="col-xs-6 control-label">Translator</label>
                <input type="text" value= "<?php echo $book['translator'];?>" id="weight" name="translator" placeholder="Translator" class="form-control input-group-lg">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label for="weight" class="col-xs-6 control-label">Additional Note</label>
                <input type="text" id="weight" value=" " name="additional" placeholder="Additional Note" class="form-control">
              </div>
            </div>
            <br>
            <?php
              echo "<button type=\"submit\" name=\"request_button\" value=\"bookprofile.php"."-".$book_id."-".$edition_no."\"class=\"btn btn-warning pull-right\">Request</button>";
            ?>
            <br>
            <br>
        </form> <!-- /form -->
    </div> <!-- ./container -->



    </body>
</html>
