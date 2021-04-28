<?php
if(!defined('host')) define('host', 'localhost');
if(!defined('dbname')) define('dbname', 'book_hub');
if(!defined('username')) define('username', 'root');
if(!defined('passwd')) define('passwd', '');
$db = mysqli_connect(host, username, passwd, dbname);
if($db === false) {
  die("Failed to connect MYSQL: " . mysqli_connect_errno());
}
?>
