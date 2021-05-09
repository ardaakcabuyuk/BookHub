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
          <link rel="stylesheet" href="css/bootstrap.css">
          <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link rel="stylesheet" href="js/bootstrap.bundle.js">
          <link rel="stylesheet" href="css/searchresult.css" />
      </head>

      <body>

      <br/>
      <br/>
      <div class="d-flex justify-content-around align-items-center">
        <form class="form-inline" action="searchresult.php" method="post">
          <div class="input-group">
            <div class="col-xs-4">
              <input type="search" class="form-control rounded" placeholder="Search Books" aria-label="Search"
              aria-describedby="search-addon" name="search_book" id="search1">
            </div>
              <span class="input-group-addon"><button class="btn btn-warning mb-2 pull-right" type="submit" name="search_book_button">
                 Search
              </button></span>
          </div>
        </form>
        <form class="form-inline" action="searchresult.php" method="post">
          <div class="input-group">
            <div class="col-xs-3">
              <input type="search" class="form-control rounded" placeholder="Search Authors" aria-label="Search"
              aria-describedby="search-addon" name="search_author">
            </div>
              <span class="input-group-addon"><button class="btn btn-warning mb-2 pull-right" type="submit" name="search_author_button">
                   Search
              </button></span>
            </div>
        </form>
        <form class="form-inline" action="searchresult.php" method="post">
          <div class="input-group">
            <div class="col-xs-3">
              <input type="search" class="form-control rounded" placeholder="Search Users" aria-label="Search"
              aria-describedby="search-addon" name="search_user">
            </div>
              <span class="input-group-addon"><button class="btn btn-warning mb-2 pull-right" type="submit" name="search_user_button">
                     Search
              </button></span>
          </div>
        </form>
      </div>

      <br/>
      <br/>

      <div class="container-fluid gedf-wrapper">

          <div class="row justify-content-center">
              <script src="js/bootstrap.js"></script>

              <div class="col-md-6 gedf-main">
                <h2>Feed</h2>
                <hr>
                  <?php
                    $friends_query = "select *
                                      from post P natural join user U
                                      where P.user_id in (select friend_id
                                                          from user U2 natural join friends F
                                                          where F.user_id ='" . $_SESSION['user_id'] . "')
                                      or P.user_id ='". $_SESSION['user_id'] . "'
                                      order by P.date desc";

                    $query_run = mysqli_query($db, $friends_query);
                    while ($row = mysqli_fetch_array($query_run)) {
                      echo "<div class=\"card gedf-card\">";
                          echo "<div class=\"card-header\">";
                              echo "<div class=\"d-flex justify-content-between align-items-center\">";
                                  echo "<div class=\"d-flex justify-content-between align-items-center\">";
                                      echo "<div class=\"mr-2\">";
                                          echo "<img class=\"rounded-circle\" width=\"45\" src=\"images/reader.png\" alt=\"\">";
                                      echo "</div>";
                                      echo "<div class=\"ml-2\" style=\"margin-left: 10px;\">";
                                          echo "<div class=\"h5 m-0\"><a style=\"color:orange; text-decoration: none;\" href=\"userprofile.php?uname=".$row['username']."\">".$row['name']." ". $row['surname']."</a></div>";
                                          echo "<div class=\"h7 text-muted\"><a style=\"text-decoration: none;color:#A9A9A9;\" href=\"userprofile.php?uname=".$row['username']."\">@".$row['username']."</a></div>";
                                      echo "</div>";
                                  echo "</div>";
                              echo "</div>";
                          echo "</div>";
                          echo "<div class=\"card-body\">";
                              echo "<div class=\"h7 m-0\"><strong>On:</strong></div>";
                              echo "<a class=\"card-link\" href=\"bookprofile.php?book_id=".$row['book_id']."\" style=\"color:orange; text-decoration: none;\">";
                                  $book_name_query = "select * from book where book_id ='".$row['book_id']."'";
                                  $result = mysqli_query($db, $book_name_query);
                                  $book = mysqli_fetch_array($result);
                                  echo "<h5 class=\"card-title\">".$book['book_name']."</h5>";
                              echo "</a>";
                              echo "<p class=\"card-text\">";
                                  echo "<div class=\"h7 m-0\"><strong>Review:</strong></div>";
                                  echo $row['content'];
                              echo "</p>";
                              echo "<p class=\"card-text\">";
                                  echo "<div class=\"h7 mb-1\"><strong>Rating:</strong></div>";
                                  for ($i = 0; $i < $row['rate']; $i++) {
                                    echo "<span style=\"font-size:30px\" class=\"fa fa-star checked\"></span>";
                                  }
                                  for ($i = 0; $i < 5 - $row['rate']; $i++) {
                                    echo "<span style=\"font-size:30px\" class=\"fa fa-star\"></span>";
                                  }
                              echo "</p>";
                              echo "<div class=\"text-muted h7 mb-2 pull-right\"> <i class=\"fa fa-clock-o\"></i> ".$row['date']."</div>";
                          echo "</div>";
                          echo "<div class=\"card-footer\">";
                              $liked_sql = "select * from likes_post where post_id = " . $row['post_id']. " and user_id = ". $_SESSION['user_id'];
                              echo "<p style=\"vertical-align: middle; display:inline;\"><i class=\"fa fa-thumbs-o-up\" style=\"color:orange;\"></i> ".$row['like_count']." likes";
                              echo "&emsp;<i class=\"fa fa-comment-o\" style=\"color:orange;\"></i> ".$row['comment_count']." comments";
                              echo "<form style=\"display:inline;\" action=\"like.php\" method=\"post\">";
                              echo "<button type=\"submit\" class=\"btn btn-warning pull-right\" style=\"margin-left: 10px;\"><i class=\"fa fa-comment-o\"></i> Comment</button>";
                              echo "</form>";
                              if(mysqli_num_rows(mysqli_query($db,$liked_sql)) == 0) {
                                echo "<form style=\"display:inline;\" action=\"like.php\" method=\"post\">";
                                echo "<button type=\"submit\" name=\"like_button\" value=\"home.php-". $row['post_id'] ."\" class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Like</button></p>";
                                echo "</form>";
                              }
                              else {
                                echo "<form style=\"display:inline;\" action=\"unlike.php\" method=\"post\">";
                                echo "<button type=\"submit\" name=\"like_button\" value=\"home.php-". $row['post_id']. "\" class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Unlike</button></p>";
                                echo "</form>";
                              }
                          echo "</div>";

                          echo "<div class=\"form-group\">";
                              echo "<textarea class=\"form-control\" id=\"message\" rows=\"3\" placeholder=\"Comment here...\"></textarea>";
                          echo "</div>";
                      echo "</div>";

                      echo "<br/>";
                      echo "<br/>";
                    }
                  ?>
              </div>
          </div>
      </div>
      </body>
  </html>
