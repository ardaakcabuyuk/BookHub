<?php
include('config.php');
#session_start();

function emptyInputLogin($username, $pwd) {
    return (empty($username) || empty($pwd));
}

function emptyInputRegister($name, $email, $username, $userType, $password, $repeatPassword) {
    return (empty($name) || empty($email) || empty($username) || empty($userType) || empty($password) || empty($repeatPassword));
}

function sessionNotExists() {
  return( empty($_SESSION['username']) || empty($_SESSION['user_id']) || empty($_SESSION['type']));
}

function isUser() {
  return($_SESSION['type'] == "user");
}

function isAuthor() {
  return($_SESSION['type'] == "author");
}

function isLibrarian() {
  return($_SESSION['type'] == "librarian");
}

function formattedDate($date) {
    return date("d-m-Y", strtotime($date));
}

?>
