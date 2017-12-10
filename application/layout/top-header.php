<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- no cache headers -->
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="no-cache">
  <meta http-equiv="Expires" content="-1">
  <meta http-equiv="Cache-Control" content="no-cache">
  <!-- end no cache headers -->

  <title>
    <?php
      if ($titlepage) {
        echo $titlepage;
      } else {
        echo '';
      }
    ?>
  </title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../bower_components/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="../../dist/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="../../dist/css/sweetalert.css">
  <link rel="stylesheet" href="../../dist/css/custom.css">
  <!--  <link rel="shortcut icon" href="../../dist/img/favicon.ico" /> -->
