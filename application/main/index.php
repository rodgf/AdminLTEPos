<?php include "../../library/config.php"; ?>
<?php $titlepage="Dashboard"; ?>
<?php
  require_once("../model/dbconn.php");
  require_once("../model/pos.php");
  include "../layout /top-header.php"; 
  include "../../library /check_login.php";

  include "../layout/header.php"; 
?>
<section style="margin-bottom:10px;" class="content-header">
	<h1>
		Dashboard
		<small>Page</small>
	</h1>
</section>
<section class="content-main">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-danger">
				<?php
				$pos = new pos();
				$toko = $pos->getrefsytem();
				$nameshop = $toko[1]['name_shop'];
				$address_shop = $toko[1]['address_shop'];
				$phoneshop = $toko[1]['phone_shop'];
				?>
				<div class="box-header">
					<h1 class="box-title"><?php echo $nameshop;?></h1>
				</div>
				<div class="box-body">
					<h4><?php echo $address_shop;?></h4>
					<h5>Telp : <?php echo $phoneshop;?></h5>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-9">
			<div class="box box-info">
				<div class="box box-info">
					<div class="box-header">
						<h3 class="box-title">Search Item</h3>
					</div>

					<div class="row">
						<div class=" col-xs-12" style="padding-left:25px;padding-right:25px">
							<input type="text" class="form-control " id="txtsearchitem" placeholder="Search item or item id here...">
						</div>
					</div>				
					<div class="box-body">
						<div class="box-body table-responsive no-padding" style="max-width:900px;">
							<table id="table_search" class="table  table-bordered table-hover table-striped">
								<thead>
									<tr class="tableheader">
										<th style="width:40px">#</th>
										<th style="width:60px">Id</th>
										<th style="width:300px">Items</th>
										<th style="width:100px">Price</th>
										<th style="width:120px">Stock</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>				
					</div>

				</div>

			</div>
		</div>

		<div class="col-md-3">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>30</h3>
					<p>Today Sales</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="#" id="lapjuals" class="small-box-footer"> More Detail <i class="fa fa-arrow-circle-right"></i></a>
			</div>

			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>10</h3>
					<p>Out of stock items</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</section>

	<?php include "../layout/footer.php"; //footer template ?> 
	<?php include "../layout/bottom-footer.php"; //footer template ?> 

	<script src="../../dist/js/redirect.js"></script>
	<script>
		$(document).on("keyup keydown","#txtsearchitem",function(){
			var searchitem = $("#txtsearchitem").val();
			value={
				term : searchitem,
			}
			$.ajax({
				url : "../master/c_search_item.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR){
					var data = jQuery.parseJSON(data);
					$("#table_search tbody").html(data.data)
				},
				error: function(jqXHR, textStatus, errorThrown) {
					
				}
			});
		});
	</script>
</body>
</html>
