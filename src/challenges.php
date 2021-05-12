<?php
include('config.php');
include_once "navbar.php";
require_once "helper_functions.php";
if(isset($_POST['join_challenge_button'])) {
    $user_id = $_SESSION['user_id'];
    $challenge_id = $_POST['join_challenge_button'];
    $join_challenge_query = "insert into participate (challenge_id, user_id, challlenge_progress)
                             values($challenge_id, $user_id, 0)";
    mysqli_query($db, $join_challenge_query);
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

<h2 style="text-align: center;">Challenges</h2>
<hr>
<div class="container bootstrap snippets bootdey">

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <br/>
            <br/>
            <form class="form-inline" action="challenges.php" method="post">
            <?php
                $challenge_query = "select *
                                    from challenge C 
                                    where C.end_date > CURRENT_DATE
                                    order by C.start_date asc";
                $run_query = mysqli_query($db, $challenge_query);

                while($row = mysqli_fetch_array($run_query)) {
                    $started_query = "select *
                                      from challenge C
                                      where C.challenge_id = " . $row['challenge_id'] . " 
                                      and C.start_date > CURRENT_DATE";
                    echo "<div class=\"well search-result\">";
                        echo "<div class=\"row\" >";
                            echo "<div class=\"col-xs-6 col-sm-9 col-md-9 col-lg-10 title\" >";
                                echo "<h3 >" .$row['challenge_name']. "</h3 >";
                                echo "<p style = \"font-size:15px;\" ><span style = \"font-weight: bold;\" > Book Count: </span >" .$row['goal']. "</p >";
                                echo "<p style = \"font-size:15px;\" ><span style = \"font-weight: bold;\" > Deadline: </span >" .formattedDate($row['end_date']). "</p >";

                            echo "<form action=\"\" method=\"post\">";
                            $joined = "select * 
                                       from participate P
                                       where P.challenge_id = " . $row['challenge_id'] . " and P.user_id = " . $_SESSION['user_id'];
                            $result = mysqli_query($db, $joined);
                            $succeeded = "select * 
                                          from participate P natural join challenge C
                                          where P.challenge_id = " . $row['challenge_id'] . " 
                                          and P.user_id = " . $_SESSION['user_id'] . "
                                          and P.challlenge_progress >= C.goal ";
                            $result_succeeded = mysqli_query($db, $succeeded);
                            if (mysqli_num_rows($result) == 0) {
                                $result_started = mysqli_query($db, $started_query);
                                if (mysqli_num_rows($result_started) == 0) {
                                    echo "<button class=\"btn btn-warning\" type = \"submit\" name = \"join_challenge_button\" value = \"" . $row['challenge_id'] . "\">";
                                    echo "Join";
                                    echo "</button >";
                                }
                            } else {
                                $fetch_progress = mysqli_fetch_array($result);
                                echo "<p style = \"font-size:15px;\" ><span style = \"font-weight: bold;\" > Progress: </span >" . $fetch_progress['challlenge_progress'] . " / " . $row['goal'] . " </p >";
                                if (mysqli_num_rows($result_succeeded) == 0) {
                                    echo "<button class=\"btn btn-info\" name = \"already_joined_button\" value = \"\"" . $_SESSION['user_id'] . ">";
                                    echo "Joined";
                                    echo "</button >";
                                }
                            }
                            if (mysqli_num_rows($result_succeeded) != 0) {
                                echo "<button class=\"btn btn-success\" name = \"challenge_completed_button\" value = \"\"" . $_SESSION['user_id'] . ">";
                                echo "Completed";
                                echo "</button >";
                            }
                            echo "<label class=\"control-label\" style = \"float:right\" ><span style = \"font-weight: bold;\" > Start Date: </span >" . formattedDate($row['start_date']) . "</label >";
                            echo "</form>";

                            echo "</div >";
                        echo "</div >";
                    echo "</div >";
                    echo "<hr >";
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>
