<?php
include('config.php');

include_once "navbar.php";

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
          <?php  ?>
            <div class="row justify-content-center" style="margin-top:20px;">
                <div class="col-md-3"> <!-- Image -->
                  <p style="text-align:center;"><img src="./images/ben.jpg" alt="Logo"></p>
                  <h4 style="text-align: center;"><strong>Emin Adem Buran</strong> - User</h2>
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
                <h3 class="card-title" style="color:#009688">Currently Reading</h2>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Last Update</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Edition</th>
                        <th scope="col">Page</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">01.04.2021</th>
                        <td>1984</td>
                        <td>George Orwell</td>
                        <td>174</td>
                        <td>54</td>
                        <td><a href="#" class="btn btn-outline-success btn-sm">Edit </a></td>
                      </tr>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
    <!-- End:Biography -->
    <br>
    <br>

    <div class="row">
        <div class="col-md-12">
          <div class="card card-block text-xs-left">
            <h3 class="card-title" style="color:#009688"> Read</h3>
            <div style="height: 15px"></div>
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Finished</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">10.02.2021</th>
                    <td>Heidi</td>
                    <td>Johanna Spyri</td>
                    <td>
                        <span class="fa fa-star checked"></span>  <!--Parlak yıldızlar için bunu kullanıcaz-->
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span><!--Parlak olmayan yıldızlar için bunu kullanıcaz-->
                        <span class="fa fa-star"></span>
                    </td>
                    <td><a href="#" class="btn btn-outline-success btn-sm">Post Review </a></td>
                  </tr>
                </tbody>
              </table>
          </div>
        </div>
      </div>
<!-- End:Biography -->
<br>
<br>
    <div class="row">
        <div class="col-md-12">
        <div class="card card-block text-xs-left">
            <h3 class="card-title" style="color:#009688"> Posts</h3>
            <div style="height: 15px"></div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Last Update</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Likes</th>
                    <th scope="col">Comments</th>
                    <th scope="col">Ratings</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">10.02.2021</th>
                    <td>Heidi</td>
                    <td>Johanna Spyri</td>
                    <td>27</td>
                    <td>3</td>
                    <td>3/5</td>
                </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <!-- End:Biography -->
    <br>
    <br>

    <div class="row">
        <div class="col-md-12">
        <div class="card card-block text-xs-left">
            <h3 class="card-title" style="color:#009688"> Book Lists</h3>
            <div style="height: 15px"></div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Last Update</th>
                    <th scope="col">Name</th>
                    <th scope="col">Number of Books</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">01.04.2021</th>
                    <td>Classics</td>
                    <td>21</td>
                    <td><a href="booklist.php" class="btn btn-outline-success btn-sm">Show Booklist</a></td>
                </tr>
                </tbody>
            </table>
            <a href="#" class="btn btn-outline-success btn-sm">Create </a>

        </div>
        </div>
    </div>
    <!-- End:Biography -->
    <br>
    <br>

        <div class="row">
            <div class="col-md-12">
            <div class="card card-block text-xs-left">
                <h3 class="card-title" style="color:#009688"> Friends</h3>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">Onur Oruç</th>
                    </tr>
                    </tbody>
                </table>
                <a href="#" class="btn btn-outline-success btn-sm">Add </a>

            </div>
            </div>
        </div>

        <br>
        <br>

        <div class="row">
            <div class="col-md-12">
            <div class="card card-block text-xs-right">
                <h3 class="card-title" style="color:#009688"> Challenges Succeeded</h3>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Book Count</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">Bozcaada'nın En Hızlı Üzümü</th>
                        <td>32</td>
                    </tr>
                    </tbody>
                </table>


            </div>
            </div>
        </div>



    <!-- End:Publications -->

    </div> <!--End of Container-->

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
    </body>
</html>
