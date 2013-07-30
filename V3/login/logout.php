<?php
session_start();

// If the user is logged in, unset the session
if (isset($_SESSION['db_is_logged_in'])) {
   unset($_SESSION['db_is_logged_in']);
}

// Go back to login page
header('Location: login.php');
?>
