<?php
  session_start();
  require_once "../model/dbconn.php";
  require_once "../model/pos.php";
  $method = $_POST['method'];
  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    $pos = new pos();
    if ($method == 'delete_user') {
      $id_user = strtoupper($_POST['id_user']);
      $pos = new pos();
      $array = $pos->deleteUser($id_user);
      $data['result'] = $array[0];
      $data['error'] = $array[1];
      echo json_encode($data);
    }

    if ($method == 'getdata') {
      $pos = new pos();
      $array = $pos->getListUser();
      $data = $array[1];
      $i = 0;
      foreach ($data as $key) {

        $data[$i]['button'] = '
          <button type="submit" id_user="' . $key['id_user'] . '" class="btn btn-warning btnpass  btn-sm" id="btnpass' . $key['id_user'] . '"  ><i class="fa fa-key"></i>
          </button>
          <button type="submit" id_user="' . $key['id_user'] . '" username="' . $key['username'] . '" h_menu="' . $key['h_menu'] . '" class="btn btn-primary btnedit btn-sm " id="btnedit' . $key['id_user'] . '"  ><i class="fa fa-edit"></i>
          </button>
          <button type="submit" id_user="' . $key['id_user'] . '" class="btn  btn-danger btndelete  btn-sm " id="btndelete' . $key['id_user'] . '" ><i class="fa fa-remove"></i>
            </button';

        $i++;
      }
      $datax = array('data' => $data);
      echo json_encode($datax);
    }

    if ($method == 'reset_password') {
      $id_user = $_POST['id_user'];
      $newpass = $_POST['new_pass'];
      $pos = new pos();
      $array = $pos->resetPass($id_user, $newpass);
      $result['result'] = $array[0];
      $result['error'] = $array[1];

      echo json_encode($result);
    }

    if ($method == 'save_user') {
      $id_user = $_POST['id_user'];
      $username = strtoupper($_POST['username']);
      $pass_user = strtoupper($_POST['pass_user']);
      $h_menu = strtoupper($_POST['h_menu']);
      $pos = new pos();
      if ($_POST['crud'] == 'N') {
        $array = $pos->saveUser($username, $pass_user, $h_menu);
      } else {
        $array = $pos->updateUser($id_user, $username, $h_menu);
      }
      $result['result'] = $array[0];
      $result['error'] = $array[1];
      $result['crud'] = $_POST['crud'];
      echo json_encode($result);
    }
  } else {
    exit('No direct access allowed.');
  }
?>
