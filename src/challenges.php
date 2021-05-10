<?php
include('config.php');
include_once "navbar.php";
require_once "helper_functions.php";
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

            <?php
                $challenge_query = "select *
                                    from challenge C 
                                    where C.end_date > CURRENT_DATE";
                $run_query = mysqli_query($db, $challenge_query);

                while($row = mysqli_fetch_array($run_query)) {
                    echo "<div class=\"well search-result\">";
                        echo "<div class=\"row\" >";
                            echo "<div class=\"col-xs-6 col-sm-9 col-md-9 col-lg-10 title\" >";
                                echo "<h3 >" .$row['challenge_name']. "</h3 >";
                                echo "<p style = \"font-size:15px;\" ><span style = \"font-weight: bold;\" > Book Count: </span >" .$row['goal']. "</p >";
                                echo "<p style = \"font-size:15px;\" ><span style = \"font-weight: bold;\" > Deadline: </span >" .formattedDate($row['end_date']). "</p >";


                                echo "<button class=\"btn btn-warning\" type = \"submit\" name = \"join_challenge_button\" value = \"\"" . $_SESSION['user_id'].  ">";
                                echo "Join";
                                echo "</button >";
                                echo "<label class=\"control-label\" style = \"float:right\" ><span style = \"font-weight: bold;\" > Start Date: </span >" .formattedDate($row['start_date']). "</label >";
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
