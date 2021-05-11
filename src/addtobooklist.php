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
                    <h2>Add Book</h2>
                    <hr>
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
                            while ($row = mysqli_fetch_array($search_book)) {
                              echo "<div class=\"well search-result\">";
                                  echo "<div class=\"row\">";
                                      echo "<div class=\"col-xs-6 col-sm-9 col-md-9 col-lg-10 title\">";
                                          echo "<h3>".$row['book_name']."</h3>";
                                          echo "<h5>by ".$row['author']."</h5>";
                                          echo "<p>".$row['description']."</p>";

                                          echo "<!-- todo post post gezip rating hesapla -->";
                                          echo "<i class=\"fa fa-star checked\"></i>";
                                          echo "<span class=\"fa fa-star checked\"></span>";
                                          echo "<span class=\"fa fa-star checked\"></span>";
                                          echo "<span class=\"fa fa-star\"></span>";
                                          echo "<span class=\"fa fa-star\"></span>";
                                          echo "<br>";
                                          echo "<p>Average Ratings (3.2)</p>";
                                          echo "<a href=\"bookprofile.php?book_id=" .$row['book_id']. "\" class=\"btn btn-warning\" role=\"button\">Show Detailed Info</a>";
                                          echo "<form action=\"\" method=\"post\" style=\"display:inline;\">";
                                            echo "<div class=\"button\" style=\"margin-left:10px; display:inline;\">";
                                              echo "<button href=\"#\" class=\"btn btn-success\" name=\"add_book_button\" value=".$row['book_id'].">Add Book</button>";
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
                    ?>
                  </div>
                </div>
              </div>
