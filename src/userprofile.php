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
              <p style="text-align:center;"><img src="./images/reader.png" alt="Logo" height="200"></p>
              <?php
              if ($own_profile) {
                $user_id = $_SESSION['user_id'];
                $get_user_info_query = "select name, surname, email from User where user_id = '$user_id'";
                $query_run = mysqli_query($db, $get_user_info_query);
                $user = mysqli_fetch_array($query_run);
                $name = $user['name'];
                $surname = $user['surname'];
                $email = $user['email'];
                $username = $_SESSION['username'];
                echo "<h4 style=\"text-align: center;\"><strong>$name $surname</strong> - User</h2>";
                echo "<h5 style=\"text-align: center;\"><strong>@$username</strong></h5>";
                echo "<h5 style=\"text-align: center;\">$email</h5>";
              }
              else {
                $get_user_info_query = "select name, surname, username, email from User where username = '".$_GET['uname']."'";
                $query_run = mysqli_query($db, $get_user_info_query);
                $user = mysqli_fetch_array($query_run);
                $name = $user['name'];
                $surname = $user['surname'];
                $email = $user['email'];
                $username = $user['username'];
                echo "<h4 style=\"text-align: center;\"><strong>$name $surname</strong> - User</h2>";
                echo "<h5 style=\"text-align: center;\"><strong>@$username</strong></h5>";
                echo "<h5 style=\"text-align: center;\">$email</h5>";
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
                      <?php
                      $reads_sql = "select * from reads_book R where R.user_id = $user_id ".
                       "and R.progress < (select E.page_count from edition E where E.edition_no = R.edition_no and E.book_id = R.book_id)";
                      $reads_user = mysqli_query($db, $reads_sql);
                      while( $row = mysqli_fetch_array($reads_user)) {
                      $current_book_sql = "select * from book natural join edition where book_id =" . $row['book_id'];
                      $row_book = mysqli_fetch_array(mysqli_query($db, $current_book_sql));
                      echo "<tr>";
                      echo "<th scope=\"row\">". $row['date']. "</th>";
                      echo "<td>". $row_book['book_name']. "</td>";
                      echo "<td>". $row_book['author']. "</td>";
                      echo "<td>". $row_book['page_count']. "</td>";
                      echo "<td>". $row['progress']. "</td>";
                      echo "<td><a href=\"\" class=\"btn btn-outline-success btn-sm\">Edit </a></td>";
                      echo "</tr>";
                      }
                    ?>
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
                  <?php
                  $finished_book_sql = "select * from reads_book R natural join book Where R.user_id = 1 AND progress = ( Select page_count From Edition Where edition_no = R. edition_no AND book_id = R.book_id)";
                  $finished_book_query = mysqli_query($db, $finished_book_sql);
                  while( $row = mysqli_fetch_array($finished_book_query)) {
                  echo "<tr>";
                  echo "<th scope=\"row\">". $row["date"]. "</th>";
                  echo "<td>". $row['book_name']. "</td>";
                  echo "<td>". $row['author']. "</td>";
                  echo "<td>";
                  echo "<span class=\"fa fa-star checked\"></span>  <!--Parlak yıldızlar için bunu kullanıcaz-->";
                  echo "<span class=\"fa fa-star checked\"></span>";
                  echo "<span class=\"fa fa-star checked\"></span>";
                  echo "<span class=\"fa fa-star\"></span><!--Parlak olmayan yıldızlar için bunu kullanıcaz-->";
                  echo "<span class=\"fa fa-star\"></span>";
                  echo "</td>";
                  echo "<td><a href=\"\" class=\"btn btn-outline-success btn-sm\">Post Review </a></td>";
                  echo "</tr>";
                }
                ?>
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
                    <?php
                    $friend_sql = "select * from friends F, user U where F.user_id = $user_id and F.friend_id = U.user_id";
                    $friend_query = mysqli_query($db, $friend_sql);
                    while( $row = mysqli_fetch_array($friend_query)) {
                      echo "<tr>";
                      echo "<th scope=\"row\">". $row['name'] ." ". $row['surname']. "</th>";
                      echo "</tr>";
                    }
                    ?>
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
