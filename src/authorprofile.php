<?php
include('config.php');
session_start();

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

    <div class="container-fluid">

        <script src="js/bootstrap.js"></script>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php"><img alt="Qries" src="logo.png"
                    width="150" height="70"></a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="home.php">Home Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Challenges</a>
                        </li>
                        <li class="nav-item">
                          <?php
                          session_start();
                          $user_id = $_SESSION['user_id'];
                          $author_check_sql = "select * from Author where user_id = '$user_id'";
                          $author = mysqli_query($db, $author_check_sql);

                          $librarian_check_sql = "select * from Librarian where user_id = '$user_id'";
                          $librarian = mysqli_query($db, $librarian_check_sql);

                          if(mysqli_num_rows($author) == 1) {
                            echo "<a class=\"nav-link active\" href=\"./authorprofile.php\">Profile ( Arda Akça Büyük )</a>";
                          }
                          else if(mysqli_num_rows($librarian) == 1) {
                            echo "<a class=\"nav-link active\" href=\"./librarianprofile.php\">Profile ( Arda Akça Büyük )</a>";
                          }
                          else {
                            echo "<a class=\"nav-link active\" href=\"./userprofile.php\">Profile ( Arda Akça Büyük )</a>";
                          }
                          ?>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-outline-success" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <!-- ******HEADER****** -->
      <header class="header">
        <div class="container">

            <div class="row justify-content-center" style="margin-top:20px;">
                <div class="col-md-3"> <!-- Image -->
                  <p style="text-align:center;"><img src="./images/ben.jpg" alt="Logo"></p>
                  <h4 style="text-align: center;"><strong>Emin Adem Buran</strong> - Author</h2>
                  <h5 style="text-align: center;"><strong>@username </strong></h5>
                  <h5 style="text-align: center;"> ademsan99@gmail.com</h5>
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
                      <tr>
                        <th scope="row">2011</th>
                        <td>A Dance with Dragons</td>
                        <td><a href="#" class="btn btn-outline-success btn-sm">List Reviews </a></td>
                        <td><a href="#" class="btn btn-outline-success btn-sm">Create Edition </a></td>
                      </tr>
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
