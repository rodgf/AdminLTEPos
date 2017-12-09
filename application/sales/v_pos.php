<?php 
  $titlepage="Master Item";
  $idsmenu=1; 

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
			<h3 class="box-title">Master Item</h3>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Add Item</button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_item" class="table  table-bordered table-hover ">
					<thead>
						<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:300px">Item</th>
							<th style="width:120px">Price</th>
							<th style="width:60px">Stok</th>
							<th style="width:250px">Note</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div>
</section>

<div id="modalmasteritem" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Master Item Form</h4>
			</div>

			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-1  control-label">Id</label>
							<div class="col-sm-11"><input type="text" class="form-control " id="txtiditem" name="txtiditem" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-1  control-label">Item</label>
							<div class="col-sm-11"><input type="text" class="form-control " id="txtname" name="txtname" value="" placeholder="Please fill out item name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-1  control-label">Stok</label>
							<div class="col-sm-11"><input type="text" class="form-control decimal" id="txtstock" name="" value="0" placeholder=""> </div>
						</div>
						<div class="form-group"> <label class="col-sm-1  control-label">Unit</label>
							<div class="col-sm-11"><input type="text" class="form-control " id="txtunit" name="" value="" placeholder="Please fill out unit name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-1  control-label">Price</label>
							<div class="col-sm-11">
								<div class="input-group">
									<span class="input-group-addon">Rp.</span>
									<input type="text" class="form-control money" id="txtprice" name="" value="" placeholder=""></div>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-1  control-label">Note</label>
								<div class="col-sm-11"><textarea class="form-control " rows="3" id="txtnote" name="" placeholder="Note"></textarea> </div>
							</div>
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsaveitem" name=""><i class="fa fa-save"></i> Save</button> <span id="infoproses"></span> </div>
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


	<?php include "../layout/footer.php"; //footer template ?> 
	<?php include "../layout/bottom-footer.php"; //footer template ?> 
	<script src="j_item.js"></script>

</body>
</html>
