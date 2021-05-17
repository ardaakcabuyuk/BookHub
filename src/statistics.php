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
    <link rel="stylesheet" href="js/bootstrap.bundle.js">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="searchresult.css" />

</head>

<body>
<br/>

<h1 style="text-align: center;">Statistics</h1>
<br>
<br>
<div class="container justify-content-center">
  <div class="row">
      <div class="col-md-12">
          <div class="card card-block text-xs-left" style="border: none;">
              <h3 class="card-title" style="color:orange;">Most Rated Books</h3>
              <div style="height: 15px"></div>
              <table class="table">
                  <thead class="thead-dark">
                  <tr>
                      <th scope="col">Year</th>
                      <th scope="col">Title</th>
                      <th scope="col">Author</th>
                      <th scope="col">Rate</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $rating_query = "select book.*, ifnull(avg(rate),0) as rating
                                    from book
                                    left join post
                                    on book.book_id = post.book_id
                                    group by book.book_id
                                    order by rating DESC
                                    LIMIT 5";

                  $query_run = mysqli_query($db, $rating_query);
                  while ($row = mysqli_fetch_array($query_run)) {
                      echo "<tr>";
                      echo "<td scope=\"col\">".$row['year']."</th>";
                      echo "<td><a style=\"color:black; text-decoration: none;\" href=\"bookprofile.php?book_id=".$row['book_id']."\">".$row['book_name']."</a></td>";
                      echo "<td>".$row['author']."</td>";
                      echo "<td>".number_format($row['rating'], 2, '.', '')."</td>";
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
                <h3 class="card-title" style="color:orange;">Most Rated Authors</h3>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Number of Books</th>
                        <th scope="col">Rate</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $rating_query = "select *
                                    from user, author natural join (select author_rates_book.author_id, avg(rating) as author_rate
                                                    from author natural join (select author_id, ifnull(avg(rate),0) as rating
                                                                              from post
                                                                              left join book
                                                                              on book.book_id = post.book_id
                                                                              group by book.book_id) as author_rates_book
                                                    group by author_id
                                                    order by author_rate DESC
                                                    LIMIT 5) as author_rates
                                    where user.user_id = author.user_id
                                    order by author_rate DESC";

                    $query_run = mysqli_query($db, $rating_query);
                    while ($row = mysqli_fetch_array($query_run)) {
                        echo "<tr>";
                        echo "<td><a style=\"color:black; text-decoration: none;\" href=\"authorprofile.php?uname=".$row['username']."\">".$row['name']." ".$row['surname']."</a></td>";
                        echo "<td>".$row['num_book']."</td>";
                        echo "<td>".number_format($row['author_rate'], 2, '.', '')."</td>";
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
                <h3 class="card-title" style="color:orange;">Most Rated Genres</h3>
                <div style="height: 15px"></div>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Genre</th>
                        <th scope="col">Rate</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $rating_query = "select book.genre, ifnull(avg(rate),0) as rating
                                      from book
                                      left join post
                                      on book.book_id = post.book_id
                                      group by book.genre
                                      order by rating DESC
                                      LIMIT 5";

                    $query_run = mysqli_query($db, $rating_query);
                    while ($row = mysqli_fetch_array($query_run)) {
                        echo "<tr>";
                        echo "<td scope=\"col\">".$row['genre']."</th>";
                        echo "<td>".number_format($row['rating'], 2, '.', '')."</a></td>";
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
                  <h3 class="card-title" style="color:orange;">Most Read Books</h3>
                  <div style="height: 15px"></div>
                  <table class="table">
                      <thead class="thead-dark">
                      <tr>
                          <th scope="col">Year</th>
                          <th scope="col">Title</th>
                          <th scope="col">Author</th>
                          <th scope="col">Read Count</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $read_query = "select book.*, count(*) as read_count
                                        from reads_book R natural join book
                                        where progress = (Select page_count
                                                        From Edition
                                                        Where edition_no = R. edition_no
                                                        AND book_id = R.book_id)
                                        group by book_id, author
                                        order by read_count desc
                                        limit 5";

                      $query_run = mysqli_query($db, $read_query);
                      while ($row = mysqli_fetch_array($query_run)) {
                          echo "<tr>";
                          echo "<td scope=\"col\">".$row['year']."</th>";
                          echo "<td><a style=\"color:black; text-decoration: none;\" href=\"bookprofile.php?book_id=".$row['book_id']."\">".$row['book_name']."</a></td>";
                          echo "<td>".$row['author']."</td>";
                          echo "<td>".$row['read_count']."</td>";
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
                    <h3 class="card-title" style="color:orange;">Most Read Genres</h3>
                    <div style="height: 15px"></div>
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                          <th scope="col">Genre</th>
                          <th scope="col">Read Count</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $read_query = "select genre, count(*) as read_count
                                          from reads_book R natural join book
                                          where progress = (Select page_count
                                                          From Edition
                                                          Where edition_no = R. edition_no
                                                          AND book_id = R.book_id)
                                          group by genre
                                          order by read_count desc
                                          limit 5";

                        $query_run = mysqli_query($db, $read_query);
                        while ($row = mysqli_fetch_array($query_run)) {
                          echo "<tr>";
                          echo "<td scope=\"col\">".$row['genre']."</th>";
                          echo "<td>".$row['read_count']."</a></td>";
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
</div>
</body>
</html>
