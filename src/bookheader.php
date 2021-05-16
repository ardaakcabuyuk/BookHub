<?php
include('config.php');
include_once "navbar.php";

if (isset($_GET['book_id'])) {
  $book_id = $_GET['book_id'];
}
?>

<!-- ******HEADER****** -->
  <header class="header">
    <div class="container">
      <div class="book-name" style="padding-top:20px;">
        <div class="row" style="margin-top:0px;">
        <?php
          $get_book_info_query = "select * from book natural join author where book_id = $book_id";
          $get_book = mysqli_query($db, $get_book_info_query);
          $book = mysqli_fetch_array($get_book);
          echo "<div class=\"col-md-9\">";
            echo "<h2 style=\"font-size:38px;\"><strong>".$book['book_name']."</strong></h2>";
            echo "<h3>by <strong><a style=\"color:orange; text-decoration: none;\" href=\"authorprofile.php?uname=".mysqli_fetch_array(mysqli_query($db, "select * from author natural join user where author_id =".$book['author_id']))['username']."\">".$book['author']."</a></strong></h3>";
            echo "<h5>Genre: <strong>". $book['genre']. " </strong></h5>";
            echo "<h5>". $book['year'] ."</h5>";
          echo "</div>";
          echo "<div class=\"col-md-3\">";
            $finished_book_sql = "select * from reads_book R natural join book Where book_id =".$book['book_id']." and R.user_id = ".$_SESSION['user_id']." and progress = ( Select page_count From Edition Where edition_no = R. edition_no AND book_id = R.book_id)";
            $finished_book_query = mysqli_query($db, $finished_book_sql);
            if (mysqli_num_rows($finished_book_query) != 0) {
              echo "<div class=\"button\" style=\"float:right;\">";
                echo "<a href=\"#\" class=\"btn btn-outline-success btn-sm\">Recommend </a>";
              echo "</div>";
            }
          echo "</div>";
          echo "</div>";
        echo "</div>";

        echo "<div class=\"row\" style=\"margin-top:20px;\">";
          echo "<div class=\"col-md-3\"> <!-- Image -->";
            echo "<a href=\"#\"> <img class=\"img-responsive\" src=\"https://picsum.photos/200\" alt=\"Kamal\" style=\"width:200px;height:200px\"></a>";
          echo "</div>";

          echo "<div class=\"col-md-6\"> <!-- Rank & Qualifications -->";
            echo "<h5>Description:</h5>";
            echo "<small>".$book['description']."</small>";
          echo "</div>";
          $rating_query = "select ifnull(avg(rate),0) as rating
                            from book
                            left join post
                            on book.book_id = post.book_id
                            where book.book_id =".$book['book_id']."
                            group by book.book_id";
          $query_run = mysqli_query($db, $rating_query);
          $rate = mysqli_fetch_array($query_run)['rating'];
        echo "<div class=\"col-md-3 text-center\"> <!-- Phone & Social -->";
            for ($i = 0; $i < (int)$rate; $i++) {
              echo "<i class=\"fa fa-star fa-3x checked\"></i>";
            }
            for ($i = 0; $i < 5 - (int)$rate; $i++) {
              echo "<i class=\"fa fa-star fa-3x\"></i>";
            }
            echo "<br>";
            echo "<div class=\"button\" style=\"padding-top:18px\">";
                echo "<a href=\"reviews.php?book_id=".$book['book_id']."\" class=\"btn btn-outline-success btn-block\">Reviews</a>";
            echo "</div>";
            echo "<div class=\"button\" style=\"padding-top:18px\">";
                echo "<a href=\"quotes.php?book_id=".$book['book_id']."\" class=\"btn btn-outline-success btn-block\">Quotes</a>";
                echo "<a href=\"postquotepage.php?book_id=".$book['book_id']."\" class=\"btn btn-outline-success btn-block\" style=\"margin-left:10px;\">Post Quote</a>";
            echo "</div>";
        echo "</div>";
      ?>
      </div>
    </div>
  </header>
  <br>
  <br>
  <!--End of Header-->
