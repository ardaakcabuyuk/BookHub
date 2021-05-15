<?php
include('config.php');
session_start();
 ?>

<div class="container-fluid">

        <script src="js/bootstrap.js"></script>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php"><img alt="Qries" src="images/logo2.png"
                    width="300" height="70"></a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="home.php">Home Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="searchbook.php">Search Book</a>
                        </li>
                        <li class="nav-item">
                            <?php
                            if($_SESSION['type'] == "author") {
                              echo "<a class=\"nav-link active\" href=\"./authorprofile.php?uname=". $_SESSION['username']. "\">Profile (". $_SESSION['username']. ")</a>";
                            }
                            else if($_SESSION['type'] == "librarian") {
                              echo "<a class=\"nav-link active\" href=\"./librarianprofile.php?uname=". $_SESSION['username']. "\">Profile (". $_SESSION['username']. ")</a>";
                            }
                            else {
                              echo "<a class=\"nav-link active\" href=\"./userprofile.php?uname=". $_SESSION['username']. "\">Profile (". $_SESSION['username']. ")</a>";
                            }
                            ?>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="challenges.php">Challenges</a>
                        </li>
                        
                        <?php if($_SESSION['type'] == "user") { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="./recommendations.php">Recommendations</a>
                        </li>
                      <?php } ?>
                    </ul>
                    <form class="d-flex" action="logout.php">
                        <button class="btn btn-outline-success" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
</div>
