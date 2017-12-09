<?php
  class pos extends dbconn {
    public function __construct() {
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

    /******************************************************************************
    START OF pos MENU CODE
    *******************************************************************************/
    public function getMenu() {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("select * from r_menu order by menu_order");
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    //
    public function getSubMenu($id) {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("select * from r_menu_sub where id_menu = :id order by sub_menu_order asc");
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    //
    public function getrefsytem() {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("select a.* from r_ref_system a where id = 1 ");
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        $stat[2] = 0;
        return $stat;
      }
    }

    /*********************query for master user*********************/
    public function getListUser() {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("select * from m_user where username<>'admin' order by username desc");
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    //
    public function saveUser($username, $pass_user, $h_menu) {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("insert into m_user(username,pass_user,h_menu)
        values(:name,MD5(:pass),:hmenu)");

        $stmt->bindParam("name", $username);
        $stmt->bindParam("pass", $pass_user);
        $stmt->bindParam("hmenu", $h_menu);
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = "Sukses save!";
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    //
    public function updateUser($id_user, $username, $h_menu) {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("update m_user set username = :name, h_menu = :hmenu  where id_user = :id");

        $stmt->bindParam("name", $username);
        $stmt->bindParam("id", $id_user);
        $stmt->bindParam("hmenu", $h_menu);
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = "Sukses update!";
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    //
    public function deleteUser($id_user) {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("delete from m_user  where id_user = :id");

        $stmt->bindParam("id", $id_user);
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = "Sukses update!";
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    //
    public function checkPassword($id, $pass) {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("select * from m_user where id_user = :id and pass_user = md5(:pass)");

        $stmt->bindParam("id", $id);
        $stmt->bindParam("pass", $pass);

        $stmt->execute();
        $stat[0] = true;
        $stat[1] = $stmt->rowCount();
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    //
    public function resetPass($iduser, $pass) {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("update m_user set pass_user = md5(:pass) where id_user=:id");

        $stmt->bindParam("id", $iduser);
        $stmt->bindParam("pass", $pass);
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = "Sukses reset pass!";
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    /******************************************************************************
    START TABEL m_item
    *******************************************************************************/
    public function getListItem() {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_item t,
          (SELECT @rownum := 0) r ORDER BY id_item ASC");
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    //
    public function getItem($id_item) {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("select a.* from m_item a where a.id_item = :id ");
        $stmt->bindParam("id", $id_item);
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    //
    public function updateItem($iditem, $item_name, $price, $unit, $stock, $note) {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("UPDATE m_item
      SET  item_name = UPPER(:item_name),
      unit= :unit,
      stock= :stock,
      price= :price,
      note= :note
      WHERE id_item= :iditem;");

        $stmt->bindParam("iditem", $iditem);
        $stmt->bindParam("item_name", $item_name);
        $stmt->bindParam("price", $price);
        $stmt->bindParam("note", $note);
        $stmt->bindParam("unit", $unit);
        $stmt->bindParam("stock", $stock);

        $stmt->execute();
        $stat[0] = true;
        $stat[1] = "Success Edit!";
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    //
    public function saveItem($item_name, $price, $unit, $stock, $note) {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("call saveItem(:item_name,:unit,:stock,:price,:note)");
        $stmt->bindParam("item_name", $item_name);
        $stmt->bindParam("price", $price);
        $stmt->bindParam("note", $note);
        $stmt->bindParam("unit", $unit);
        $stmt->bindParam("stock", $stock);
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = "Success save!";
        $stat[2] = $stmt->fetchColumn(0);
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    //
    public function deleteItem($iditem) {
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("delete from m_item where id_item = :id");
        $stmt->bindParam("id", $iditem);
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

    //
    public function autoCompleteItem($term) {
      $trm = "%" . $term . "%";
      $db = $this->dblocal;
      try {
        $stmt = $db->prepare("SELECT a.* FROM m_item a WHERE  item_name like :term or id_item  like :term order by item_name asc");
        $stmt->bindParam("term", $trm);
        $stmt->execute();
        $stat[0] = true;
        $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stat;
      } catch (PDOException $ex) {
        $stat[0] = false;
        $stat[1] = $ex->getMessage();
        return $stat;
      }
    }

    /*******************************************************************************
    END OF TABEL M_Item
    *******************************************************************************/}
?>
