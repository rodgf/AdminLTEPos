<?php
  session_start();
  include "../../library/config.php";
  require_once("../model/dbconn.php"); // delete white space between require_ once
  require_once("../model/pos.php"); // delete white space between require_ once

  $username = $_POST['username'];
  $password = $_POST['password'];
  if (empty($username) && empty($password)) {
      header('location:login.php?error=1');
      break;
  } else if (empty($username)) {
      header('location:login.php?error=2');
      break;
  } else if (empty($password)) {
      header('location:login.php?error=3');
      break;
  }
  $sv   = new pos();
  $data = $sv->getLogin($username, $password);
  if ($data[2] == 1) {
      $_SESSION['pos_username'] = $username;
      $_SESSION['pos_id']       = $data[1]['id_user'];
      $_SESSION['pos_h_menu']   = $data[1]['h_menu'];
      $_SESSION['pos_uniqid']   = uniqid();
      $_SESSION['name_shop']    = $data[1]['name_shop'];
      $iduser                   = $_SESSION['pos_id'];
      //$sv->deleteTempSaleByUser($iduser);
      header('location:../main/index.php');
  } else {
      header('location:login.php?error=4');
  }
?>
