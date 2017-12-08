</head>
<body class="hold-transition skin-black layout-top-nav">
  <!-- Site wrapper -->
  <div class="wrapper">
    <header class="main-header">
      <nav class="navbar navbar-static-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <a href="<?php echo $sitename . 'application/main/index.php'; ?>" class="navbar-brand">
             <span class="logo-mini">
              <b>Seegate</b>site
            </span>
          </a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <!-- main navigation bar disini -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <?php
              $sv = new pos();
              $data = $sv->getMenu();
              $key = $data[1];

              foreach ($key as $menu) {
                $idmenux = $menu['id_menu'];
                $id_menu = $menu['id_menu'];
                $query_sub_menu = $sv->getSubMenu($id_menu);
                $jumlah_submenu = count($query_sub_menu[1]);
                if ($jumlah_submenu > 0) {
                  $cekmenuz = 0;
                  /*--------------------*/
                  foreach ($query_sub_menu[1] as $sub_menu) {
                    $mymenu = $_SESSION['pos_h_menu'];
                    $arramymenu = explode(",", $mymenu);
                    if (in_array($sub_menu['id_sub_menu'], $arramymenu)) {
                      $cekmenuz++;
                    }
                  }
                  /*--------------------*/

                }
                if ($cekmenuz > 0) {
              ?>
                    <li class="dropdown"><a  href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $menu['name_menu']; ?> <span class="caret"></span></a>
              <?php
              }

                if ($jumlah_submenu > 0) {
              ?>
                  <ul class="dropdown-menu" role="menu">
              <?php
                foreach ($query_sub_menu[1] as $sub_menu) {
                  $mymenu = $_SESSION['pos_h_menu'];
                  $arramymenu = explode(",", $mymenu);

                  if (in_array($sub_menu['id_sub_menu'], $arramymenu)) {
                    echo $sub_menu['content_before'];
              ?>
                      <li>
                        <a class="titles" href="<?php echo $sitename . $sub_menu['url']; ?>" target="<?php echo $sub_menu['target']; ?>" title="<?php echo $sub_menu['title']; ?>" >
                        <?php echo $sub_menu['icon'] . $sub_menu['name_sub_menu']; ?>
                      </a>
                    </li>
              <?php
                    echo $sub_menu['content_after'];
                  }
                }
              ?>
                </ul>
        <?php }?>
            </li>
      <?php }?>
   </ul>
 </div>
 <!-- /.navbar-collapse -->
 <!-- ./ main navigation bar -->

 <div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
   <li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <img src="../../dist/img/avatar5.png" class="user-image" alt="User Image">
      <span class="hidden-xs"><?php echo $_SESSION['pos_username']; ?></span>
    </a>
    <ul class="dropdown-menu">

      <!-- User image -->
      <li class="user-header">
        <img src="../../dist/img/avatar5.png" class="img-circle" alt="User Image">
        <p>
          <?php echo $_SESSION['pos_username']; ?>
        </p>
      </li>

      <!-- Menu Footer-->
      <li class="user-footer">
        <div class="pull-left">
          <a href="<?php echo $sitename . 'application/utility/v_ubah_password.php'; ?>" title="Change Password " class="btn btn-default btn-flat">Change Password</a>
        </div>
        <div class="pull-right">
        <a href="<?php echo $sitename . 'application/main/logout.php'; ?>" title="Close Application" class="btn btn-default btn-flat">Logout</a>
        </div>
      </li>
    </ul>
  </li>
  <li>
    <a class="titles" href="<?php echo $sitename . 'application/main/logout.php'; ?>" ><i class="titles fa fa-sign-out" title="Close Application"  ></i></a>
  </li>
</ul>
</div><!--  /.<div class="navbar-custom-menu">-->
</div><!-- ./container -->
</nav>
</header>

<!-- main content -->
<div class="content-wrapper">
  <div class="container-fluid">
