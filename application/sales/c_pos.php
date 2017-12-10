<?php
  session_start();
  require_once "../model/dbconn.php";
  require_once "../model/pos.php";

  //
  function display_to_sql($date) {
    return substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
  }

  //
  $method = $_POST['method'];
  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    $pos = new pos();
    $menu = $pos->getSubMenuById(6);
    $menu_log = $menu[1];

    if ($method == 'get_subtotal') {
      $uniqid = $_SESSION['pos_uniqid'];
      $kasir = $_SESSION['pos_id'];
      $pos = new pos();
      $array = $pos->getSubTotalTempSale($kasir, $uniqid);
      $result = array();
      $result['result'] = $array[0];
      $result['subtotal'] = (int) $array[1];
      echo json_encode($result);
    }

    if ($method == 'get_trans_sale') {
      $first = display_to_sql($_POST['first']);
      $last = display_to_sql($_POST['last']);
      $pos = new pos();
      $array = $pos->getTransSale($first, $last);
      $html = '';
      $result = array();

      if ($array[0] == true) {
        $i = 1;
        foreach ($array[1] as $key) {
          if ($key['sts'] == 0) {
            $html .= '<tr class="strikeout">';
            $btn = 'delete';
          } else {
            $html .= '<tr >';
            $btn = '<button  type="submit" sale_id="' . $key['sale_id'] .
                   '" title="Delete Transaction" class="btn btn-danger btn-sm btndeletesale" id="btndeletesale' .
                   $key['sale_id'] . '" name=""><i class="fa fa-remove"></i></button>';
          }

          $html .= '	<td class="tdstrike">' . $i . '</td>
          <td class="tdstrike">' . date('d/m/Y', strtotime($key['sale_date'])) . '</td>
          <td class="tdstrike">' . $key['sale_id'] . '</td>
          <td  class="tdstrike" style="text-align:right">Rp. ' . number_format($key['total']) . '</td>
          <td class="tdstrike">' . $key['username'] . '</td>
          <td class="tdstrike" style="min-width:80px">' . $btn . '</td>
          </tr>';
          $i++;
        }
        $result['hasil'] = $html;
      }
      echo json_encode($result);
    }

    if ($method == 'check_tempsale') {
      $uniqid = $_SESSION['pos_uniqid'];
      $kasir = $_SESSION['pos_id'];
      $pos = new pos();
      $array = $pos->getSubTotalTempSale($kasir, $uniqid);
      $result = array();
      $hasil = $array[1];
      if ($hasil >= 1) {
        $result['tempsale'] = true;
      } else {
        $result['tempsale'] = false;
      }
      echo json_encode($result);
    }

    if ($method == 'save_trans') {
      $sale_id = substr($_POST['sale_id'], 0, 7);
      $sale_date = display_to_sql($_POST['sale_date']);
      $paid = $_POST['paid'];
      $disc_prcn = $_POST['disc_prcn'];
      $disc_rp = $_POST['disc_rp'];
      $note = $_POST['note'];
      $uniqid = $_SESSION['pos_uniqid'];
      $id_user = $_SESSION['pos_id'];
      $pos = new pos();

      $insert = $pos->saveSale($sale_id, $sale_date, $paid, $disc_prcn, $disc_rp, $uniqid, $id_user, $note);
      $retval['result'] = $insert[0];
      $retval['error'] = $insert[1];
      $retval['xsale_id'] = $insert[2];

      echo json_encode($retval);
    }

    if ($method == 'save_temptable') {
      $uniqid = $_SESSION['pos_uniqid'];
      $kasir = $_SESSION['pos_id'];
      $id_item = $_POST['id_item'];
      $pos = new pos();
      $result = array();
      $query = $pos->getItem($id_item);
      $data = $query[1];
      $result['id_item'] = $data['id_item'];
      $result['item_name'] = $data['item_name'];
      $result['qty'] = 1;
      $result['unit'] = $data['unit'];
      $result['price'] = $data['price'];
      $result['discprcn'] = 0;
      $result['discrp'] = 0;

      $check = $pos->getCheckProduk($kasir, $uniqid, $result['id_item']);
      $jum = $check[1];

      if ($jum >= 1) {
        $update = $pos->updateTempSale($kasir, $uniqid, $result['id_item']);
        $retval['result'] = $update[0];
        $retval['error'] = $update[1];
      } else {
        $insert = $pos->saveTempSale($kasir, $uniqid, $result['id_item'], $result['unit'],
          $result['item_name'], $result['qty'], $result['price'], $result['discprcn'], $result['discrp']);
        $retval['result'] = $insert[0];
        $retval['error'] = $insert[1];
      }
      echo json_encode($retval);
    }

    if ($method == 'reset_table') {
      $uniqid = $_SESSION['pos_uniqid'];
      $iduser = $_SESSION['pos_id'];
      $pos = new pos();
      $reset = $pos->resetTempSaleByUserSession($iduser, $uniqid);
      $retval['result'] = $reset[0];
      $retval['error'] = $reset[1];
      echo json_encode($retval);
    }

    if ($method == 'deletedetail') {
      $id_item = $_POST['id_item'];
      $uniqid = $_SESSION['pos_uniqid'];
      $kasir = $_SESSION['pos_id'];
      $pos = new pos();
      $delete = $pos->deleteTempSaleProduct($kasir, $uniqid, $id_item);
      $retval['result'] = $delete[0];
      $retval['error'] = $delete[1];
      echo json_encode($retval);
    }

    if ($method == 'updatedetail') {
      $value = $_POST['nilai'];
      $jenis = $_POST['jenis'];
      $uniqid = $_SESSION['pos_uniqid'];
      $kasir = $_SESSION['pos_id'];
      $pos = new pos();
      $key = explode('|', base64_decode($_POST['key']));
      $id_item = $key[0];
      $unit = $key[1];
      if ($jenis == 'hargajual') {
        $update = $pos->updateTempSaleHargaSale($kasir, $uniqid, $id_item, $value);
      } else if ($jenis == 'qty') {
        $update = $pos->updateTempSaleQty($kasir, $uniqid, $id_item, $value);
      } else if ($jenis == 'disc') {
        $update = $pos->updateTempSaleDisc($kasir, $uniqid, $id_item, $value);
      } else {
        echo 'error';
      }

      $retval['result'] = $update[0];
      $retval['error'] = $update[1];
      echo json_encode($retval);
    }

    if ($method == 'getdata') {
      $uniqid = $_SESSION['pos_uniqid'];
      $kasir = $_SESSION['pos_id'];
      $pos = new pos();
      $array = $pos->getListTempSale($kasir, $uniqid);
      $data = $array[1];
      $i = 0;
      foreach ($data as $key) {
        $keys = $key['id_item'] . '|' . $key['unit'];
        $keys = base64_encode($keys);
        $total = ($key['price'] - ($key['price'] * $key['discprc'] / 100)) * $key['qty'];
        $data[$i]['price'] = '<a href="#" class="editparam" key="' . $keys .
                             '"  datatitle="Harga Sale" dataparam="hargajual" val="' . number_format($key['price']) . '">' .
                             number_format($key['price']) . '</a>';
        $data[$i]['qty'] = '<a href="#" class="editparam" key="' . $keys . '" datatitle="Qty" dataparam="qty" val="' .
                           number_format($key['qty']) . '">' . number_format($key['qty']) . ' ' . $key['unit'] . '</a>';
        $data[$i]['discprc'] = '<a href="#" class="editparam" key="' . $keys . '" datatitle="Discount" dataparam="disc" val="' . number_format($key['discprc'], 2) . '">' . number_format($key['discprc'], 2) . '</a>';

        $data[$i]['subtotal'] = '<span class="csubtotal">' . number_format($total) . "</span>";
        $data[$i]['button'] = '<button  type="submit" id_item="' . $key['id_item'] . '" unit="' . $key['unit'] .
                              '"   class="btn btn-primary btndelete btn-sm"  id="btndeletes' . $key['id_item'] .
                              '"   ><i class="fa fa-remove"></i></button>';
        $i++;
      }
      $datax = array('data' => $data);
      echo json_encode($datax);
    }

    if ($method == 'delete_trans') {
      $sale_id = $_POST['sale_id'];
      $username = $_SESSION['pos_username'];
      $notehapus = 'Deleted by : ' . $username . ' ,at : ' . date("l jS \of F Y h:i:s A");
      $pos = new pos();
      $array = $pos->deleteSale($sale_id, $notehapus);
      $data['result'] = $array[0];
      $data['error'] = $array[1];
      echo json_encode($data);
    }
  } else {
    exit('No direct access allowed.');
  }
?>
