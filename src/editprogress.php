<?php
include('config.php');
session_start();

if (isset($_POST['addProgressButton'])) {
  list($book_id, $edition_no, $page_count) = explode("-", $_POST['addProgressButton'], 3);
  $page_no = $_POST['pageno'];
  $update_progress_query = "update reads_book
                          set progress = $page_no
                          where user_id = ".$_SESSION['user_id']."
                          and book_id = $book_id
                          and edition_no = $edition_no";

  $update_challenge_progress = "update participate P
                                set P.challlenge_progress = P.challlenge_progress +1
                                where P.user_id = ".$_SESSION['user_id'] ." and exists (select *
                                              from book B natural join edition E
                                              where B.book_id = " .$book_id."
                                              and E.edition_no = " .$edition_no ."
                                              and E.page_count = " .$page_no.")
                                              and P.challenge_id in (select C.challenge_id
                                                                    from challenge C
                                                                    where C.end_date > CURRENT_DATE)";

  $result_update_challenge_progress = mysqli_query($db, $update_challenge_progress);

  $read = false;
  $read_sql = "select * from reads_book natural join edition where user_id = ".$_SESSION['user_id']." and edition_no = $edition_no and book_id = $book_id and page_count = progress";
  $read_query = mysqli_query($db,$read_sql);

  if(mysqli_num_rows($read_query) != 0) {
    $read = true;
  }

  if(!$result_update_challenge_progress) {
      printf("Error: %s\n", mysqli_error($db));
      exit();
  }

  if ($page_no < 0 || $page_no > $page_count || $read) {
    echo "<script type='text/javascript'>alert('Bad credentials!');window.location.href='userprofile.php?uname=".$_SESSION['username']."';</script>";
  }
  else {
    $query_run = mysqli_query($db, $update_progress_query);
  }

  echo "<script type='text/javascript'>alert('Update progress successful!');window.location.href='userprofile.php?uname=".$_SESSION['username']."';</script>";
}
?>
