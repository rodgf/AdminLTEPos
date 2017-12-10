<?php
  include "../../library/config.php";

  $titlepage = "System Login Form";
  include "../layout/top-header.php"; //header template 
?> 
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><center><b>SEEGATESITE.COM</b><br/><small>EXAMPLE POINT OF SALES</small></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="authorization.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" autofocus value="" name="username" id="username" placeholder="Username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" value="" name="password" id="password" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">

            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
            </div><!-- /.col -->
          </div>
        </form>
        <br>
        <div class="information-box round">
          <div class="callout callout-danger">
            <?php
              if (!empty($_GET['error'])) {
                  if ($_GET['error'] == 0) {
                    echo 'Erro ao verificar usuário: ' . $_GET['msgErro'];
                  } else if ($_GET['error'] == 1) {
                    echo 'Please fill out username or password';
                  } else if ($_GET['error'] == 2) {
                    echo 'Please fill out username';
                  } else if ($_GET['error'] == 3) {
                      echo 'Please fill out password';
                  } else if ($_GET['error'] == 4) {
                      echo 'Invalid email or password';
                  } else if ($_GET['error'] == 'session_die') {
                      echo 'Your login session is over!!, please sign in again';
                  }
              } else {
                  echo 'Please fill out your username and password to sign in';
              }
            ?>
        </div>
      </div>
    </div><!-- /.login-box-body -->
  </div><!-- /.login-box -->

  <center><p>Copyright &copy; <?php echo date("Y"); ?> Seegatesite.com., inc. All rights reserved</p></center>

  <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
  <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="../../plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
  <script src="../../dist/js/myfunction.js" type="text/javascript"></script>
  <script src="../../dist/js/sweetalert.min.js" type="text/javascript"></script>

  </body>
</html>
