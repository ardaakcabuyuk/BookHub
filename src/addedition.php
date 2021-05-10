<?php
#session_start();
require_once "navbar.php";
if(empty($_SESSION['type']) || $_SESSION['type'] != "author") {
    echo "<script type='text/javascript'>alert('Bad credentials!');window.location.href='addbook.php';</script>";
}
if(isset($_GET['book_id'])) {
    $book_id_glb = $_GET['book_id'];
}
if(isset($_POST['p_button'])) {
    if(empty($_POST['genre'])) {
        echo "<script type='text/javascript'>alert('Genre cannot be empty!');window.location.href='addedition.php';</script>";
    }
    if(empty($_POST['year'])) {
        echo "<script type='text/javascript'>alert('Year cannot be empty!');window.location.href='addedition.php';</script>";
    }
    if(empty($_POST['pcount'])) {
        echo "<script type='text/javascript'>alert('Page count cannot be empty!');window.location.href='addedition.php';</script>";
    }
    if(empty($_POST['eno'])) {
        echo "<script type='text/javascript'>alert('Edition no cannot be empty!');window.location.href='addedition.php';</script>";
    }
    if(empty($_POST['publisher'])) {
        echo "<script type='text/javascript'>alert('Publisher cannot be empty!');window.location.href='addedition.php';</script>";
    }
    if(empty($_POST['language'])) {
        echo "<script type='text/javascript'>alert('Language cannot be empty!');window.location.href='addedition.php';</script>";
    }
    if(empty($_POST['format'])) {
        echo "<script type='text/javascript'>alert('Format cannot be empty!');window.location.href='addedition.php';</script>";
    }
    $photo = 1010;
    $add_edition_sql = "insert into edition(book_id, page_count, publisher, language, format, cover_photo, translator) values(\"" .
        $book_id_glb. "\", \"". $_POST['pcount']. "\", \"". $_POST['publisher']. "\", \"".$_POST['language']. "\", \"".$_POST['format'].
        "\", \"" . $photo. "\", \"". $_POST['translator']. "\")";
    echo $add_edition_sql;
    $query_result = mysqli_query($db,$add_edition_sql);
    if(!$query_result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    echo "<script type='text/javascript'>alert('New edition added for book id ". $book_id_glb. "!');window.location.href='addedition.php';</script>";
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
        <h2>Add Edition</h2>
        <hr>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Genre</label>
            <div class="col-sm-9">
                <input type="text" name = "genre" id="password" placeholder="Genre" class="form-control">
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Year</label>
            <div class="col-sm-9">
                <input type="date" name = "year" id="birthDate" class="form-control">
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="birthDate" class="col-sm-3 control-label">Page Count</label>
            <div class="col-sm-9">
                <input type="text" name = "pcount" id="password" placeholder="Page Count" class="form-control">
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="phoneNumber" class="col-sm-3 control-label">Edition No </label>
            <div class="col-sm-9">
                <input type="text" name = "eno" id="password" placeholder="Edition No" class="form-control">
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="Height" class="col-sm-3 control-label">Publisher </label>
            <div class="col-sm-9">
                <input type="text" name = "publisher" id="height" placeholder="Publisher" class="form-control">
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="weight" class="col-sm-3 control-label">Language</label>
            <div class="col-sm-9">
                <input type="text" name = "language" id="weight" placeholder="Language" class="form-control">
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="weight" class="col-sm-3 control-label">Format</label>
            <div class="col-sm-9">
                <input type="text" name = "format" id="weight" placeholder="Format" class="form-control">
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="weight" class="col-sm-3 control-label">Translator</label>
            <div class="col-sm-9">
                <input type="text" name = "translator" id="weight" placeholder="Translator" class="form-control">
            </div>
        </div>
        <br>

        <br>

        <button type="submit" name = "p_button" class="btn btn-primary btn-block col-md-9">Done</button>

        <br>
        <br>
    </form> <!-- /form -->
</div> <!-- ./container -->



</body>
</html>