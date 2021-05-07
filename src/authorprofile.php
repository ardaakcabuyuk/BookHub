<?php
include('config.php');
include_once "navbar.php";
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
</head>

<body>
    <!-- ******HEADER****** -->
      <header class="header">
        <div class="container">

          <div class="row justify-content-center" style="margin-top:20px;">
              <div class="col-md-3"> <!-- Image -->
                <p style="text-align:center;"><img src="./images/writer.png" width="200" height="200" alt="Logo"></p>
                <?php
                if ($own_profile) {
                  $user_id = $_SESSION['user_id'];
                  $get_author_info_query = "select name, surname, email from Author natural join User where user_id = '$user_id'";
                  $query_run = mysqli_query($db, $get_author_info_query);
                  $author = mysqli_fetch_array($query_run);
                  $name = $author['name'];
                  $surname = $author['surname'];
                  $email = $author['email'];
                  $username = $_SESSION['username'];
                  echo "<h4 style=\"text-align: center;\">Author</h2>";
                  echo "<br>";
                  echo "<h4 style=\"text-align: center;\"><strong>$name $surname</strong></h2>";
                  echo "<h5 style=\"text-align: center; color:#A9A9A9;\">@$username</h5>";
                  echo "<br>";
                  echo "<h6 style=\"text-align: center;\">e-mail: $email</h6>";
                }
                else {
                  $get_author_info_query = "select name, surname, username, email from Author natural join User where username = '".$_GET['uname']."'";
                  $query_run = mysqli_query($db, $get_author_info_query);
                  $author = mysqli_fetch_array($query_run);
                  $name = $author['name'];
                  $surname = $author['surname'];
                  $email = $author['email'];
                  $username = $author['username'];
                  echo "<h4 style=\"text-align: center;\">Author</h2>";
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
      </header>
      <!--End of Header-->

        <br>
        <br>
    <!-- Main container -->
      <div class="container">

    <!-- Section:Biography -->
      <div class="row">
            <div class="col-md-12">
              <div class="card card-block text-xs-left">
                <h3 class="card-title" style="color:#009688">Published Books</h2>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Year</th>
                        <th scope="col">Title</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                          if (!$own_profile) {
                            $uname = $_GET['uname'];
                            $get_books_query = "select *
                                                from Book
                                                where author_id = (select author_id
                                                                   from author natural join user
                                                                   where username = '$uname')";
                            $get_books = mysqli_query($db, $get_books_query);

                            while ($row = mysqli_fetch_array($get_books)) {
                              echo "<tr>";
                              echo "<th scope=\"row\">".$row['year']."</th>";
                              echo "<td>".$row['book_name']."</td>";
                              echo "<td><a href=\"#\" class=\"btn btn-outline-success btn-sm\">List Reviews </a></td>";
                              echo "<td><a href=\"#\" class=\"btn btn-outline-success btn-sm\">Create Edition </a></td>";
                              echo "</tr>";
                            }
                          }
                          else {
                            $get_books_query = "select *
                                                from Book
                                                where author_id = (select author_id
                                                                    from author natural join user
                                                                    where user_id = '". $_SESSION['user_id'] . "')";
                            $get_books = mysqli_query($db, $get_books_query);
                            while ($row = mysqli_fetch_array($get_books)) {
                              echo "<tr>";
                              echo "<th scope=\"row\">".$row['year']."</th>";
                              echo "<td>".$row['book_name']."</td>";
                              echo "<td><a href=\"#\" class=\"btn btn-outline-success btn-sm\">List Reviews </a></td>";
                              echo "<td><a href=\"#\" class=\"btn btn-outline-success btn-sm\">Create Edition </a></td>";
                              echo "</tr>";
                            }
                          }
                        ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>

    </div> <!--End of Container-->

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
    </body>
</html>
