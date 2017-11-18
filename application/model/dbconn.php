<?php
  $dbuserx = 'adminltepos'; // change with your own database username
  $dbpassx = 'adminltepos'; // change with your own database password

  class dbconn {
    public $dblocal;

    public function __construct() {
        
    }

    public function initDBO() {
      global $dbuserx, $dbpassx;
      try {
        $this->dblocal = new PDO("mysql:host=localhost;dbname=adminltepos;charset=latin1",
          $dbuserx,
          $dbpassx,
          array(
            PDO::ATTR_PERSISTENT => true
          ));
        $this->dblocal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        die("Can not connect database");
      }
    }    
  }
?>
