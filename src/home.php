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

                <!--- \\\\\\\Post-->
                <div class="card gedf-card" >
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Time to post?</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                <div class="form-group">
                                    <label class="sr-only" for="message">Type Here</label>
                                    <textarea class="form-control" id="message" rows="3" placeholder="What are you thinking?"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="btn-toolbar justify-content-between">
                            <div class="btn-group">
                                <a href="#link" class="btn btn-warning" role="button">Post</a>
                            </div>
                        </div>
                    </div>
                </div>

                <br/>
                <br/>

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
                                        echo "<div class=\"h5 m-0\">".$row['name']." ". $row['surname']."</div>";
                                        echo "<div class=\"h7 text-muted\" style=\"color:#A9A9A9;\">@".$row['username']."</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        echo "<div class=\"card-body\">";
                            echo "<a class=\"card-link\" href=\"#\">";
                                $book_name_query = "select * from book where book_id ='".$row['book_id']."'";
                                $result = mysqli_query($db, $book_name_query);
                                $book = mysqli_fetch_array($result);
                                echo "<h5 class=\"card-title\">".$book['book_name']."</h5>";
                            echo "</a>";

                            echo "<p class=\"card-text\">";
                                echo $row['content'];
                            echo "</p>";
                            echo "<div class=\"text-muted h7 mb-2 pull-right\"> <i class=\"fa fa-clock-o\"></i> ".$row['date']."</div>";
                        echo "</div>";
                        echo "<div class=\"card-footer\">";
                            echo "<p style=\"vertical-align: middle;\"><i class=\"fa fa-thumbs-o-up\" style=\"color:orange;\"></i> ".$row['like_count']." likes";
                            echo "&emsp;<i class=\"fa fa-comment-o\" style=\"color:orange;\"></i> ".$row['comment_count']." comments";
                            echo "<button type=\"submit\" class=\"btn btn-warning pull-right\"><i class=\"fa fa-comment-o\"></i> Comment</button>";
                            echo "<button type=\"submit\" class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Like</button></p>";
                        echo "</div>";

                        echo "<div class=\"form-group\">";
                            echo "<textarea class=\"form-control\" id=\"message\" rows=\"3\" placeholder=\"I think\"></textarea>";
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
