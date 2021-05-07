<?php
  session_start();
  session_destroy();
  echo "<script type='text/javascript'>alert('Successfully logged out');window.location.href='index.php';</script>";
?>
