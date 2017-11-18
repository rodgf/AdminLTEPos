<?php
  session_start();
  include "library/config.php";
  if (!isset($_SESSION['pos_username']) or !isset($_SESSION['pos_id']) or !isset($_SESSION['pos_uniqid'])
      or !isset($_SESSION['pos_h_menu'])) {
    header('Location: ' . $sitename . 'application/main/login.php');    
  } else {
    header('Location: ' . $sitename . 'application/main/index.php');
  }
?>
