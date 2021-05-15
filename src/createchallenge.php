<?php
#session_start();
require_once "navbar.php";
if(empty($_SESSION['type']) || $_SESSION['type'] != "librarian") {
    echo "<script type='text/javascript'>alert('Bad credentials!');window.location.href='home.php';</script>";
}
if(isset($_POST['p_button'])) {
    if(empty($_POST['goal'])) {
        echo "<script type='text/javascript'>alert('Goal cannot be empty! ".$_SESSION['user_id']."');window.location.href='createchallenge.php';</script>";
    }
    if(empty($_POST['challenge_name'])) {
        echo "<script type='text/javascript'>alert('Challenge name cannot be empty!');window.location.href='createchallenge.php';</script>";
    }
    if(empty($_POST['start_date'])) {
        echo "<script type='text/javascript'>alert('Start date cannot be empty!');window.location.href='createchallenge.php';</script>";
    }
    if(empty($_POST['end_date'])) {
        echo "<script type='text/javascript'>alert('End date cannot be empty!');window.location.href='createchallenge.php';</script>";
    }

    $find_librarian = "select *
                       from librarian L
                       where L.user_id = '".$_SESSION['user_id']. "'";
    $result_find_librarian = mysqli_query($db, $find_librarian);
    if (!$result_find_librarian) {
        printf("Error 1:  %s\n", mysqli_error($db));
        exit();
    }
    $row = mysqli_fetch_array($result_find_librarian);

    $create_challenge_query = "insert into challenge(challenge_name, start_date, end_date, goal, librarian_id) values(
        \"". addslashes($_POST['challenge_name']). "\", \"". $_POST['start_date']. "\", \"". $_POST['end_date']. "\", \"". $_POST['goal']. "\", \"". $row['librarian_id']. "\")";
    $result_create_challenge_query = mysqli_query($db,$create_challenge_query);
    if (!$result_create_challenge_query) {
        printf("Error 2: %s\n", mysqli_error($db));
        exit();
    }
    echo "<script type='text/javascript'>alert('New challenge named ". $_POST['challenge_name']. " added !');window.location.href='librarianprofile.php?uname=".$_SESSION['username']."';</script>";
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
        <h2>Create Challenge</h2>
        <hr>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Goal</label>
            <div class="col-sm-13">
                <input type="number" name="goal" id="password" placeholder="Goal" class="form-control" autofocus>
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Challenge Name</label>
            <div class="col-sm-13">
                <input type="text" name="challenge_name" id="password" placeholder="Challenge Name" class="form-control" name= "email">
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Start Date</label>
            <div class="col-sm-13">
                <input type="date" name="start_date" id="password" placeholder="Start Date" class="form-control">
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">End Date</label>
            <div class="col-sm-13">
                <input type="date" name="end_date" id="password" placeholder="End Date" class="form-control">
            </div>
        </div>
        <br>
        <button type="submit" name="p_button" class="btn btn-primary btn-warning btn-lg pull-right">Create</button>

        <br>
        <br>
    </form> <!-- /form -->
</div> <!-- ./container -->



</body>
</html>
