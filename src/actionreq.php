<?php
include('config.php');
session_start();
$url = "librarianprofile.php?uname=". $_SESSION['username'];
if(isset($_POST['confirm'])) {
  $edit_id = $_POST['confirm'];
  $req_sql = "select * from edit_request where edit_id=$edit_id";


  $edit = mysqli_fetch_array(mysqli_query($db,$req_sql));

  $update_book_sql = "update book set book_name ='". $edit['new_book_name']. "', author='". $edit['new_book_author'].
  "', genre = '". $edit['new_book_genre'] ."', year =". $edit['new_book_year']. " where book_id=". $edit['book_id'];
  $q1 = mysqli_query($db,$update_book_sql);

  if($q1) {
    echo "<script type='text/javascript'>alert('Book information updated successfully!');</script>";
  }
  else {
    echo "<script type='text/javascript'>alert('Error in updating book information!');window.location.href='$url';</script>";
  }

  $update_edition_sql = "update edition set edition_no = ". $edit['new_book_edition_no'] .", page_count = ". $edit['new_book_page_count'].
  ", publisher = '". $edit['new_book_publisher'] ."', language = '". $edit['new_book_language'] ."', format = '". $edit['new_book_format'].
  "', translator = '". $edit['new_book_translator']. "' where book_id = ". $edit['book_id']." and edition_no = ". $edit['old_edition_no'];

  $q2 = mysqli_query($db,$update_edition_sql);

  if($q2) {
    $delete_sql = "delete from edit_request where edit_id=$edit_id";
    mysqli_query($db,$delete_sql);
    echo "<script type='text/javascript'>alert('Edition information updated successfully!');window.location.href='$url';</script>";
  }
  else {
    echo "<script type='text/javascript'>alert('Error in updating edition information!');window.location.href='$url';</script>";
  }


}

if(isset($_POST['reject'])) {
  $edit_id = $_POST['reject'];
  $delete_sql = "delete from edit_request where edit_id=$edit_id";
  mysqli_query($db,$delete_sql);
  echo "<script type='text/javascript'>alert('Edit requested rejected!');window.location.href='$url';</script>";
}
 ?>
