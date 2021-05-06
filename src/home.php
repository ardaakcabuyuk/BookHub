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
        <link rel="stylesheet" href="css/bootstrap.css">

    </head>

    <body>

    <br/>
    <br/>

    <div class="d-flex justify-content-around align-items-center">
      <form class="form-inline" action="searchresult.php" method="post">
        <div class="input-group">
          <div class="col-xs-4">
            <input type="search" class="form-control rounded" placeholder="Search Books" aria-label="Search"
            aria-describedby="search-addon" name="search_book" id="search1">
          </div>
            <span class="input-group-addon"><button class="btn btn-warning mb-2 pull-right" type="submit" name="search_book_button">
               Search
            </button></span>
        </div>
      </form>
      <form class="form-inline" action="#" method="post">
        <div class="input-group">
          <div class="col-xs-3">
            <input type="search" class="form-control rounded" placeholder="Search Authors" aria-label="Search"
            aria-describedby="search-addon" name="search_author">
          </div>
            <span class="input-group-addon"><button class="btn btn-warning mb-2 pull-right" type="submit" name="search_author_button">
                 Search
            </button></span>
          </div>
      </form>
      <form class="form-inline" action="#" method="post">
        <div class="input-group">
          <div class="col-xs-3">
            <input type="search" class="form-control rounded" placeholder="Search Users" aria-label="Search"
            aria-describedby="search-addon" name="search_user">
          </div>
            <span class="input-group-addon"><button class="btn btn-warning mb-2 pull-right" type="submit" name="search_user_button">
                   Search
            </button></span>
        </div>
      </form>
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
                                <a href="#link" class="btn btn-warning" role="button">Post</a>
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
                        <button type="submit" class="btn btn-warning">Like</button>
                        <button type="submit" class="btn btn-warning">Comment</button>
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
                        <button type="submit" class="btn btn-warning">Like</button>
                        <button type="submit" class="btn btn-warning">Comment</button>
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
                        <button type="submit" class="btn btn-warning">Like</button>
                        <button type="submit" class="btn btn-warning">Comment</button>
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
