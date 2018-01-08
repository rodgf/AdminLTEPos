<?php
	require_once "../model/dbconn.php";
	require_once "../model/pos.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>How to create struck note pdf in PHP by seegatesite.com</title>

	<link rel="stylesheet" href="../../bower_components/boostrap/dist/css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.css" type="text/css" />
</head>
<body>
	<h1>Generate Sales Notes</h1>
	<table>
		<tr>
			<td>Sales ID</td>
			<td>
				<select class="form-control" id="id" name="id">
					<?php
						$pos = new pos();
						$sales = $pos->getSalesId();
						foreach ($sales as $sale) {
					?>
						<option value="<?php echo $sale["sale_id"];?>"><?php echo $sale["sale_id"];?></option>
					<?php
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<button class="btn btn-default" id="print">Download Struck PDF</button>
			</td>
		</tr>
		<tr>
			<td>
				<button class="btn btn-default" id="open">View Struck PDF</button>
			</td>
		</tr>
	</table>

	<script type="text/javascript" src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="../../bower_components/boostrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../dist/js/jquery.redirect.js"></script>
	<script type="text/javascript">

		// 
		$("#print").click(function() {
			var id = $("#id").val();
			console.log(id);
			$.redirect("struck.php", {
				id_sales: id,
				duplicate:0
			}, 'POST', '_blank'); 
		});

		// 
		$("#open").click(function() {
			var id = $("#id").val();
			window.open("struck.php?id=" + id);
		});
	</script>

</body>
</html>
