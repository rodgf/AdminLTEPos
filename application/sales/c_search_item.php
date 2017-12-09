<?php
  session_start();
  require_once "../model/dbconn.php";
  require_once "../model/pos.php";

  //
  function cmp($a, $b) {
    return strcmp($a["id_item"], $b["id_item"]);
  }

  $term = $_POST['term'];
  $pos = new pos();
  $html = '';

  $data = $pos->autoCompleteItem($term);
  $hasil = array();
  $i = 1;
  foreach ($data[1] as $row) {
    $hasil[$i]['item_name'] = $row['item_name'];
    $hasil[$i]['id_item'] = $row['id_item'];
    $hasil[$i]['unit'] = $row['unit'];
    $hasil[$i]['price'] = $row['price'];
    $hasil[$i]['stock'] = $row['stock'];
    $i++;
  }
  
  usort($hasil, "cmp");
  $no = 1;
  foreach ($hasil as $key) {
    $html .= '<tr>';
    $html .= '<td>' . $no . '</td>';
    $html .= '<td>' . $key['id_item'] . '</td>';
    $html .= '<td>' . $key['item_name'] . '</td>';
    $html .= '<td style="text-align:right">' . number_format($key['price']) . '</td>';
    $html .= '<td style="text-align:right">' . $key['stock'] . $key['unit'] . '</td>';

    $html .= '</tr>';
    $no++;
  }

  $array = array();
  $array['data'] = $html;
  echo json_encode($array);
?>
