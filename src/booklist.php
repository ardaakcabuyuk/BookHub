<?php
include('config.php');
require_once "navbar.php";

if(isset($_GET['list_id'])) {
  $list_id = $_GET['list_id'];
  $list_sql = "select * from booklist natural join user where list_id = $list_id";
  $list_query = mysqli_query($db,$list_sql);
  $list = mysqli_fetch_array($list_query);

  if(isset($_POST['follow_but'])) {
    $follow_list_sql = "insert into follows(list_id, user_id) values($list_id,". $_SESSION['user_id']. ")";
    mysqli_query($db,$follow_list_sql);

  }
  if(isset($_POST['unfol_but'])) {
    $delete_follow_sql = "delete from follows where user_id = ".$_SESSION['user_id']." and list_id = $list_id";
    mysqli_query($db,$delete_follow_sql);

  }
  $follows = false;
  $follow_sql = "select * from follows where list_id = $list_id and user_id =" . $_SESSION['user_id'];
  $follow_query = mysqli_query($db, $follow_sql);

  if(mysqli_num_rows($follow_query) == 1)
    $follows = true;

  if (isset($_POST['remove_book_button'])) {
    $book_id = $_POST['remove_book_button'];
    $remove_book_query = "delete from contains where list_id = $list_id and book_id = $book_id";
    $remove_book = mysqli_query($db, $remove_book_query);
  }
}
else {
  echo "<script type='text/javascript'>alert('Bad credentials!');window.location.href='home.php';</script>";
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



        <header class="header">
            <div class="container">

                <div class="row justify-content-center" style="margin-top:20px;">
                    <div class="col-md-3"> <!-- Image -->
                      <h2 style="text-align: center;"><strong><?php echo $list['list_name']; ?></strong></h2>
                      <h5 style="text-align: center;">Book List by <strong><?php echo $list['name']. " " . $list['surname']; ?></strong></h5>
                    </div>
                </div>
                <div class="row justify-content-center" style="margin-top:20px;">
                    <div class="col-md-9"> <!-- Image -->
                      <h5 style="text-align: center;">Description:</strong></h5>
                      <p style="text-align: center;"><?php echo $list['description'];?></p>
                    </div>
                </div>
                <div class="row justify-content-center" style="margin-top:20px;">
                  <div class="col-md-1"> <!-- Image -->
                    <?php  if(!$follows && $list['user_id'] != $_SESSION['user_id']) {?>
                      <form action="" method="post">
                      <div class="button">
                        <button href="#" value= <?php echo "\"$list_id\""; ?> name="follow_but" class="btn btn-outline-success">Follow </button>
                      </div>
                    </form>
                  <?php }
                  else if ($list['user_id'] != $_SESSION['user_id']) { ?>
                    <form action="" method="post">
                    <div class="button">
                      <button href="#" value= <?php echo "\"home.php-$list_id\""; ?> name="unfol_but" class="btn btn-outline-success">Unfollow </button>
                    </div>
                    </form>
                  <?php }
                  else  { ?>
                    <div class="button">
                      <a style="text-decoration:none;" class="btn btn-sm btn-outline-success" href="addtobooklist.php?list_id=<?php echo $list_id;?>">Add Book</a>
                    </div>
                  <?php } ?>
                  </div>
              </div>
            </div>
        </header>
        <div class="container bootstrap snippets bootdey">

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <br/>
                <br/>
                <hr/>
                <?php
                $book_in_list_sql = "select * from contains natural join book where list_id=$list_id";
                $book_in_list_query = mysqli_query($db,$book_in_list_sql);
                if (mysqli_num_rows($book_in_list_query) != 0) {
                  while( $row = mysqli_fetch_array($book_in_list_query)) {
                    echo "<div class=\"well search-result\">";
                        echo "<div class=\"row\">";
                            echo "<div class=\"col-xs-6 col-sm-9 col-md-9 col-lg-10 title\">";
                                echo "<h3>".$row['book_name']."</h3>";
                                echo "<h5>by ".$row['author']."</h5>";
                                echo "<p>".$row['description']."</p>";

                                $rating_query = "select ifnull(avg(rate),0) as rating
                                                  from book
                                                  left join post
                                                  on book.book_id = post.book_id
                                                  where book.book_id =".$row['book_id']."
                                                  group by book.book_id";
                                $query_run = mysqli_query($db, $rating_query);
                                $rate = mysqli_fetch_array($query_run)['rating'];
                                for ($i = 0; $i < (int)$rate; $i++) {
                                  echo "<i class=\"fa fa-star fa-lg checked\"></i>";
                                }
                                for ($i = 0; $i < 5 - (int)$rate; $i++) {
                                  echo "<i class=\"fa fa-star fa-lg\"></i>";
                                }
                                echo "  (".number_format($rate, 2, '.', '').")";
                                echo "<br/>";
                                echo "<a href=\"bookprofile.php?book_id=" .$row['book_id']. "\" class=\"btn btn-warning\" role=\"button\" style=\"margin-top:20px;\">Show Detailed Info</a>";
                                if ($list['user_id'] == $_SESSION['user_id']) {
                                  echo "<form action=\"\" method=\"post\" style=\"display:inline;\">";
                                    echo "<div class=\"button\" style=\"margin-left:10px; display:inline;\">";
                                      echo "<button href=\"#\" class=\"btn btn-danger\" name=\"remove_book_button\" value=".$row['book_id']." style=\"margin-top:20px;\">Remove Book</button>";
                                    echo "<div>";
                                    echo "<br>";
                                  echo "</form>";
                                }
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                    echo "<hr>";
                  }
                }
                else {
                  echo "<p style=\"text-align: center;\">No books in the book list.</p>";
                }
                ?>
              </div>

            </div>
          </div>
        </div>
    </body>
</html>
