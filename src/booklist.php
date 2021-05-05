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
                    <a class="navbar-brand" href="#"><img alt="Qries" src="logo.png"
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

        <header class="header">
            <div class="container">

                <div class="row justify-content-center" style="margin-top:20px;">
                    <div class="col-md-3"> <!-- Image -->
                      <h5 style="text-align: center;"> <strong> Kitap Listesinin İsmi</strong></h2>
                      <h5 style="text-align: center;">Readlist by <strong> Emin Adem Buran</strong></h2>
                    </div>
                  </div>
            </div>
        </header>


        <div class="container bootstrap snippets bootdey">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <br/>
                    <br/>
                    <hr>

                    <div class="well search-result">
                        <div class="row">

                            <div class="col-xs-6 col-sm-9 col-md-9 col-lg-10 title">

                                <h3>BookHub Book Bayilerde</h3>
                                <h5>by Muzaffer Muzo</h3>
                                <h5>2002-222 Edition</h3>

                                <span class="fa fa-star checked"></span>  <!--Parlak yıldızlar için bunu kullanıcaz-->
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span><!--Parlak olmayan yıldızlar için bunu kullanıcaz-->
                                <span class="fa fa-star"></span>
                                <label>Average Ratings (3.2)</label>
                                <br>
                                <br>
                                <div class="btn-group me-2" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-primary">1</button>
                                    <button type="button" class="btn btn-primary">2</button>
                                    <button type="button" class="btn btn-primary">3</button>
                                    <button type="button" class="btn btn-primary">4</button>
                                    <button type="button" class="btn btn-primary">5</button>
                                    <label>Rate this Book</label>
                                </div>
                                <br/>
                                <br/>
                                <a href="#link" class="btn btn-info" role="button">Track</a>

                            </div>
                        </div>
                    </div>

                    <hr>

                </div>
            </div>
        </div>

    </body>

</html>
