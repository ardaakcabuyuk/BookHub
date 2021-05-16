    <?php
    include_once "navbar.php";

    include('config.php');

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
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
                  <div class="card card-block text-xs-left" style="border: none;">
                    <h3 class="card-title" style="color:#009688">Currently Reading</h2>
                    <div style="height: 15px"></div>
                    <table class="table">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Last Update</th>
                            <th scope="col">Title</th>
                            <th scope="col">Edition</th>
                            <th scope="col">Author</th>
                            <th scope="col">Total Page Count</th>
                            <th scope="col">Current Page</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $reads_sql = "select *
                                        from reads_book R
                                        where R.user_id = $user_id
                                        and R.progress < (select E.page_count
                                                          from edition E
                                                          where E.edition_no = R.edition_no
                                                          and E.book_id = R.book_id)
                                        and R.date in (select max(date)
                                                        from reads_book R1
                                                        where R1.user_id = $user_id
                                                        and R1.edition_no = R.edition_no
                                                        and R1.book_id = R.book_id)";
                          $reads_user = mysqli_query($db, $reads_sql);
                          $i = 0;
                          while( $row = mysqli_fetch_array($reads_user)) {
                          $current_book_sql = "select * from book natural join edition where book_id =" . $row['book_id']." and edition_no = ".$row['edition_no'];
                          $row_book = mysqli_fetch_array(mysqli_query($db, $current_book_sql));
                          echo "<tr>";
                          echo "<th scope=\"row\">". $row['date']. "</th>";
                          echo "<td><a style=\"color:black; text-decoration: none;\" href=\"bookprofile.php?book_id=".$row_book['book_id']."\">".$row_book['book_name']."</a></td>";
                          echo "<td>". $row['edition_no']."</td>";
                          echo "<td><a style=\"color:black; text-decoration: none;\" href=\"authorprofile.php?uname=".$row_book['author_id']."\">".$row_book['author']."</a></td>";
                          echo "<td>". $row_book['page_count']. "</td>";
                          echo "<td>". $row['progress']. "</td>";
                          if($own_profile)
                            echo "<td><button type=\"button\" data-toggle=\"modal\" data-target=\"#addProgress$i\" class=\"btn btn-outline-success btn-sm pull-right\" style=\"margin-right:10px;\">Edit Progress</button></td>";
                          echo "</tr>";
                          echo "<div class=\"modal fade\" id=\"addProgress$i\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"addProgressLabel\" aria-hidden=\"true\">"; $i++; ?>
                            <form id="add_form" action="editprogress.php" method="POST">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="addProgressLabel">Edit Progress</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                            		    <label for="pageno">Page Number</label><br/>
                            		    <input type="text" class="form-control" id="pageno" name="pageno" required/><br/>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="addProgressButton" value="<?php echo $row_book['book_id']. "-" . $row['edition_no']. "-" . $row_book['page_count']; ?>" class="btn btn-success">Add</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                      <?php } ?>
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
              <div class="card card-block text-xs-left" style="border: none;">
                <h3 class="card-title" style="color:#009688"> Read</h3>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Finished Date</th>
                        <th scope="col">Title</th>
                        <th scope="col">Edition</th>
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
                      $i = 0;
                      while( $row = mysqli_fetch_array($finished_book_query)) {
                      echo "<tr>";
                      echo "<th scope=\"row\">". $row["date"]. "</th>";
                      echo "<td><a style=\"color:black; text-decoration: none;\" href=\"bookprofile.php?book_id=".$row['book_id']."\">".$row['book_name']."</a></td>";
                      echo "<td><a style=\"color:black; text-decoration: none;\" href=\"bookprofile.php?book_id=".$row['book_id']."\">".$row['edition_no']."</a></td>";
                      echo "<td><a style=\"color:black; text-decoration: none;\" href=\"authorprofile.php?uname=".mysqli_fetch_array(mysqli_query($db, "select * from author natural join user where author_id =".$row['author_id']))['username']."\">".$row['author']."</a></td>";
                        if($own_profile) {
                          $check_review_query = "select * from post where book_id =".$row['book_id']." and user_id =".$_SESSION['user_id'];
                          $check_review = mysqli_query($db, $check_review_query);
                          if (mysqli_num_rows($check_review) == 0) {
                            echo "<td><a href=\"postquotepage.php?book_id=".$row['book_id']."\" class=\"btn btn-outline-success btn-sm pull-right\" style=\"margin-left:20px;\">Post Quote</a>";
                            echo "<a href=\"postreviewpage.php?book_id=".$row['book_id']."\" class=\"btn btn-outline-success btn-sm pull-right\" style=\"margin-left:20px;\">Post Review</a>";
                            echo "<a type=\"button\" href=\"recommend.php?book_id=".$row['book_id']."\" class=\"btn btn-outline-success btn-sm pull-right\" style=\"margin-left:20px;\">Recommend</a></td>";
                          }
                          else {
                            echo "<td><a href=\"postquotepage.php?book_id=".$row['book_id']."\" class=\"btn btn-outline-success btn-sm pull-right\" style=\"margin-left:20px;\">Post Quote</a>";
                            echo "<a type=\"button\" href=\"recommend.php?book_id=".$row['book_id']."\" class=\"btn btn-outline-success btn-sm pull-right\" style=\"margin-left:20px;\">Recommend</a></td>";
                          }
                        }
                      echo "</tr>";
                      echo "<div class=\"modal fade\" id=\"recommend$i\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"addProgressLabel\" aria-hidden=\"true\">"; $i++;
                        echo "<form id=\"add_form\" action=\"\" method=\"POST\">";
                        echo "<div class=\"modal-dialog modal-lg\" role=\"document\">";
                        echo "<div class=\"modal-content\">";
                        echo "<div class=\"modal-header\">";
                                echo "<h5 class=\"modal-title\" id=\"addProgressLabel\">Add Progress</h5>";
                                echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
                                  echo "<span aria-hidden=\"true\">&times;</span>";
                                echo "</button>";
                              echo "</div>";
                              echo "<div class=\"modal-body\">";
                              echo "<label for=\"pageno\">Page Number</label><br/>";
                                echo "<input type=\"text\" class=\"form-control\" id=\"pageno\" name=\"pageno\" required/><br/>";
                              echo "</div>";
                              echo "<div class=\"modal-footer\">";
                                echo "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Cancel</button>";
                                echo "<button type=\"submit\" name=\"addProgressButton\" value=\"". $edition['edition_no']. "-" . $edition['page_count'] ."\" class=\"btn btn-success\">Add</button>";
                              echo "</div>";
                            echo "</div>";
                          echo "</div>";
                        echo "</form>";
                    } ?>

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
            <div class="card card-block text-xs-left" style="border: none;">
                <h3 class="card-title" style="color:#009688"> Reviews</h3>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Likes</th>
                        <th scope="col">Comments</th>
                        <th scope="col">Ratings</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $post_info_sql = "select * from post natural join book where user_id = $user_id";
                    $post_query = mysqli_query($db,$post_info_sql);
                    while( $row = mysqli_fetch_array($post_query)) {
                    echo "<tr>";
                    echo "<th scope=\"row\">". $row['date']. "</th>";
                    echo "<td><a style=\"color:black; text-decoration: none;\" href=\"bookprofile.php?book_id=".$row['book_id']."\">".$row['book_name']."</a></td>";
                    echo "<td><a style=\"color:black; text-decoration: none;\" href=\"authorprofile.php?uname=".mysqli_fetch_array(mysqli_query($db, "select * from author natural join user where author_id =".$row['author_id']))['username']."\">".$row['author']."</a></td>";
                    echo "<td>". $row['like_count']. "</td>";
                    echo "<td>". $row['comment_count']. "</td>";
                    echo "<td>". $row['rate'] ."/5</td>";
                    echo "<td><a href=\"review.php?post_id=".$row['post_id']."\" class=\"btn btn-outline-success btn-sm pull-right\">Go to Review</a></td>";
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
            <div class="card card-block text-xs-left" style="border: none;">
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
                    $booklist_sql = "select * from booklist b, (select ifnull(count(follows.list_id),0) as cnt, bl.list_id
                                      From Booklist bl left join follows on bl.list_id = follows.list_id
                                      where bl.user_id = $user_id group by bl.list_id) as cnto
                                      where b.user_id = $user_id and cnto.list_id = b.list_id";
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
                    echo "<a href=\"\" data-toggle=\"modal\" data-target=\"#createBooklist\" class=\"btn btn-outline-success btn-sm pull-right\">Create </a>";
                ?>
            </div>
            </div>
            <div class="modal fade" id="createBooklist" tabindex="-1" role="dialog" aria-labelledby="createBooklist" aria-hidden="true">
              <form id="add_form" action="create_booklist.php" method="POST">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="createBooklist">Create Booklist</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <label for="list_name">List Name</label><br/>
                      <input type="text" class="form-control" id="list_name" name="list_name" required/><br/>
                      <label for="list_name">Description</label><br/>
                      <input type="text" class="form-control" id="desc" name="desc"/><br/>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="create" value="" class="btn btn-outline-success">Create</button>
                      <button type="submit" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
        </div>
        <!-- End:Biography -->
        <br>
        <br>

        <div class="row">
            <div class="col-md-12">
            <div class="card card-block text-xs-left" style="border: none;">
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
                <div class="card card-block text-xs-left" style="border: none;">
                    <h3 class="card-title" style="color:#009688"> Friends
                    <div style="height: 15px"></div>
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <?php
                            if($own_profile)
                              echo "<th scope=\"col\">Name</th>";
                             ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $friend_sql = "select * from friends F, user U where F.user_id = $user_id and F.friend_id = U.user_id";
                        $friend_query = mysqli_query($db, $friend_sql);
                        $i = 0;
                        while( $row = mysqli_fetch_array($friend_query)) {
                          echo "<tr>";
                          echo "<td><a style=\"color:black; text-decoration: none;\" href=\"userprofile.php?uname=".$row['username']."\">".$row['name']." ".$row['surname']."</a></td>";
                          if($own_profile) {
                            echo "<td><button type=\"button\" data-toggle=\"modal\" data-target=\"#removeFriend$i\" class=\"btn btn-outline-danger btn-sm pull-right\">Remove</button></td>";
                            echo "</tr>";
                            echo "<form action=\"removefriend.php\" method=\"post\">";
                              echo "<div class=\"modal fade\" id=\"removeFriend$i\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"removeFriendLabel\" aria-hidden=\"true\">"; $i++;
                            ?>
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="removeFriendLabel">Are you sure?</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" name="remove_button" value= "<?php echo $row['friend_id']; ?>" class="btn btn-outline-success" href="#">Yes</a>
                                      <button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          <?php
                            echo "</form>";
                          }
                          else {
                            echo "</tr>";
                          }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                      if($own_profile) {
                        echo "<form action=\"searchresult.php\" method=\"post\">";
                        echo "<button href=\"\" name=\"search_user_button\" class=\"btn btn-outline-success pull-right\">Add Friends</button>";
                        echo "</form>";
                      }
                    ?>

                </div>
                </div>
            </div>

            <br>
            <br>

            <div class="row">
                <div class="col-md-12">
                <div class="card card-block text-xs-right" style="border: none;">
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
                          <?php
                            $challenge_completed_query = "select * from participate natural join challenge where user_id = $user_id and challlenge_progress >= goal";
                            $query_run = mysqli_query($db, $challenge_completed_query);
                            while ($row = mysqli_fetch_array($query_run)) {
                              echo "<tr>";
                              echo "<td scope=\"row\">".$row['challenge_name']."</td>";
                              echo "<td>". $row['challlenge_progress'] ." / ".$row['goal']."</td>";
                              echo "</tr>";
                            }
                          ?>
                        </tr>
                        </tbody>
                    </table>


                </div>
                </div>
            </div>

            <br>
            <br>

            <div class="row">
                <div class="col-md-12">
                <div class="card card-block text-xs-right" style="border: none;">
                    <h3 class="card-title" style="color:#009688"> Challenges Failed</h3>
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
                          <?php
                            $challenge_completed_query = "select * from participate natural join challenge where user_id = $user_id and challlenge_progress < goal and end_date < CURRENT_DATE()";
                            $query_run = mysqli_query($db, $challenge_completed_query);
                            while ($row = mysqli_fetch_array($query_run)) {
                              echo "<tr>";
                              echo "<td scope=\"row\">".$row['challenge_name']."</td>";
                              echo "<td>". $row['challlenge_progress'] ." / ".$row['goal']."</td>";
                              echo "</tr>";
                            }
                          ?>
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
