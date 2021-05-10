<?php
include('config.php');
include_once "navbar.php";

if (isset($_GET['post_id'])) {
  $post_id = $_GET['post_id'];
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

    <br/>
    <br/>

    <div class="container-fluid gedf-wrapper">
        <div class="row justify-content-center">
            <script src="js/bootstrap.js"></script>
            <div class="col-md-6 gedf-main">
              <h2>Review</h2>
              <hr>
              <?php
                $get_post_query = "select *
                                  from post P natural join user U
                                  where post_id = $post_id";

                $query_run = mysqli_query($db, $get_post_query);
                $post = mysqli_fetch_array($query_run);
                  echo "<div class=\"card gedf-card\">";
                      echo "<div class=\"card-header\">";
                          echo "<div class=\"d-flex justify-content-between align-items-center\">";
                              echo "<div class=\"d-flex justify-content-between align-items-center\">";
                                  echo "<div class=\"mr-2\">";
                                      echo "<img class=\"rounded-circle\" width=\"45\" src=\"images/reader.png\" alt=\"\">";
                                  echo "</div>";
                                  echo "<div class=\"ml-2\" style=\"margin-left: 10px;\">";
                                      echo "<div class=\"h5 m-0\"><a style=\"color:orange; text-decoration: none;\" href=\"userprofile.php?uname=".$post['username']."\">".$post['name']." ". $post['surname']."</a></div>";
                                      echo "<div class=\"h7 text-muted\"><a style=\"text-decoration: none;color:#A9A9A9;\" href=\"userprofile.php?uname=".$post['username']."\">@".$post['username']."</a></div>";
                                  echo "</div>";
                              echo "</div>";
                          echo "</div>";
                      echo "</div>";
                      echo "<div class=\"card-body\" onclick=\"location.href='review.php?post_id=".$post['post_id']."';\" style=\"cursor: pointer;\">";
                          echo "<div class=\"h7 m-0\"><strong>On:</strong></div>";
                          echo "<a class=\"card-link\" href=\"bookprofile.php?book_id=".$post['book_id']."\" style=\"color:orange; text-decoration: none;\">";
                              $book_name_query = "select * from book where book_id ='".$post['book_id']."'";
                              $result = mysqli_query($db, $book_name_query);
                              $book = mysqli_fetch_array($result);
                              echo "<h5 class=\"card-title\">".$book['book_name']."</h5>";
                          echo "</a>";
                          echo "<p class=\"card-text\">";
                              echo "<div class=\"h7 m-0\"><strong>Review:</strong></div>";
                              echo $post['content'];
                          echo "</p>";
                          echo "<p class=\"card-text\">";
                              echo "<div class=\"h7 mb-1\"><strong>Rating:</strong></div>";
                              for ($i = 0; $i < $post['rate']; $i++) {
                                echo "<span style=\"font-size:30px\" class=\"fa fa-star checked\"></span>";
                              }
                              for ($i = 0; $i < 5 - $post['rate']; $i++) {
                                echo "<span style=\"font-size:30px\" class=\"fa fa-star\"></span>";
                              }
                          echo "</p>";
                          echo "<div class=\"text-muted h7 mb-2 pull-right\"> <i class=\"fa fa-clock-o\"></i> ".$post['date']."</div>";
                      echo "</div>";
                      echo "<div class=\"card-footer\">";
                          $liked_sql = "select * from likes_post where post_id = " . $post['post_id']. " and user_id = ". $_SESSION['user_id'];
                          echo "<p style=\"vertical-align: middle; display:inline;\"><i class=\"fa fa-thumbs-o-up\" style=\"color:orange;\"></i> ".$post['like_count']." likes";
                          echo "&emsp;<i class=\"fa fa-comment-o\" style=\"color:orange;\"></i> ".$post['comment_count']." comments";
                          echo "<form style=\"display:inline;\" action=\"like.php\" method=\"post\">";
                          echo "<div class=\"form-group\" style=\"margin-top:20px; margin-bottom:20px;\">";
                              echo "<textarea class=\"form-control\" id=\"message\" rows=\"3\" placeholder=\"Comment here...\"></textarea>";
                          echo "</div>";
                          echo "<button type=\"submit\" class=\"btn btn-warning pull-right\" style=\"margin-left: 10px; margin-bottom:10px;\"><i class=\"fa fa-comment-o\"></i> Comment</button>";
                          echo "</form>";
                          if(mysqli_num_rows(mysqli_query($db,$liked_sql)) == 0) {
                            echo "<form style=\"display:inline;\" action=\"like.php\" method=\"post\">";
                            echo "<button type=\"submit\" name=\"like_button\" value=\"home.php-". $post['post_id'] ."\" class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Like</button></p>";
                            echo "</form>";
                          }
                          else {
                            echo "<form style=\"display:inline;\" action=\"unlike.php\" method=\"post\">";
                            echo "<button type=\"submit\" name=\"like_button\" value=\"home.php-". $post['post_id']. "\" class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Unlike</button></p>";
                            echo "</form>";
                          }
                      echo "</div>";
                    ?>
                    <div class="coment-bottom bg-white p-2 px-4">
                      <br>
                      <h3>Comments</h3>
                      <hr>
                      <?php
                        $reply_query = "select *
                                        from replies R natural join author A, User U
                                        where R.post_id = $post_id and R.author_id = (select B.author_id
                                                                                      from Book B, Post P
                                                                                      where B.book_id = P.book_id
                                                                                      and P.post_id = $post_id)
                                        and A.user_id = U.user_id";

                        $comment_query = "select * from comment natural join user where post_id = $post_id";

                        $reply_query_run = mysqli_query($db, $reply_query);
                        $comment_query_run = mysqli_query($db, $comment_query);

                        if ($author_reply = mysqli_fetch_array($reply_query_run)) {
                          echo "<div class=\"commented-section mt-3\">";
                              echo "<div class=\"flex-row align-items-center commented-user\">";
                                  echo "<h6 style=\"color:orange\"><i class=\"fa fa-map-pin\"></i> Author reply</h6>";
                                  echo "<div class=\"d-flex\" style=\"margin-top:10px; margin-bottom:10px;\">";
                                  echo "<div class=\"mr-2\">";
                                    echo "<div class=\"h5 m-0\"><a style=\"color:orange; text-decoration: none;\" href=\"authorprofile.php?uname=".$author_reply['username']."\">".$author_reply['name']." ". $author_reply['surname']."</a></div>";
                                    echo "<div class=\"h7 text-muted\"><a style=\"text-decoration: none;color:#A9A9A9;\" href=\"authorprofile.php?uname=".$author_reply['username']."\">@".$author_reply['username']."</a></div>";
                                      //echo "<h5 class=\"mr-2\">".$author_reply['name']." ". $author_reply['surname']."</h5><span class=\"dot mb-1\"></span>";
                                    echo "</div>";
                                  echo "</div>";
                              echo "</div>";
                              echo "<div class=\"comment-text-sm\"><span>".$author_reply['reply']."</span></div>";
                              echo "<div class=\"text-muted h7 mb-2 pull-right\"> <i class=\"fa fa-clock-o\"></i>   ".$author_reply['date']."</div>";
                              echo "<br>";
                              echo "<div class=\"reply-section\">";
                                  echo "<div>";
                                      echo "<button type=\"submit\" name=\"like_button\"  class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Like ".$author_reply['reply_like_count']."</button></p>";
                                  echo "</div>";
                              echo "</div>";
                          echo "</div>";
                          echo "<br>";
                          echo "<br>";
                          echo "<hr>";
                        }
                        while ($row = mysqli_fetch_array($comment_query_run)) {
                          echo "<div class=\"commented-section mt-3\">";
                              echo "<div class=\"flex-row align-items-center commented-user\">";
                                  echo "<h6 style=\"color:orange\"><i class=\"fa fa-comment-o\"></i> Comment</h6>";
                                  echo "<div class=\"d-flex\" style=\"margin-top:10px; margin-bottom:10px;\">";
                                  echo "<div class=\"mr-2\">";
                                    echo "<div class=\"h5 m-0\"><a style=\"color:orange; text-decoration: none;\" href=\"userprofile.php?uname=".$row['username']."\">".$row['name']." ". $row['surname']."</a></div>";
                                    echo "<div class=\"h7 text-muted\"><a style=\"text-decoration: none;color:#A9A9A9;\" href=\"userprofile.php?uname=".$row['username']."\">@".$row['username']."</a></div>";
                                      //echo "<h5 class=\"mr-2\">".$author_reply['name']." ". $author_reply['surname']."</h5><span class=\"dot mb-1\"></span>";
                                    echo "</div>";
                                  echo "</div>";
                              echo "</div>";
                              echo "<div class=\"comment-text-sm\"><span>".$row['content']."</span></div>";
                              echo "<div class=\"text-muted h7 mb-2 pull-right\"> <i class=\"fa fa-clock-o\"></i>   ".$row['date']."</div>";
                              echo "<br>";
                              echo "<div class=\"reply-section\">";
                                  echo "<div>";
                                      echo "<button type=\"submit\" name=\"like_button\"  class=\"btn btn-warning pull-right\"><i class=\"fa fa-thumbs-o-up\"></i> Like ".$row['comment_like_count']."</button></p>";
                                  echo "</div>";
                              echo "</div>";
                          echo "</div>";
                          echo "<br>";
                          echo "<br>";
                          echo "<hr>";
                        }
                      ?>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>




    </body>
</html>
