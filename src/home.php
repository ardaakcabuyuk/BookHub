<?php
include('config.php');
session_start();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>BookHub</title>
        <link rel="stylesheet" href="css/bootstrap.css">

    </head>

    <body>

    <div class="container-fluid">

            <script src="js/bootstrap.js"></script>

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="home.php"><img alt="Qries" src="logo.png"
                        width=150" height="70"></a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="home.php">Home Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Challenges</a>
                            </li>
                            <li class="nav-item">
                                <?php
                                session_start();
                                $user_id = $_SESSION['user_id'];
                                $author_check_sql = "select * from Author where user_id = '$user_id'";
                                $author = mysqli_query($db, $author_check_sql);

                                $librarian_check_sql = "select * from Librarian where user_id = '$user_id'";
                                $librarian = mysqli_query($db, $librarian_check_sql);

                                if(mysqli_num_rows($author) == 1) {
                                  echo "<a class=\"nav-link active\" href=\"./authorprofile.php\">Profile ( Arda Akça Büyük )</a>";
                                }
                                else if(mysqli_num_rows($librarian) == 1) {
                                  echo "<a class=\"nav-link active\" href=\"./librarianprofile.php\">Profile ( Arda Akça Büyük )</a>";
                                }
                                else {
                                  echo "<a class=\"nav-link active\" href=\"./userprofile.php\">Profile ( Arda Akça Büyük )</a>";
                                }
                                ?>
                            </li>
                        </ul>
                        <form class="d-flex" action="index.php">
                            <button class="btn btn-outline-success" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </nav>
    </div>

    <br/>
    <br/>

    <div class="d-flex justify-space-between">
        <div class="input-group">
            <input type="search" class="form-control rounded" placeholder="Search Books" aria-label="Search"
              aria-describedby="search-addon" />
              <a href="searchresult.php" class="btn btn-info" role="button">Search</a>
        </div>
        <div class="input-group">
            <input type="search" class="form-control rounded" placeholder="Search Authors" aria-label="Search"
              aria-describedby="search-addon" />
              <a href="#link" class="btn btn-info" role="button">Search</a>
        </div>
        <div class="input-group">
            <input type="search" class="form-control rounded" placeholder="Search Users" aria-label="Search"
              aria-describedby="search-addon" />
              <a href="#link" class="btn btn-info" role="button">Search</a>
        </div>
    </div>

    <br/>
    <br/>

    <div class="container-fluid gedf-wrapper">

        <div class="row justify-content-center">
            <script src="js/bootstrap.js"></script>

            <div class="col-md-6 gedf-main">

                <!--- \\\\\\\Post-->
                <div class="card gedf-card" >
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Time to post?</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                <div class="form-group">
                                    <label class="sr-only" for="message">Type Here</label>
                                    <textarea class="form-control" id="message" rows="3" placeholder="What are you thinking?"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="btn-toolbar justify-content-between">
                            <div class="btn-group">
                                <a href="#link" class="btn btn-info" role="button">Post</a>
                            </div>
                        </div>
                    </div>
                </div>

                <br/>
                <br/>

                <div class="card gedf-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                                </div>
                                <div class="ml-2">
                                    <div class="h5 m-0">@ademburan</div>
                                    <div class="h7 text-muted">Emin Adem Buran</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>1 hours ago</div>
                        <a class="card-link" href="#">
                            <h5 class="card-title">Plato Hakkında.</h5>
                        </a>

                        <p class="card-text">
                            İyi adamdı.
                        </p>
                    </div>
                    <div class="card-footer">
                        <label>6 like</label>
                        <button type="submit" class="btn btn-primary">Like</button>
                        <button type="submit" class="btn btn-primary">Comment</button>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" id="message" rows="3" placeholder="I think"></textarea>
                    </div>
                </div>

                <br/>
                <br/>

                <div class="card gedf-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                                </div>
                                <div class="ml-2">
                                    <div class="h5 m-0">@adilmeric </div>
                                    <div class="h7 text-muted">Adil Meriç</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i> 10 min ago</div>
                        <a class="card-link" href="#">
                            <h5 class="card-title"> Okul hakkında.</h5>
                        </a>

                        <p class="card-text">
                            Okul berbat bir şey.
                        </p>
                    </div>
                    <div class="card-footer">
                        <label>6 like</label>
                        <button type="submit" class="btn btn-primary">Like</button>
                        <button type="submit" class="btn btn-primary">Comment</button>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" id="message" rows="3" placeholder="I think"></textarea>
                    </div>
                </div>

                <br/>
                <br/>

                <div class="card gedf-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                                </div>
                                <div class="ml-2">
                                    <div class="h5 m-0">@oruconur</div>
                                    <div class="h7 text-muted">Onur Oruç</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i> 1 day ago</div>
                        <a class="card-link" href="#">
                            <h5 class="card-title">Hayat Hakkında.</h5>
                        </a>

                        <p class="card-text">
                            Hayat iyi bişey gibi
                        </p>
                    </div>
                    <div class="card-footer">
                        <label>6 like</label>
                        <button type="submit" class="btn btn-primary">Like</button>
                        <button type="submit" class="btn btn-primary">Comment</button>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" id="message" rows="3" placeholder="I think"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
