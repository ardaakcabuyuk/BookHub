<?php
include('config.php');
include_once "navbar.php";
require_once "helper_functions.php";
$own_profile = false;
if (isset($_GET['uname'])) {
    if ($_GET['uname'] == $_SESSION['username']) {
        $own_profile = true;
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
    <link rel="stylesheet" href="searchresult.css" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" />
    <link rel="stylesheet" href="js/bootstrap.min.js" />

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>

<body>

<!-- ******HEADER****** -->
<header class="header">
    <div class="container">

        <div class="row justify-content-center" style="margin-top:50px;">
            <div class="col-md-3"> <!-- Image -->
                <p style="text-align:center;"><img src="images/librarian.png" width="200" height="200" alt="Logo"></p>
                <?php
                if ($own_profile) {
                    $user_id = $_SESSION['user_id'];
                    $get_librarian_info_query = "select name, surname, email from librarian natural join User where user_id = '$user_id'";
                    $query_run = mysqli_query($db, $get_librarian_info_query);
                    $librarian = mysqli_fetch_array($query_run);
                    $name = $librarian['name'];
                    $surname = $librarian['surname'];
                    $email = $librarian['email'];
                    $username = $_SESSION['username'];
                    echo "<h4 style=\"text-align: center;\">Librarian</h2>";
                    echo "<br>";
                    echo "<h4 style=\"text-align: center;\"><strong>$name $surname</strong></h2>";
                    echo "<h5 style=\"text-align: center; color:#A9A9A9;\">@$username</h5>";
                    echo "<br>";
                    echo "<h6 style=\"text-align: center;\">e-mail: $email</h6>";
                }
                else {
                    $get_librarian_info_query = "select name, surname, username, email from librarian natural join user where username = '".$_GET['uname']."'";
                    $query_run = mysqli_query($db, $get_librarian_info_query);
                    $librarian = mysqli_fetch_array($query_run);
                    $name = $librarian['name'];
                    $surname = $librarian['surname'];
                    $email = $librarian['email'];
                    $username = $librarian['username'];
                    echo "<h4 style=\"text-align: center;\">Librarian</h2>";
                    echo "<br>";
                    echo "<h4 style=\"text-align: center;\"><strong>$name $surname</strong></h2>";
                    echo "<h5 style=\"text-align: center; color:#A9A9A9;\">@$username</h5>";
                    echo "<br>";
                    echo "<h6 style=\"text-align: center;\">e-mail: $email</h6>";
                }
                ?>
            </div>
        </div>
    </div>

<?php if ($_SESSION['type'] == "librarian") { ?>
  <br>
  <br>
<?php } ?>
<!-- Main container -->
<div class="container">

    <!-- Section:Biography -->
    <?php if ($_SESSION['type'] == "librarian") { ?>
      <div class="row">
          <div class="col-md-12">
              <div class="card card-block text-xs-left" style="border: none;">
                  <h3 class="card-title" style="color:#009688">Erroneous Information Correction Request</h3>
                  <div style="height: 15px"></div>
                  <table class="table">
                      <thead class="thead-dark">
                      <tr>
                          <th scope="col">Date</th>
                          <th scope="col">User</th>
                          <th scope="col">Book</th>
                          <th scope="col"></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $request_query = "select *
                                              from edit_request E natural join user U, Book B
                                              where E.book_id = B.book_id";
                      $query_run = mysqli_query($db, $request_query);
                      while ($row = mysqli_fetch_array($query_run)) {
                          echo "<tr>";
                          echo "<td scope=\"col\">".$row['date']."</th>";
                          echo "<td scope=\"col\">".$row['name']. " " .$row['surname']."</th>";
                          echo "<td><a style=\"color:black; text-decoration: none;\" href=\"bookprofile.php?book_id=".$row['book_id']."\">".$row['book_name']."</a></td>";
                          echo "<td><a href=\"erronousdetails.php?edit_id=".$row['edit_id']."\" class=\"btn btn-outline-success btn-sm pull-right\">Details</a></td>";
                          echo "</tr>";
                      }
                      ?>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
    <?php }
    echo "<br>";
    echo "<br>";
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-block text-xs-left" style="border: none;">
                <h3 class="card-title" style="color:#009688"> Reading Challenges
                  <?php if ($_SESSION['type'] == "librarian") {?>
                    <a href="createchallenge.php" class="btn btn-outline-success btn-sm" style="margin-left:10px;">Create</a></h3>
                  <?php } ?>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Book Count</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $get_librarian_challenges_query = "select *
                                                     from challenge C
                                                     where C.librarian_id = (select L.librarian_id
                                                                             from librarian L natural join user U
                                                                             where username = '".$_GET['uname']."')
                                                     order by C.start_date asc";
                    $get_librarian_challenges = mysqli_query($db, $get_librarian_challenges_query);
                    $i=0;
                    while ($row_challenges = mysqli_fetch_array($get_librarian_challenges)) {
                        echo "<tr >";
                        echo "<th scope = \"row\" >" .$row_challenges['challenge_name']. "</th >";
                        echo "<td >" .formattedDate($row_challenges['start_date']). "</td >";
                        echo "<td >" .formattedDate($row_challenges['end_date']). "</td >";
                        echo "<td >" .$row_challenges['goal']. "</td >";
                        if ($_SESSION['type'] == "librarian") {
                          echo "<td><button type=\"button\" class=\"btn btn-outline-success btn-sm pull-right\" data-toggle=\"modal\" data-target=\"#exampleModalLong$i\">";
                          echo "Details";
                          echo "</button>";
                          echo "<div class=\"modal fade\" id=\"exampleModalLong$i\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLongTitle\" aria-hidden=\"true\">";$i++; ?>
                          <?php
                          echo "<div class=\"modal-dialog\" role=\"document\">";
                          echo "<div class=\"modal-content\">";
                          echo "<div class=\"modal-header\">";
                          echo "<h5 class=\"modal-title\" id=\"exampleModalLongTitle\">Details: '".$row_challenges['challenge_name']."'</h5>";
                          echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
                          echo "<span aria-hidden=\"true\">&times;</span>";
                          echo "</button>";
                          echo "</div>";
                          echo "<div class=\"modal-body\">";
                          echo "<table class=\"table\">";
                          echo "<thead class=\"thead-dark\">";
                          echo "<tr>";
                          echo "<th scope=\"col\">Username</th>";
                          echo "<th scope=\"col\">Progress</th>";
                          echo "</tr>";
                          echo "</thead>";
                          echo "<tbody>";

                          $get_challenge_details_query = "select U.username, P.challlenge_progress, C.challenge_name, C.goal
                                                                               from challenge C inner join participate P on C.challenge_id = P.challenge_id
                                                                               inner join user U on P.user_id = U.user_id
                                                                               where C.challenge_name = '".$row_challenges['challenge_name']."'";
                          $get_challenge_details = mysqli_query($db, $get_challenge_details_query);
                          if (!$get_challenge_details) {
                              printf("Error 1:  %s\n", mysqli_error($db));
                              exit();
                          }
                          while ($row_challenge_details = mysqli_fetch_array($get_challenge_details)) {
                              echo "<tr >";
                              echo "<th scope = \"row\" >" .$row_challenge_details['username']."</th >";
                              echo "<td >" .$row_challenge_details['challlenge_progress']." / ".$row_challenge_details['goal']."</td >";
                              echo "</tr>";
                          }

                          echo "</tbody>";
                          echo "</table>";
                          echo "</div>";
                          echo "<div class=\"modal-footer\">";
                          echo "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button>";

                          echo "</div>";
                          echo "</div>";
                          echo "</div>";
                          echo "</div>";
                          echo "</td>";
                        }
                        else {
                          echo "<td></td>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div> <!--End of Container-->
</header>
<!--End of Header-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
