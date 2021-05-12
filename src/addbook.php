<?php
#session_start();
require_once "navbar.php";
if(empty($_SESSION['type']) || $_SESSION['type'] != "author") {
  echo "<script type='text/javascript'>alert('Bad credentials!');window.location.href='home.php';</script>";
}
if(isset($_POST['p_button'])) {
  if(empty($_POST['title'])) {
    echo "<script type='text/javascript'>alert('Book title cannot be empty!');window.location.href='addbook.php';</script>";
  }
  if(empty($_POST['desc'])) {
    echo "<script type='text/javascript'>alert('Book description cannot be empty!');window.location.href='addbook.php';</script>";
  }
  if(empty($_POST['year'])) {
    echo "<script type='text/javascript'>alert('Year cannot be empty!');window.location.href='addbook.php';</script>";
  }
  if(empty($_POST['genre'])) {
    echo "<script type='text/javascript'>alert('Genre cannot be empty!');window.location.href='addbook.php';</script>";
  }
  $user_sql = "select * from user where user_id=" . $_SESSION['user_id'];
  $cur_us = mysqli_fetch_array(mysqli_query($db,$user_sql));
  $add_book_sql = "insert into book(book_name, author, genre, year, description, author_id) values(\"" .
  $_POST['title']. "\", \"". $cur_us['name'] . " ". $cur_us['surname']. "\", \"". $_POST['genre']. "\", \"". $_POST['year'].
  "\", \"". $_POST['desc']. "\", \"". $_SESSION['a_id']. "\")";
  echo $add_book_sql;
  mysqli_query($db,$add_book_sql);

  $find_sequel_id_query = "select *
                     from book B
                     where B.book_name = '".$_POST['title']. "'
                     and B.author_id = '".$_SESSION['a_id']."' 
                     and B.genre = '".$_POST['genre']."' 
                     and B.year = '". $_POST['year']."'
                     and B.description = '". $_POST['desc']."'";

  $find_sequel_id = mysqli_query($db, $find_sequel_id_query);
  $row_sequel_id = mysqli_fetch_array($find_sequel_id);

  $add_series_query = "insert into series(sequel_id, original_id, series_name) values(\""
  .$row_sequel_id['book_id']. "\", \"". $_POST['sequel_of'].  "\", \"". $_POST['series_name']. "\")";

  $result_add_series_query = mysqli_query($db, $add_series_query);
  if (!$result_add_series_query) {
      printf("Error 1:  %s\n", mysqli_error($db));
      exit();
  }

  echo "<script type='text/javascript'>alert('New book named ". $_POST['title']. " added for author ". $cur_us['name'] . " ". $cur_us['surname']. "!');window.location.href='authorprofile.php?uname=".$cur_us['username']."';</script>";
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
    <link rel="stylesheet" href="searchresult.css" />

</head>

<body>

    <br/>
    <br/>

    <div class="container col-md-5">
        <form class="form-horizontal" action ="" method="post" role="form">
            <h2>Publish Book</h2>
            <hr>
            <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Title</label>
                <div class="col-sm-13">
                    <input type="text" name="title" id="password" placeholder="Title" class="form-control" autofocus>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Genre</label>
                <div class="col-sm-13">
                    <input type="text" name="genre" id="password" placeholder="Genre" class="form-control" name= "email">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Description</label>
                <div class="col-sm-13">
                    <input type="text" name="desc" id="password" placeholder="Description" class="form-control">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Publication Year</label>
                <div class="col-sm-13">
                    <input type="number" name="year" id="password" placeholder="Year" class="form-control">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Sequel of</label>
                <?php
                echo "<div class=\"col-sm-13\">";
                    echo "<select name=\"sequel_of\" class=\"form-control\">";
                        echo "<option value=\"none\" selected=\"selected\"> None </option>";
                            $get_author_books_query = "select B.book_id, B.book_name
                                                       from book b
                                                       where B.author_id = (select A.author_id
                                                                            from author A
                                                                            where A.user_id = '".$_SESSION['user_id']."')";
                            $get_author_books = mysqli_query($db, $get_author_books_query);
                            while ($row_author_books = mysqli_fetch_array($get_author_books)) {
                                echo "<option value=\"".$row_author_books['book_id']."\">" .$row_author_books['book_name']."</option>";
                            }

                    echo "</select>";
                echo "</div>";
                 ?>
            </div>
            <br>
            <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Series Name</label>
                <div class="col-sm-13">
                    <input type="text" name="series_name" id="password" placeholder="Series Name" class="form-control">
                </div>
            </div>
            <br>
            <button type="submit" name="p_button" class="btn btn-primary btn-warning btn-lg pull-right">Publish</button>

            <br>
            <br>
        </form> <!-- /form -->
    </div> <!-- ./container -->



    </body>
</html>
