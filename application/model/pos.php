<?php
class pos extends dbconn {
  public function __construct()   {
    $this->initDBO();
  }

  /******************************************************************************
  TABEL T_JUAL AND TEMP_JUAL
   *******************************************************************************/
  public function deleteTempSaleByUser($iduser) {
    $db = $this->dblocal;
    try {
      $stmt = $db->prepare("delete from temp_sale where id_user = :id");
      $stmt->bindParam("id", $iduser);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = "Success Delete!";
      return $stat;
    } catch (PDOException $ex) {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }

  /*********************query for system*********************/
  public function getLogin($user, $pass) {
    $db = $this->dblocal;
    try {
      $stmt = $db->prepare("select a.*,
        (select name_shop from r_ref_system where id = 1) as name_shop,
        (select address_shop from r_ref_system where id = 1) as address_shop,
        (select phone_shop from r_ref_system where id = 1) as phone_shop
        from m_user a where  upper(a.username)=upper(:user) and a.pass_user=md5(:id)");
      $stmt = $db->prepare("select a.*
        from m_user a where  upper(a.username)=upper(:user) and a.pass_user=md5(:id)");
      $stmt->bindParam("user", $user);
      $stmt->bindParam("id", $pass);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
      $stat[2] = $stmt->rowCount();
      return $stat;
    } catch (PDOException $ex) {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      $stat[2] = 0;
      return $stat;
    }
  }
}
