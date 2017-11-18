<?php
  session_start();
  include "../../library/config.php";
  require_once("../model/dbconn.php");
  require_once("../model/pos.php");
  if (!isset($_SESSION['pos_username']) or !isset($_SESSION['pos_id']) or !isset($_SESSION['pos_h_menu']) or !isset($_SESSION['pos_uniqid'])) {
      header('Location: ' . $sitename . 'application/main/login.php');
  }

  unset($_SESSION['pos_username']);
  unset($_SESSION['pos_id']);
  unset($_SESSION['pos_h_menu']);
  unset($_SESSION['pos_uniqid']);
  unset($_SESSION['name_shop']);
  unset($_SESSION['alamat_toko']);
  unset($_SESSION['telp_toko']);
  header('Location: ' . $sitename . 'application/main/login.php');
?>
