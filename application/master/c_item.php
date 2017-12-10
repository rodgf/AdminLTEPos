<?php
  session_start();
  require_once "../model/dbconn.php";
  require_once "../model/pos.php";

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    $pos = new pos();
    $method = $_POST['method'];
    if ($method == 'get_detail_item') {
      $id_item = $_POST['id_item'];
      $pos = new pos();
      $data = $pos->getItem($id_item);
      $array['data'] = $data[1];
      $array['result'] = $data[0];
      echo json_encode($array);
    }

    if ($method == 'save_item') {
      $iditem = $_POST['id_item'];
      $nameitem = $_POST['item_name'];
      $unit = $_POST['unit'];
      $stock = $_POST['stock'];
      $price = $_POST['price'];
      $note = $_POST['note'];
      $crud = $_POST['crud'];
      $pos = new pos();
      if ($_POST['crud'] == 'N') {
        $array = $pos->saveItem($nameitem, $price, $unit, $stock, $note);
        if ($array[0] == true) {
          $result['id_item'] = $array[2];
        }
      } else {
        $array = $pos->updateItem($iditem, $nameitem, $price, $unit, $stock, $note);
      }

      $result['result'] = $array[0];
      $result['error'] = $array[1];
      $result['crud'] = $_POST['crud'];
      echo json_encode($result);
    }

    if ($method == 'getdata') {
      $pos = new pos();
      $array = $pos->getListItem();
      $data = $array[1];
      $i = 0;
      foreach ($data as $key) {
        $button = '<button  type="submit" id_item="' . $key['id_item'] . '"  title="Tombol edit barang" class="btn btn-sm btn-primary btnedit "  id="btnedit' . $key['id_item'] . '"  ><i class="fa fa-edit"></i></button> <button  type="submit" id_item="' . $key['id_item'] . '"  title="Tombol hapus barang" class="btn btn-danger btn-sm btndelete "  id="btndelete' . $key['id_item'] . '"  ><i class="fa fa-trash"></i></button>';

        $data[$i]['price'] = number_format($data[$i]['price']);
        $data[$i]['DT_RowId'] = $data[$i]['id_item'];
        $data[$i]['stock'] = number_format($data[$i]['stock']);
        $data[$i]['button'] = $button;
        $i++;
      }
      $datax = array('data' => $data);
      echo json_encode($datax);
    }

    if ($method == 'delete_item') {
      $id_item = $_POST['id_item'];
      $pos = new pos();
      $array = $pos->deleteItem($id_item);
      $data['result'] = $array[0];
      $data['error'] = $array[1];
      echo json_encode($data);
    }
  } else {
    exit('No direct access allowed.');
  }
?>
