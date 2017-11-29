<?php
session_start();
include "config.php";
if (!isset($_SESSION['pos_username'])
    or !isset($_SESSION['pos_id'])
    or !isset($_SESSION['pos_uniqid'])
    or !isset($_SESSION['pos_h_menu'])) {
  $data['result'] = '-1';
  $data['url'] = $sitename . 'application/main/login.php?error=session_die';
} else {
  $data['result'] = '1';
  $data['url'] = 'access granted';
}
echo json_encode($data);
