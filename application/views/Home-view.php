<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>home</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/vendor/bootstrap/css/bootstrap.css">
	<script src="<?php echo base_url()?>assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url()?>assets/vendor/popper/popper.js"></script>
	<script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.js"></script>		
	<script type="text/javascript" src="<?php echo base_url()?>/assets/vendor/DataTables/media/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/assets/vendor/DataTables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/assets/vendor/open-iconic/font/css/open-iconic-bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/main.css">
</head>
<body>

<div class="container" id="dashboard">	
	<div class="row">		
		<div class="col-12 text-center">
			<img src="<?php echo base_url()?>/assets/image/brand.png" alt="brand luh-pernak-pernik" class="brand">
		</div>
		<div class="col-12">			
			<ol class="breadcrumb">
			  <li class="breadcrumb-item"><a href="<?php echo site_url()?>">Luh pernak-pernik</a></li>			  
			  <li class="breadcrumb-item active">Inventory</li>
			</ol>
		</div>
		<div class="col" id="headbar">			
			<div class="input-group mb-2 mb-sm-0 navigation-lpp" id="navigation-lpp">
				<div class="dropdown show">
				  <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">				    
				    <span class="oi oi-menu" title="icon menu" aria-hidden="true"></span>
				  </a>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
				    <a class="dropdown-item" href="#">Inventory</a>
				    <a class="dropdown-item" href="#">Pembelian</a>
				    <a class="dropdown-item" href="#">Pengeluaran</a>
				  </div>
				</div>		       
		       <!-- <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Username"> -->
	        </div>
		</div>
		<div class=" col-12 table-responsive" style="position: relative">
			<table id="table-inventory" class="table table-stripped table-bordered"></table>	
        </div>		
		<div class="temp-table-foot"></div>
	</div>
</div>

</body>

<script type="text/javascript">
	$(document).ready(() =>{
		let redrawTableComponent = () =>{
			$("#navigation-lpp").append($("#table-inventory_filter"))			
			$("#navigation-lpp").append($("#navigation-lpp").find("input"))			
			$("#navigation-lpp").find("input").addClass("form-control")
			$("#navigation-lpp").find("input").attr("placeholder","search")
			// $("#table-inventory_filter").html('<input type="search" class="form-control" placeholder="search" aria-controls="table-inventory">')
		}

		let dataTable = $("#table-inventory").DataTable({
			processing: true,
			serverSide: true,
			language:{
				search: "",
				show: "tampilkan"
			},
			ajax: {
				url: "<?php echo site_url()?>/home/getInventory",
				type: "POST",
				dataType: "json"
			},
			columns: [
				{
					data: "KODE_BARANG",
					title: "KODE BARANG"
				},
				{
					data: "JENIS_BARANG",
					title: "JENIS BARANG"
				},
				{
					data: "NAMA_BARANG",
					title: "NAMA BARANG"
				},
				{
					data: "JUMLAH",
					title: "JUMLAH"
				},
				{
					data: "HARGA_POKOK",
					title: "HARGA POKOK"
				},
				{
					data: "HARGA_TOTAL",
					title: "HARGA TOTAL"
				}
			],
			initComplete: () => {
				redrawTableComponent()
				console.log("done table inventory")
			}
		})
	})
</script>
</html>