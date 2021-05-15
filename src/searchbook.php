<?php
include('config.php');
include_once "navbar.php";

if (isset($_POST['search_book_button'])) {
  $_SESSION['search'] = $_POST;
  $local_post = $_POST;
}
else if (isset($_POST['search_book_button']) && !empty($_SESSION['search'])){
  $local_post = $_SESSION['search'];
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
                    <form class="form-inline" action="searchbook.php" method="post">
                      <div class="form-group mb-2">
                        <label for="min">Search:</label>
                        <br>
                        <input type="search" id="min" class="form-control rounded" placeholder="Keyword" aria-label="Search"
                          aria-describedby="search-addon" name="keyword" style="width:500px;" required>
                      </div>
                      <br>
                      <div class="form-group mb-2">
                        <label for="selector">Search By:</label>
                        <select class="form-select" name="search_by" id="selector" style="width:130px;">
                          <option value="book_name" selected>Title</option>
                          <option value="author">Author</option>
                          <option value="genre">Genre</option>
                        </select>
                      </div>
                      <br/>
                      <div class="form-group mb-2">
                        <label for="min">Range Search:</label>
                        <br>
                        <input type="search" id="min" class="form-control rounded" placeholder="Year (min)" aria-label="Search"
                          aria-describedby="search-addon" name="year_min" style="width:150px;">
                      </div>
                      <div class="form-group mb-2">
                        <input type="search" class="form-control rounded" placeholder="Year (max)" aria-label="Search"
                          aria-describedby="search-addon" name="year_max" style="width:150px;">
                      </div>
                      <br>
                      <div class="form-group mb-2">
                        <button class="btn btn-warning mb-2 pull-left" type="submit" name="search_book_button">
                          Search
                        </button>
                      </div>
                    </form>
                    <br/>
                    <br/>
                </div>
            </div>

            <?php
            if(isset($local_post['search_book_button']) || isset($_POST['sort_by'])) {
              echo "<h2 class=\"card-title\">Search Results</h2>";
              echo "<form class=\"form-inline\" action=\"\" method=\"post\">
                      <div class=\"form-group mb-2\">
                        <select class=\"form-select\" name=\"sort_by\" id=\"selector\" style=\"width:130px;\" onchange=\"this.form.submit()\">
                          <option selected>Sort By</option>
                          <option value=\"book_name\">Title</option>
                          <option value=\"rate\">Rate</option>
                        </select>
                      </div>
                    </form>";
              echo "<hr>";
              $keyword = $local_post['keyword'];
              $search_by = $local_post['search_by'];
              if ($local_post['year_min'] != "" && $local_post['year_max'] != "") {
                $year_min = $local_post['year_min'];
                $year_max = $local_post['year_max'];

                $search_book_query = "select *
                                      from book
                                      where $search_by like '%$keyword%'
                                      and year between $year_min and $year_max";
              }
              else {
                $search_book_query = "select *
                                      from book
                                      where $search_by like '%$keyword%'";
              }

              if (isset($_POST['sort_by'])) {
                if ($_POST['sort_by'] == "book_name") {
                  $type = "ASC";
                  $search_book_query .= " order by ".$_POST['sort_by']. " $type";
                }
                else if ($_POST['sort_by'] == "rate") {
                  $type = "DESC";
                  $rating_query = "select *, ifnull(avg(rate),0) as rating
                                    from book
                                    left join post
                                    on book.book_id = post.book_id
                                    group by book.book_id
                                    order by rating DESC";
                }
              }
              echo $search_book_query;
              $search_book = mysqli_query($db, $search_book_query);
              if (mysqli_num_rows($search_book) != 0) {
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
                          echo "</div>";
                      echo "</div>";
                  echo "</div>";
                  echo "<hr>";
                }
              }
            }
          ?>
        </div>
    </body>
</html>
