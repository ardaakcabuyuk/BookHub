<?php
include('config.php');
include_once "navbar.php";
if (isset($_GET['list_id'])) {
  $list_id = $_GET['list_id'];
  if (isset($_POST['add_book_button'])) {
    $book_id = $_POST['add_book_button'];
    $add_book_query = "insert into contains (list_id, book_id) values ($list_id, $book_id)";
    $add_book = mysqli_query($db, $add_book_query);
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
        <link rel="stylesheet" href="css/searchresult.css" />

    </head>

    <body>

        <div class="container bootstrap snippets bootdey">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <br/>
                    <br/>
                    <form class="form-inline" action="addtobooklist.php?list_id=<?php echo $list_id;?>" method="post">
                      <div class="form-group mb-2">
                      <input type="search" class="form-control rounded" placeholder="Search Books" aria-label="Search"
                        aria-describedby="search-addon" name="search_book">
                      </div>
                      <div class="form-group mb-2">
                        <button class="btn btn-warning mb-2 pull-right" type="submit" name="search_book_button">
                               Search
                        </button>
                      </div>
                    </form>
                    <br/>
                    <br/>
                    <?php
                      if(isset($_POST['search_book_button'])) {
                        $searchkey = $_POST['search_book'];
                        if ($searchkey != "") {
                          $search_book_query = "select *
                                                from book
                                                where book_name like '%$searchkey%'
                                                and book_id not in (select book_id
                                                                    from contains
                                                                    where list_id = $list_id)";
                          $search_book = mysqli_query($db, $search_book_query);
                          if (mysqli_num_rows($search_book) != 0) {
                            echo "<h2>Add Book</h2><hr>";
                            while ($row = mysqli_fetch_array($search_book)) {
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
                                          echo "<form action=\"\" method=\"post\" style=\"display:inline;\">";
                                            echo "<div class=\"button\" style=\"margin-left:10px; display:inline;\">";
                                              echo "<button href=\"#\" class=\"btn btn-success\" name=\"add_book_button\" value=".$row['book_id']." style=\"margin-top:20px;\">Add Book</button>";
                                            echo "<div>";
                                            echo "<br>";
                                          echo "</form>";
                                      echo "</div>";
                                  echo "</div>";
                              echo "</div>";
                              echo "<hr>";
                            }
                          }
                          else {
                            echo "<p>No results.</p>";
                          }
                        }
                      }
                      else {
                        $search_book_query = "select *
                                              from book
                                              where book_id not in (select book_id
                                                                  from contains
                                                                  where list_id = $list_id)";
                        $search_book = mysqli_query($db, $search_book_query);
                        if (mysqli_num_rows($search_book) != 0) {
                          echo "<h2>Add Book</h2><hr>";
                          while ($row = mysqli_fetch_array($search_book)) {
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
                                        echo "<form action=\"\" method=\"post\" style=\"display:inline;\">";
                                          echo "<div class=\"button\" style=\"margin-left:10px; display:inline;\">";
                                            echo "<button href=\"#\" class=\"btn btn-success\" name=\"add_book_button\" value=".$row['book_id']." style=\"margin-top:20px;\">Add Book</button>";
                                          echo "<div>";
                                          echo "<br>";
                                        echo "</form>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                            echo "<hr>";
                            }
                          }
                          else {
                            echo "<p>There are no books left in the database to add to the booklist.</p>";
                          }
                        }
                      ?>
                  </div>
                </div>
              </div>
