    <?php
    session_start();
    include('config.php');
    require_once "helper_functions.php";

    if( sessionNotExists()) {
      echo "<script type='text/javascript'>alert('Please login first!');window.location.href='index.php';</script>";
    }


    include_once "navbar.php";



    $own_profile = false;

    if (isset($_GET['uname'])) {
      if ($_GET['uname'] == $_SESSION['username']) {
        $own_profile = true;
      }

      $username = $_GET['uname'];
      $user_id_sql = "select user_id from user where username = \"$username\"";
      $usr_query = mysqli_query($db, $user_id_sql);
      if(mysqli_num_rows($usr_query) != 1) {
        echo "<script type='text/javascript'>alert('User with username = $user_id does not exist!');window.location.href='home.php';</script>";
      }

      $user_id = mysqli_fetch_array($usr_query)['user_id'];
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
        <link rel="stylesheet" href="css/searchresult.css" />
    </head>

    <body>

        <!-- ******HEADER****** -->
          <header class="header">
            <div class="container">
              <div class="row justify-content-center" style="margin-top:20px; white-space:nowrap;">
                <div class="col-md-3"> <!-- Image -->
                  <p style="text-align:center;"><img src="./images/reader.png" alt="Logo" height="200"></p>
                  <?php
                  if ($own_profile) {
                    $get_user_info_query = "select * from User where user_id = '$user_id'";
                    $query_run = mysqli_query($db, $get_user_info_query);
                    $user = mysqli_fetch_array($query_run);
                    $name = $user['name'];
                    $surname = $user['surname'];
                    $email = $user['email'];
                    $username = $user['username'];
                    echo "<h4 style=\"text-align: center;\">User</h2>";
                    echo "<br>";
                    echo "<h4 style=\"text-align: center;\"><strong>$name $surname</strong></h2>";
                    echo "<h5 style=\"text-align: center; color:#A9A9A9;\">@$username</h5>";
                    echo "<br>";
                    echo "<h6 style=\"text-align: center;\">e-mail: $email</h6>";
                  }
                  else {
                    $get_user_info_query = "select name, surname, username, email from User where username = '".$_GET['uname']."'";
                    $query_run = mysqli_query($db, $get_user_info_query);
                    $user = mysqli_fetch_array($query_run);
                    $name = $user['name'];
                    $surname = $user['surname'];
                    $email = $user['email'];
                    $username = $user['username'];
                    echo "<h4 style=\"text-align: center;\">User</h4>";
                    echo "<br>";
                    echo "<h4 style=\"text-align: center;\"><strong>$name $surname</strong></h4>";
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
                    <h3 class="card-title" style="color:#009688">Currently Reading</h2>
                    <div style="height: 15px"></div>
                    <table class="table">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Last Update</th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Total Page Count</th>
                            <th scope="col">Current Page</th>
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
                          if($own_profile)
                            echo "<td><a href=\"\" class=\"btn btn-outline-success btn-sm pull-right\">Edit </a></td>";
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
                        <?php
                          if($own_profile) {
                            echo "<th scope=\"col\"></th>";
                          }
                        ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $finished_book_sql = "select * from reads_book R natural join book Where R.user_id = $user_id AND progress = ( Select page_count From Edition Where edition_no = R. edition_no AND book_id = R.book_id)";
                      $finished_book_query = mysqli_query($db, $finished_book_sql);
                      while( $row = mysqli_fetch_array($finished_book_query)) {
                      echo "<tr>";
                      echo "<th scope=\"row\">". $row["date"]. "</th>";
                      echo "<td>". $row['book_name']. "</td>";
                      echo "<td>". $row['author']. "</td>";
                        if($own_profile) {
                          $check_review_query = "select * from post where book_id =".$row['book_id']." and user_id =".$_SESSION['user_id'];
                          $check_review = mysqli_query($db, $check_review_query);
                          if (mysqli_num_rows($check_review) == 0) {
                            echo "<td><a href=\"postquotepage.php?book_id=".$row['book_id']."\" class=\"btn btn-outline-success btn-sm pull-right\" style=\"margin-left:10px;\">Post Quote</a>"; 
                            echo "<a href=\"postreviewpage.php?book_id=".$row['book_id']."\" class=\"btn btn-outline-success btn-sm pull-right\">Post Review</a></td>";
                          }
                          else {
                            echo "<td><a href=\"postquotepage.php?book_id=".$row['book_id']."\" class=\"btn btn-outline-success btn-sm pull-right\">Post Quote</a></td>";
                          }
                        }
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
                    <?php
                    $post_info_sql = "select * from post natural join book where user_id = $user_id";
                    $post_query = mysqli_query($db,$post_info_sql);
                    while( $row = mysqli_fetch_array($post_query)) {
                    echo "<tr>";
                    echo "<th scope=\"row\">". $row['date']. "</th>";
                    echo "<td>". $row['book_name']. "</td>";
                    echo "<td>". $row['author']. "</td>";
                    echo "<td>". $row['like_count']. "</td>";
                    echo "<td>". $row['comment_count']. "</td>";
                    echo "<td>". $row['rate'] ."/5</td>";
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
                <h3 class="card-title" style="color:#009688"> Owned Book Lists</h3>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Number of Books</th>
                        <th scope="col">Number of Followers</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                      $booklist_sql = "select * from booklist, (select count(*) as cnt From Booklist inner join follows on booklist.list_id = follows.list_id Where booklist.user_id = $user_id) as cnt where booklist.user_id = $user_id";
                      $booklist_query = mysqli_query($db, $booklist_sql);

                      while($row = mysqli_fetch_array($booklist_query)) {
                        echo "<tr>";
                        echo "<th scope=\"row\">". $row['list_name'] ."</th>";
                        echo "<td>" . $row['num_books'] ."</td>";
                        echo "<td>". $row['cnt']. "</td>";
                        echo "<td><a href=\"booklist.php?list_id=". $row['list_id']. "\" class=\"btn btn-outline-success btn-sm pull-right\">Show Booklist</a></td>";
                        echo "</tr>";
                      }
                    ?>
                    </tbody>
                </table>
                <?php
                  if($own_profile)
                    echo "<a href=\"\" class=\"btn btn-outline-success btn-sm pull-right\">Create </a>";
                ?>
            </div>
            </div>
        </div>
        <!-- End:Biography -->
        <br>
        <br>

        <div class="row">
            <div class="col-md-12">
            <div class="card card-block text-xs-left">
                <h3 class="card-title" style="color:#009688"> Followed Book Lists</h3>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Number of Books</th>
                        <th scope="col">List Owner</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                      $booklist_sql = "Select * From Booklist inner join follows on booklist.list_id = follows.list_id, user Where follows.user_id = $user_id and user.user_id = booklist.user_id";
                      $booklist_query = mysqli_query($db, $booklist_sql);

                      while($row = mysqli_fetch_array($booklist_query)) {
                        echo "<tr>";
                        echo "<th scope=\"row\">". $row['list_name'] ."</th>";
                        echo "<td>" . $row['num_books'] ."</td>";
                        echo "<td>". $row['name']. " ". $row['surname'] ."</td>";
                        echo "<td><a href=\"booklist.php?list_id=". $row['list_id'] ."\" class=\"btn btn-outline-success btn-sm pull-right\">Show Booklist</a></td>";
                        echo "</tr>";
                      }
                    ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
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
                    <?php
                      if($own_profile)
                        echo "<a href=\"#\" class=\"btn btn-outline-success btn-sm pull-right\">Add </a>";
                    ?>

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
