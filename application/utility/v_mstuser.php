<?php 
  $titlepage="Master User";
  $idsmenu=3;

  include "../../library/config.php";
  require_once("../model/dbconn.php");
  require_once("../model/pos.php");
  include "../layout/top-header.php"; 
  include "../../library /check_login.php";
  include "../../library /check_access.php";
  include "../layout/header.php"; ?>

<section class="content">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Master User</h3>
    </div>

    <div class="box-body">
      <button type="submit" class="btn btn-primary " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Add User</button>
      <br>
      <div class="box-body table-responsive no-padding">
        <table id="table_user" class="table  table-bordered table-hover ">
          <thead>
            <tr class="tableheader">
              <th style="width:30px">#</th>
              <th style="width:100px">Username</th>
              <th style="width:200px">Level</th>
              <th style="width:150px"></th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<div id="modalmasteruser" class="modal fade ">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Master user Form</h4>
      </div>

      <!--modal header-->
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2  control-label">Username</label>
              <div class="col-sm-6">
                <input type="text" class="form-control text-uppercase" id="txtusername" name="" value="" placeholder="">
                <input type="hidden" id="txtiduser" name="inputcrud" class="" value="0">
                <input type="hidden" id="inputcrud" name="inputcrud" class="" value="N">
                <input type="hidden" id="hmenu" name="" class="" value=""> </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2  control-label">Password</label>
                <div class="col-sm-6">
                  <input type="password" class="form-control " id="txtpass" name="" value="" placeholder=""> </div>
                </div>
              </div>
            </div>

            <!--form menuk-->
            <?php
            $pos = new pos();
            $mymenu = $pos->getMenu();
            $num=1;
            $menuku='';
            foreach ($mymenu[1] as $key) {
              if($num==1) {
                $menuku .= '<div class="row" >';
                $menuku .= '<div class="col-xs-6" style="padding-left:0px"><h4>'.$key['name_menu'].'</h4>';
                $submenuk = $pos->getSubMenu($key['id_menu']);
                $menuku .= '<ul class="list-group">'; 
                foreach ($submenuk[1] as $keys) {
                  $menuku .= '<li class="list-group-item">
                  <input type="checkbox"  id="check-'.$keys["id_sub_menu"].'" class="chkbox"
                    value="'.$keys['id_sub_menu'].'" > <strong>'.$keys['name_sub_menu'].'</strong>
                  </li>'; 
                }
                $menuku .= '</ul>'; 
                $menuku .= '</div>';
              } else {
                $menuku .= '<div class="col-xs-6" style="padding-left:0px"><h4>'.$key['name_menu'].'</h4>';
                $submenuk = $pos->getSubMenu($key['id_menu']);
                $menuku .= '<ul class="list-group">'; 
                foreach ($submenuk[1] as $keys) {
                  $menuku .= '<li class="list-group-item"><input type="checkbox" id="check-'.$keys["id_sub_menu"].'"
                    class="chkbox" value="'.$keys['id_sub_menu'].'" > <strong>'.$keys['name_sub_menu'].'</strong></li>';
                }
                $menuku .= '</ul>';
                $menuku .= '</div>';
                $menuku .= '</div>';
                $num=0;
              }
              $num++;
            }
            ?>
            <div class="form-horizontal menuk" >
              <div class="box-body">
                <div class="form-group">  
                  <label class="col-sm-2  control-label">Menu Access</label> 
                  <div class="col-xs-10">
                    <div>
                      <input type="checkbox" id="check-all" class="txtcheckbox2"> <b>Selected All</b>
                    </div>
                    <?php echo $menuku; ?>
                  </div> 
                </div>
              </div>
            </div> 
            <div class="form-horizontal">
              <div class="box-body">
                <div class="form-group">   
                  <label class="col-sm-2  control-label"></label>
                  <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary " id="btnsaveuser" name="btnsaveuser"><i class="fa fa-save"></i> Save</button>
                  </div>  
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- modal dialog untuk password -->
  <div id="passwordmodal" class="modal fade ">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Reset Password</h4>
        </div>

        <div class="modal-body"><div class="form-horizontal"><div class="box-body"><div class="form-group">   <label class="col-sm-3  control-label">Reset Password</label>   <div class="col-sm-9"><input type="password" class="form-control " id="txtresetpass" name="txtresetpass" value="" placeholder=""><input type="hidden" id="txthiduser" name="" class="" value="">    </div>  </div><div class="form-group">   <label class="col-sm-3  control-label"><button type="submit" class="btn btn-primary " id="btnresetpassword" name="btnresetpassword"><i class="fa  fa-key"></i> Reset Password</button> <span id="infopassword"></span></label>   <div class="col-sm-9">    </div>  </div></div></div></div><div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include "../layout/footer.php"; //footer template ?> 
<?php include "../layout/bottom-footer.php"; //footer template ?> 
<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="j_mstuser.js"></script>

</body>
</html>
