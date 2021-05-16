<?php
include('config.php');
session_start();
require_once "helper_functions.php";

$current_page = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);

if( sessionNotExists()) {
  echo "<script type='text/javascript'>alert('Please login first!');window.location.href='index.php';</script>";
}
 ?>
<style>
 .nav>li>a {
   color: orange;
 }
 .nav>li>a.active,
 .nav>li>a:hover,
 .nav>li>a:focus {
    background-color: orange !important;
    color: white;
 }
</style>

<div class="container-fluid">

        <script src="js/bootstrap.js"></script>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php"><img alt="Qries" src="images/logo2.png"
                    width="240" height="56"></a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav nav-pills me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?php if ($current_page == "home.php") echo "active";?>" aria-current="page" href="home.php">Home Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($current_page == "searchbook.php") echo "active";?>" aria-current="page" href="searchbook.php">Search Book</a>
                        </li>
                        <li class="nav-item">
                            <?php
                            if($_SESSION['type'] == "author") {
                              echo "<a class=\"nav-link" ?> <?php if ($current_page == "authorprofile.php") echo "active";?> <?php echo "\" href=\"./authorprofile.php?uname=". $_SESSION['username']. "\">Profile (". $_SESSION['username']. ")</a>";
                            }
                            else if($_SESSION['type'] == "librarian") {
                              echo "<a class=\"nav-link" ?> <?php if ($current_page == "librarianprofile.php") echo "active";?> <?php echo "\" href=\"./librarianprofile.php?uname=". $_SESSION['username']. "\">Profile (". $_SESSION['username']. ")</a>";
                            }
                            else {
                              echo "<a class=\"nav-link" ?> <?php if ($current_page == "userprofile.php") echo "active";?> <?php echo "\" href=\"./userprofile.php?uname=". $_SESSION['username']. "\">Profile (". $_SESSION['username']. ")</a>";
                            }
                            ?>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($current_page == "challenges.php") echo "active"; ?>" href="challenges.php">Challenges</a>
                        </li>

                        <?php if($_SESSION['type'] == "user") { ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($current_page == "recommendations.php") echo "active"; ?>" href="./recommendations.php">Recommendations</a>
                        </li>
                      <?php } ?>

                      <?php if($_SESSION['type'] == "librarian") { ?>
                      <li class="nav-item">
                          <a class="nav-link <?php if ($current_page == "statistics.php") echo "active"; ?>" href="./statistics.php">Statistics</a>
                      </li>
                    <?php } ?>
                    </ul>
                    <form class="d-flex" action="logout.php" style="margin-top:20px;">
                        <button class="btn btn-outline-danger" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
</div>
