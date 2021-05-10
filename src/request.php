<?php
include('config.php');
session_start();

if (isset($_POST['request_button'])) {
  list($url, $book_id) = explode("-", $_POST['request_button'], 2);
  $vars = array('title', 'author', 'genre', 'year', 'edition', 'page_count', 'publisher', 'language', 'format', 'translator', 'additional');
  $request = array();
  foreach($vars as $v) {
    if(!isset($_POST[$v]) || empty($_POST[$v])) {
      if ($v != 'year' && $v != 'edition' && $v != 'page_count') {
        $request[] = "";
      }
      else {
        $request = 0;
      }
    }
    else {
     $request[] = $_POST[$v];
    }
  }
}
$request_sql = "insert into edit_request
            (new_book_name, new_book_author, new_book_genre, new_book_year, new_book_edition_no, new_book_page_count, new_book_publisher,
            new_book_language, new_book_format, new_book_cover_photo, new_book_translator, additional_notes, book_id, user_id)
            values('".$request[0]."', '".$request[1]."', '".$request[2]."', ".$request[3].", ".$request[4].", ".$request[5].", '".$request[6]."', '".$request[7]."',
            '".$request[8]."', 010101, '".$request[9]."', '".$request[10]."', $book_id, ".$_SESSION['user_id'].")";

$request_sql;
$request_query = mysqli_query($db, $request_sql);
header("location: $url?book_id=$book_id");
?>
