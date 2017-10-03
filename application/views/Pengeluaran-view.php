<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Pengeluaran</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/vendor/bootstrap/css/bootstrap.css">
	<script src="<?php echo base_url()?>assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/vendor/jquery-ui/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/assets/vendor/jquery-ui/jquery-ui.css">
	<script src="<?php echo base_url()?>assets/vendor/popper/popper.js"></script>
	<script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.js"></script>		
	<script type="text/javascript" src="<?php echo base_url()?>/assets/vendor/DataTables/media/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/assets/vendor/DataTables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/assets/vendor/open-iconic/font/css/open-iconic-bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/main.css">
</head>
<style type="text/css">
	.ui-autocomplete { position: absolute; cursor: default;z-index:30 !important;} 
</style>
<body>

<div class="container" id="dashboard">	
	<div class="row">		
		<div class="col-12 text-center">
			<img src="<?php echo base_url()?>/assets/image/brand.png" alt="brand luh-pernak-pernik" class="brand">
		</div>
		<div class="col-12">			
			<ol class="breadcrumb">
			  <li class="breadcrumb-item"><a href="<?php echo site_url()?>">Luh pernak-pernik</a></li>			  
			  <li class="breadcrumb-item active">Pengeluaran</li>
			</ol>
		</div>
		<div class="col" id="headbar">			
			<div class="input-group mb-2 mb-sm-0 navigation-lpp" id="navigation-lpp">
				<div class="dropdown show">
				  <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">				    
				    <span class="oi oi-menu" title="icon menu" aria-hidden="true"></span>
				  </a>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
				    <a class="dropdown-item" href="<?php echo site_url()?>/Inventory">Inventory</a>
				    <a class="dropdown-item" href="<?php echo site_url()?>/Transaksi/Pembelian">Pembelian</a>
				    <a class="dropdown-item" href="<?php echo site_url()?>/Transaksi/Pengeluaran">Pengeluaran</a>
				  </div>
				</div>		       		       
	        </div>
		</div>
		<div class="col-12" id="temp-table-head">
			<button class="btn btn-primary btn-nota" id="btn-nota">Nota Pengeluaran Baru</button>
		</div>
		<div class=" col-12 table-responsive" style="position: relative">
			<table id="table-inventory" class="table table-stripped table-bordered"></table>	
        </div>		
		<div class="col-12" id="temp-table-foot"></div>
	</div>
	<!-- Modal nota -->
	<div class="modal fade" id="modalNota" tabindex="-1" role="dialog" aria-labelledby="modalNota" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Pengeluaran</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<div class="col-12" style="text-align:right;">
	      		<button class="btn btn-primary" id="tambah-item">tambah item</button>
	      	</div>
	        <div class="col-12" id="form-nota">
	        	<div class="form-group" id="component-item-1">
	        		<label for="item1">Item 1</label>
	        		<div class="row">
	        			<div class="col-4">
		        			<input type="text" name="kode-barang[]" class="form-control kode-barang" placeholder="Kode barang" id="kode-barang-1">
		        			<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<a class="dropdown-item" href="<?php echo site_url()?>/Inventory">Inventory</a>
								<a class="dropdown-item" href="<?php echo site_url()?>/Transaksi/Pembelian">Pembelian</a>
								<a class="dropdown-item" href="<?php echo site_url()?>/Transaksi/Pengeluaran">Pengeluaran</a>
							</div>
		        		</div>		        	
			        	<div class="col-4">
			        		<input type="text" name="nama-barang" class="form-control" placeholder="nama barang" id="nama-barang-1">
			        	</div>
			        	<div class="col-4">
			        		<input type="number" name="jumlah-barang" class="form-control" placeholder="jumlah barang" id="jumlah-barang-1">
			        	</div>			        	
	        		</div>
		        </div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary">Save changes</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>

</body>

<script type="text/javascript">
	$(document).ready(() =>{
		let redrawTableComponent = () =>{
			//moving search
			$("#navigation-lpp").append($("#table-inventory_filter"))			
			$("#navigation-lpp").append($("#navigation-lpp").find("input"))			
			$("#navigation-lpp").find("input").addClass("form-control")
			$("#navigation-lpp").find("input").attr("placeholder","search")

			//moving other component
			$("#temp-table-foot").append($("#table-inventory_info"))
			$("#temp-table-foot").append($("#table-inventory_paginate"))
			$("#temp-table-head").append($("#table-inventory_length"))
			$("#table-inventory_length").css("margin","10px 0")
		}

		let dataTable = $("#table-inventory").DataTable({
			processing: true,
			serverSide: true,
			language:{
				search: "",
				show: "tampilkan"
			},
			ajax: {
				url: "<?php echo site_url()?>/inventory/getInventory",
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
				console.log("done table Pengeluaran")
			}
		})

		let openModalNota = () => {
			$("#modalNota").modal({backdrop: "static"})
		}

		$("#btn-nota").on('click', () => {
			openModalNota()
		})
		let numberItem = 1;
		let tambahItem = () => {
			numberItem = numberItem+1
			let componentItem = `<div class="form-group" id="component-item-${numberItem}"><label for="item${numberItem}">Item ${numberItem}</label><div class="row"><div class="col-4"><input type="text" name="kode-barang[]" class="form-control kode-barang" placeholder="Kode barang" id="kode-barang-${numberItem}"></div><div class="col-4"><input type="text" name="nama-barang" class="form-control" placeholder="nama barang" id="nama-barang-${numberItem}"></div><div class="col-4"><input type="number" name="jumlah-barang" class="form-control" placeholder="jumlah barang" id="jumlah-barang-${numberItem}"></div></div></div>`
			$("#form-nota").append(componentItem)
		}

		$("#tambah-item").on("click", () => {
			tambahItem()
		})

		let autoCompleteKodeBarang = (req, res) => {
			$.ajax({
				url: "<?php echo site_url()?>/Transaksi/GetKodeBarang",
				type: "GET",
				ContentType: 'application/json',
                dataType: 'json',                     
                success: (result, status) => {                	
                	res(result)
                }
			})
		}		

		var availableTags = [
	      "ActionScript",
	      "AppleScript",
	      "Asp",
	      "BASIC",
	      "C",
	      "C++",
	      "Clojure",
	      "COBOL",
	      "ColdFusion",
	      "Erlang",
	      "Fortran",
	      "Groovy",
	      "Haskell",
	      "Java",
	      "JavaScript",
	      "Lisp",
	      "Perl",
	      "PHP",
	      "Python",
	      "Ruby",
	      "Scala",
	      "Scheme"
	    ];		

		$("#form-nota").on("keyup",'.kode-barang', (e) => {												
			let id = $(e.target).attr("id")
			let data = {}
			let dataKode
			$(`#${id}`).autocomplete({
				source: (req,res) => {
					$.ajax({
						url: "<?php echo site_url()?>/Transaksi/GetKodeBarang?key="+$(`#${id}`).val(),
						type: "GET",
						ContentType: 'application/json',
		                dataType: 'json',                     
		                success: (result, status) => {                	
		                	data = result
		                	dataKode = result.kode
		                	res(result.kode)
		                }
					})
				},
				appendTo: $(e.target).parent(),
				select: (event, ui) => {					
					let idNama = `nama-barang-${id.split("-").pop()}`
					$(`#${idNama}`).val(data.nama[ui.item.value])
				}
			})
		})
	})
</script>
</html>