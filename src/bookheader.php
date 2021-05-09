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
            echo "<h2 style=\"font-size:38px\"><strong>".$book['book_name']."</strong></h2>";
            echo "<h3>by <strong>". $book['author'] ."</strong></h3>";
            echo "<h5>Genre: <strong>". $book['genre']. " </strong></h5>";
            echo "<h5>". $book['year'] ."</h5>";
          echo "</div>";
          echo "<div class=\"col-md-3\">";
            if ($_SESSION['type'] == "librarian") {
              echo "<div class=\"button\" style=\"float:right; margin-left: 10px;\">";
                echo "<a href=\"#\" class=\"btn btn-outline-success btn-sm\">Prepare Quiz </a>";
              echo "</div>";
            }
            echo "<div class=\"button\" style=\"float:right; margin-left: 10px;\">";
              echo "<a href=\"#\" class=\"btn btn-outline-success btn-sm\">Quiz </a>";
            echo "</div>";
            echo "<div class=\"button\" style=\"float:right;\">";
              echo "<a href=\"#\" class=\"btn btn-outline-success btn-sm\">Recommend </a>";
            echo "</div>";
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
        echo "<div class=\"col-md-3 text-center\"> <!-- Phone & Social -->";
            if ($_SESSION['type'] != "librarian") {
              echo "<div class=\"button\" style=\"padding-top:18px\">";
                  echo "<a href=\"mailto:ahmkctg@yahoo.com\" class=\"btn btn-outline-success btn-block\">Erroneous Info Request</a>";
              echo "</div>";
            }
            echo "<div class=\"button\" style=\"padding-top:18px\">";
                echo "<a href=\"quotes.php?book_id=".$book['book_id']."\" class=\"btn btn-outline-success btn-block\">Quotes</a>";
            echo "</div>";
            echo "<div class=\"button\" style=\"padding-top:18px\">";
                echo "<a href=\"reviews.php?book_id=".$book['book_id']."\" class=\"btn btn-outline-success btn-block\">Reviews</a>";
            echo "</div>";
        echo "</div>";
      ?>
      </div>
    </div>
  </header>
  <br>
  <br>
  <!--End of Header-->