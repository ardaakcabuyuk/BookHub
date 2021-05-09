<?php
session_start();
include('config.php');
require_once "navbar.php";

if (isset($_GET['book_id'])) {
  $book_id = $_GET['book_id'];
}

?>
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Post Review">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <meta charset="utf-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <title>BookHub</title>
    <link rel="stylesheet" href="js/bootstrap.bundle.js">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/rating.css" />
    <link rel="stylesheet" href="css/nicepage.css" media="screen">
    <link rel="stylesheet" href="css/Home.css" media="screen">
    <script class="u-script" type="text/javascript" src="js/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="js/nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 3.14.0, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
  </head>
  <body>
    <br>
    <section class="u-align-center u-clearfix u-section-1" id="sec-da33">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-layout-row">
          <div class="u-size-30">
            <div class="u-layout-col">
              <div class="u-align-left u-container-style u-layout-cell u-left-cell u-size-30 u-layout-cell-1">
                <div class="u-container-layout u-container-layout-1">
                  <h2 class="u-text u-text-1">Post Review</h2>
                  <?php
                    $book_query = "select * from book where book_id = $book_id";
                    $query_run = mysqli_query($db, $book_query);
                    $book = mysqli_fetch_array($query_run);
                    echo "<h4 class=\"u-text u-text-2\">".$book['book_name']." by " .$book['author']. "</h4>";
                    echo "<p class=\"u-text u-text-3\">".$book['description']."</p>";
                  ?>
                </div>
              </div>
              <div class="u-align-left u-container-style u-layout-cell u-left-cell u-size-30 u-layout-cell-2">
                <div class="u-container-layout u-container-layout-2">
                  <div class="u-expanded-width u-form u-form-1">
                    <form action="post.php" method="POST" style="padding: 10px" source="custom" name="form-5">
                      <div class="u-form-group u-form-message">
                        <textarea placeholder="Review" rows="4" cols="50" id="message-5359" name="content" class="u-border-1 u-border-grey-30 u-input u-input-rectangle" required=""></textarea>
                        <br>
                        <label>Rate Book:</label>
                        <br/>
                        <div class="rating">
                          <input id="star5" name="star" type="radio" value="5" class="radio-btn hide" />
                          <label for="star5">☆</label>
                          <input id="star4" name="star" type="radio" value="4" class="radio-btn hide" />
                          <label for="star4">☆</label>
                          <input id="star3" name="star" type="radio" value="3" class="radio-btn hide" />
                          <label for="star3">☆</label>
                          <input id="star2" name="star" type="radio" value="2" class="radio-btn hide" />
                          <label for="star2">☆</label>
                          <input id="star1" name="star" type="radio" value="1" class="radio-btn hide" />
                          <label for="star1">☆</label>
                          <div class="clear"></div>
                        </div>
                        <br>
                      </div>
                      <div class="u-form-group u-form-submit">
                        <?php
                          echo "<button type=\"submit\" name=\"post_review_button\" value=\"reviews.php"."-".$book_id."\" class=\"u-btn u-btn-round u-btn-submit u-button-style u-palette-3-base u-radius-13 u-btn-1\">Post Review</button>";
                        ?>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </section>
  </body>
</html>
