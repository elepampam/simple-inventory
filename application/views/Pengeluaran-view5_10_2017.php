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
	        <h5 class="modal-title" id="exampleModalLabel">Nota Pengeluaran</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<div class="col-12" style="text-align:right;">
	      		<div class="form-group">
	      			<p for="pelanggan" style="text-align:left">Pelanggan :</p>
        			<input type="text" name="nama-pelanggan" class="form-control nama-pelanggan" placeholder="Nama Pelanggan" id="nama-pelanggan">
        		</div>
	      		<button class="btn btn-primary" id="tambah-item">tambah item</button>
	      	</div>
	        <div class="col-12" id="form-nota">
	        	<h3>Item Terpakai: </h3>
	        	<div id="component-item-1">
	        		<div class="col-md-12 col-sm-12 item-section">
	        			<label for="item1">Item 1</label>
	        			<button class="btn btn-danger delete-item" data-component="1">x</button>
	        		</div>	        		
	        		<div class="row">
	        			<div class="col-md-4 col-sm-12 form-group">
		        			<input type="text" name="kode-barang[]" class="form-control kode-barang" placeholder="Kode barang" id="kode-barang-1" data-index="0">
		        		</div>		        	
			        	<div class="col-md-4 col-sm-12 form-group">
			        		<input type="text" name="nama-barang" class="form-control" placeholder="nama barang" id="nama-barang-1" data-index="0">
			        	</div>
			        	<div class="col-md-4 col-sm-12 form-group">
			        		<input type="number" name="jumlah-barang" class="form-control jumlah-barang" placeholder="jumlah barang" id="jumlah-barang-1" data-index="0">
			        	</div>					        		        
	        		</div>
		        </div>
	        </div>
	        <hr>
        	<div class="col-12 form-group">
        		<label for="deskripsi">Deskripsi :</label>
        		<textarea class="form-control" placeholder="deksripsi" id="deskripsi-nota"></textarea>
        	</div>	
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
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
			$("body").css("overflow", "hidden");
			$("#modalNota").modal({backdrop: "static"})
		}

		$("#btn-nota").on('click', () => {
			openModalNota()
		})

		let stackItem = {}
		let notaItem = []
		let numberItem = 1
		let indexItem = 0
		let tambahItem = () => {
			numberItem = numberItem+1			
			indexItem = indexItem+1
			notaItem[indexItem] = {
				kodeBarang: "",
				namaBarang: "",
				jumlah:0
			}
			let componentItem = `<div id="component-item-${numberItem}"><div class="col-sm-12 col-md-12"><button class="btn btn-danger delete-item" data-component="${numberItem}">x</button><label for="item${numberItem}">Item ${numberItem}</label></div><div class="row"><div class="col-md-4 col-sm-12 form-group"><input type="text" name="kode-barang[]" class="form-control kode-barang" placeholder="Kode barang" id="kode-barang-${numberItem}" data-index=${indexItem}></div><div class="col-md-4 col-sm-12 form-group"><input type="text" name="nama-barang" class="form-control" placeholder="nama barang" id="nama-barang-${numberItem}" data-index=${indexItem}></div><div class="col-md-4 col-sm-12 form-group"><input type="number" name="jumlah-barang" class="form-control jumlah-barang" placeholder="jumlah barang" id="jumlah-barang-${numberItem}" data-index=${indexItem}></div></div></div>`
			$("#form-nota").append(componentItem)
		}

		$("#tambah-item").on("click", () => {
			tambahItem()
		})	

		$("#form-nota").on("keyup",'.kode-barang', (e) => {												
			let id = $(e.target).attr("id")
			let data = []
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
		                	res(result)
		                }
					})
				},
				appendTo: $(e.target).parent(),
				select: (event, ui) => {							
					$.ajax({
						url: "<?php echo site_url()?>/Transaksi/GetNamaBarang?key="+ui.item.value,
						type: "GET",
						ContentType: 'application/json',
		                dataType: 'json',                     
		                success: (result, status) => {                	
		                	let idNama = `nama-barang-${id.split("-").pop()}`
							$(`#${idNama}`).val(result.nama)
		                }
					})
				}
			})
		})

		let checkKodeBarang = (kodeBarang, componentNoId, index) => {		
			let component = `component-item-${componentNoId}`;						
			$.ajax({
				url: "<?php echo site_url()?>/Transaksi/CheckAvailableItem?kode-barang="+kodeBarang,
				type: "GET",
				ContentType: 'application/json',
                dataType: 'json',                     
                success: (result, status) => {     
                	console.log(result)         
                	$(`#${component}`).find('.alert').remove()  	
                	if (!result.available) {                		
                		let alertKetersediaan = '<div class="alert alert-danger" role="alert" style="margin: 5px 0;">Barang tidak tersedia pada inventory atau stock kosong! Silahkan pilih barang lainnya</div>'
                		$(`#${component}`).append(alertKetersediaan)
                	}
                	else{               		
                		notaItem[index] = {
                			kodeBarang: $(`#kode-barang-${componentNoId}`).val(),
                			namaBarang: $(`#nama-barang-${componentNoId}`).val(),
                			jumlah: $(`#jumlah-barang-${componentNoId}`).val()
                		}                		
                		console.log(notaItem)
                		if (stackItem[kodeBarang] != undefined) {
                			if ($(`#jumlah-barang-${componentNoId}`).val() != "") {
                				tempJumlah = $(`#jumlah-barang-${componentNoId}`).val()
                				stackItem[kodeBarang] = parseInt(stackItem[kodeBarang]) + parseInt(tempJumlah)
                			} 
                			else {
                				if (notaItem[index].jumlah != 0) {
                					stackItem[kodeBarang] = parseInt(stackItem[kodeBarang]) + 0
                				} else {
                					stackItem[kodeBarang] = 0
                				}                				
                			}                			
                		} 
                		else {
                			stackItem[kodeBarang] = 0
                			if ($(`#jumlah-barang-${componentNoId}`).val() != "") {
                				tempJumlah = $(`#jumlah-barang-${componentNoId}`).val()
                				stackItem[kodeBarang] = parseInt(stackItem[kodeBarang]) + parseInt(tempJumlah)
                			}              			
                		}
                	}
                	console.log(stackItem)
                }
			})
		}

		$("#form-nota").on("change",'.kode-barang', (e) => {			
			let noId = $(e.target).attr('id').split("-").pop()			
			checkKodeBarang($(e.target).val(), noId, $(e.target).data('index'))
		})		

		$("#form-nota").on("change",'.jumlah-barang', (e) => {						
			let noId = $(e.target).attr('id').split("-").pop()
			let kodeBarang = $(`#kode-barang-${noId}`).val()			
			if (stackItem[kodeBarang] != undefined) {
				let bantu = parseInt($(e.target).val()) - notaItem[$(e.target).data("index")].jumlah				
				stackItem[kodeBarang] = parseInt(stackItem[kodeBarang]) + bantu				
			}			
			else if(kodeBarang != ""){
				stackItem[kodeBarang] = $(e.target).val()
			}
			console.log(stackItem)
			if (kodeBarang != "") {
				checkJumlahBarang(stackItem[kodeBarang], noId, $(e.target).data("index"))
			}			
		})

		let checkJumlahBarang = (jumlah, componentNoId, index) => {					
			let component = `component-item-${componentNoId}`
			let kodeBarang = $(`#kode-barang-${componentNoId}`).val()
			$.ajax({
				url: "<?php echo site_url()?>/Transaksi/CheckJumlahItem?kode-barang="+kodeBarang+"&jumlah="+jumlah,
				type: "GET",
				ContentType: 'application/json',
                dataType: 'json',                     
                success: (result, status) => {     
                	// console.log(result)         
                	$(`#${component}`).find('.alert').remove()  	
                	if (!result.available) {                		
                		let alertKetersediaan = '<div class="alert alert-danger" role="alert" style="margin: 5px 0;">Stock barang pada inventory tidak mencukupi atau kosong</div>'
                		$(`#${component}`).append(alertKetersediaan)
                	}
                	else{
                		notaItem[index] = {
                			kodeBarang: $(`#kode-barang-${componentNoId}`).val(),
                			namaBarang: $(`#nama-barang-${componentNoId}`).val(),
                			jumlah: $(`#jumlah-barang-${componentNoId}`).val()
                		}     
                		console.log(notaItem)
                	}
                }
			})
		}

		$("#form-nota").on("click", ".delete-item", (e) => {
			let noId = $(e.target).data("component")
			if (noId > 1) {
				hapusItem(noId)
			}			
		})

		let hapusItem = (noId) =>{
			let kodeBarang = $(`#kode-barang-${noId}`).val()
			let jumlahBarang = $(`#jumlah-barang-${noId}`).val()
			console.log(noId)			
		}
	})
</script>
</html>