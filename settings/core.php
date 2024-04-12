<?php
session_start();

// define a function to check for login
function check_login() {
  // check if the user id session exists
  if (!isset($_SESSION['user_id'])) {
    // if it doesn't exist, redirect to the login page
    header('Location: ../view/login_view.php');
    // stop the execution of the script
    die();
  }
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect_to($location) {
    header('Location: ' . $location);
    exit;
}

function display_error($message) {
    echo "<p class='error'>" . htmlentities($message) . "</p>";
}