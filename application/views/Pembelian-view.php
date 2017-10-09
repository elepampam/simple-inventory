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
			  <li class="breadcrumb-item active">Pembelian</li>
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
			<button class="btn btn-primary btn-nota" id="btn-nota">Nota Pembelian Baru</button>
		</div>
		<div class=" col-12 table-responsive" style="position: relative">
			<table id="table-pengeluaran" class="table table-stripped table-bordered"></table>	
        </div>		
		<div class="col-12" id="temp-table-foot"></div>
	</div>
	<!-- Modal nota -->
	<div class="modal fade" id="modalNota" tabindex="-1" role="dialog" aria-labelledby="modalNota" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Nota Pembelian</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		    <form action="<?php echo site_url()?>/Transaksi/SimpanNotaPembelian" method="POST">		      		    
		      	<div class="col-12" style="text-align:right;">
		      		<div class="form-group">
		      			<p for="pelanggan" style="text-align:left">Nama Toko :</p>
	        			<input type="text" name="nama-toko" class="form-control nama-toko" placeholder="Nama Toko" id="nama-toko">
	        		</div>
		      		<button type="button" class="btn btn-primary" id="tambah-item">tambah item</button>		      		
		      	</div>
		        <div class="col-12" id="form-nota">
		        	<h3>Item Terbeli: </h3>
		        	<div id="component-item-0" data-index="0">
		        		<div class="col-md-12 col-sm-12 item-section">
		        			<label for="item1">Item 1</label>
		        			<!-- <button class="btn btn-danger delete-item" data-component="1">x</button> -->
		        		</div>	        		
		        		<div class="row">
		        			<div class="col form-group">
			        			<input type="text" name="kode-barang[]" class="form-control kode-barang" placeholder="Kode barang" id="kode-barang-0" data-index="0">
			        		</div>		        	
				        	<div class="col form-group">
				        		<input type="text" name="nama-barang[]" class="form-control" placeholder="nama barang" id="nama-barang-0" data-index="0">
				        	</div>
				        	<div class="col form-group">
			        			<input type="text" name="jenis-barang[]" class="form-control jenis-barang" placeholder="Jenis barang" id="jenis-barang-0" data-index="0">
			        		</div>		        	
				        	<div class="col form-group">
				        		<input type="number" name="jumlah-barang[]" class="form-control jumlah-barang" placeholder="jumlah barang" id="jumlah-barang-0" data-index="0">
				        	</div>					
				        	<div class="col form-group">
			        			<input type="number" name="harga-barang[]" class="form-control harga-barang" placeholder="Total harga" id="harga-barang-0" data-index="0">
			        		</div>		        	        		        
		        		</div>
			        </div>
		        </div>
		        <hr>
	        	<div class="col-12 form-group">
	        		<label for="deskripsi">Deskripsi :</label>
	        		<textarea class="form-control" placeholder="deksripsi" id="deskripsi-nota" name="deskripsi"></textarea>
	        	</div>		        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <!-- <button type="button" class="btn btn-primary" id="simpan">Simpan</button> -->
	        <input type="submit" name="simpan" class="btn btn-primary" value="submit">
	      </div>
	      	</form>
	    </div>
	  </div>
	</div>

	<!-- modal view and edit -->		
	<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalEditView" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Nota <span id="headernota"></span></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">		         		   
	      	<div class="col-12" style="text-align:right;">
	      		<div class="form-group">
	      			<p for="pelanggan" style="text-align:left">Pelanggan :</p>
        			<input type="text" name="nama-pelanggan" class="form-control nama-pelanggan" placeholder="Nama Pelanggan" id="view-pelanggan" readonly="true">
        		</div>	      		
	      	</div>
	        <div class="col-12" id="form-view">
	        	<h3>Item Terbeli: </h3>
	        </div>
	        <hr>
        	<div class="col-12 form-group">
        		<label for="deskripsi">Deskripsi :</label>
        		<textarea class="form-control" placeholder="deksripsi" id="view-deskripsi" name="deskripsi" readonly="true"></textarea>
        	</div>		        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>	        	        
	      </div>	      	
	    </div>
	  </div>
	</div>
</div>
</body>

<script type="text/javascript">
	$(document).ready(() =>{

		$('#form-nota').on('focusin', 'input, textarea', function(event) {
		  if(navigator.userAgent.indexOf('Android') > -1 && navigator.userAgent.indexOf('iPhone')){
		   var scroll = $(this).offset();
		   window.scrollTo(0, scroll);
		 }
		});

		let redrawTableComponent = () =>{
			//moving search
			$("#navigation-lpp").append($("#table-pengeluaran_filter"))			
			$("#navigation-lpp").append($("#navigation-lpp").find("input"))			
			$("#navigation-lpp").find("input").addClass("form-control")
			$("#navigation-lpp").find("input").attr("placeholder","search")

			//moving other component
			$("#temp-table-foot").append($("#table-pengeluaran_info"))
			$("#temp-table-foot").append($("#table-pengeluaran_paginate"))
			$("#temp-table-head").append($("#table-pengeluaran_length"))
			$("#table-pengeluaran_length").css("margin","10px 0")
		}

		let dataTable = $("#table-pengeluaran").DataTable({
			processing: true,
			serverSide: true,
			language:{
				search: "",
				show: "tampilkan"
			},
			ajax: {
				url: "<?php echo site_url()?>/Transaksi/GetBukuPembelian",
				type: "POST",
				dataType: "json"
			},
			columns: [
				{
					data: "NO_BUKU",
					title: "NO BUKU"
				},
				{
					data: "TANGGAL_BELI",
					title: "TANGGAL BELI"
				},
				{
					data: "TOKO_BELI",
					title: "TOKO BELI"
				},
				{
					data: "DESKRIPSI",
					title: "DESKRIPSI"
				},{
					data: "ACTION",
					title: "ACTION"
				}
			],
			initComplete: () => {
				redrawTableComponent()
				$('[data-toggle="tooltip"]').tooltip()
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
	
		let notaItem = []
		let numberItem = 1
		let indexItem = 1
		let tambahItem = () => {
			numberItem = numberItem+1			
			indexItem = indexItem+1
			notaItem[indexItem] = {
				kodeBarang: "",
				namaBarang: "",
				jumlah:0
			}
			let componentItem = `
			<div id="component-item-${numberItem}" data-index="${indexItem}">
        		<div class="col-md-12 col-sm-12 item-section">
        			<label for="item${numberItem}">Item ${numberItem}</label>
        			<button class="btn btn-danger delete-item" data-component="${numberItem}">x</button>
        		</div>	        		
        		<div class="row">
        			<div class="col form-group">
	        			<input type="text" name="kode-barang[]" class="form-control kode-barang" placeholder="Kode barang" id="kode-barang-${numberItem}" data-index="${indexItem}">
	        		</div>		        	
		        	<div class="col form-group">
		        		<input type="text" name="nama-barang[]" class="form-control" placeholder="nama barang" id="nama-barang-${numberItem}" data-index="${indexItem}">
		        	</div>
		        	<div class="col form-group">
	        			<input type="text" name="jenis-barang[]" class="form-control kode-barang" placeholder="Jenis barang" id="jenis-barang-${numberItem}" data-index="${indexItem}">
	        		</div>		        	
		        	<div class="col form-group">
		        		<input type="number" name="jumlah-barang[]" class="form-control jumlah-barang" placeholder="jumlah barang" id="jumlah-barang-${numberItem}" data-index="${indexItem}">
		        	</div>					
		        	<div class="col form-group">
	        			<input type="number" name="harga-barang[]" class="form-control harga-barang" placeholder="Total harga" id="harga-barang-${numberItem}" data-index="${indexItem}">
	        		</div>		        	        		        
        		</div>
	        </div>`
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
                	}                	
                }
			})
		}		
		$("#form-nota").on("change",'.kode-barang', (e) => {			
			
		})		

		$("#form-nota").on("change",'.jumlah-barang', (e) => {						
			
		})


		$("#form-nota").on("click", ".delete-item", (e) => {
			let noId = $(e.target).data("component")
			let index = $(`#component-item-${noId}`).data('index')
			if (noId > 1) {
				hapusItem(noId, index)
			}			
		})

		let hapusItem = (noId, index) =>{
			let kodeBarang = $(`#kode-barang-${noId}`).val()
			let jumlahBarang = parseInt($(`#jumlah-barang-${noId}`).val())			
			notaItem[index] = {}
			// console.log(notaItem)
			// console.log(localStorage)
			$(`#component-item-${noId}`).remove()
		}

		$("#form-nota").on('keydown', 'input', (e) => {
			console.log(e.keyCode)
			if (e.keyCode == 13) {
				e.preventDefault()
				return false
			}
		})

		$("#form-nota").on('focusin', '.jumlah-barang,.harga-barang', (e) => {
			let val = $(e.target).val()
			if (val == "") {
				$(e.target).val(0)
			}
		})

		$("#form-nota").on('focusout', '.jumlah-barang,.harga-barang', (e) => {
			let val = $(e.target).val()
			if (val == 0) {
				$(e.target).val("")
			}
		})

		
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
				event.preventDefault();
				return false;
			}
		});		

		// view edit delete action here
		$('#table-pengeluaran').on("click",".btn-view",(e) =>{			
			let noNota = $(e.currentTarget).data("nobuku")					
			$.ajax({
				url: "<?php echo site_url()?>/Transaksi/GetDetailPembelian?no-buku="+noNota,
				type: "GET",
				ContentType: 'application/json',
                dataType: 'json',                     
                success: (result, status) => { 
               		let indexView = 0
               		console.log(result)               		
               		$("#headernota").html(noNota)
               		$("#view-pelanggan").val(result.toko)
               		$("#view-deskripsi").val(result.deskripsi)               		
               		let appendComponent = ""
               		result.items.map((item) => {               			
               			let componentView = `
               			<div class="component-view" id="component-view-0" data-index="0">
			        		<div class="col-md-12 col-sm-12 item-section">
			        			<label for="item${indexView}">Item ${indexView+1}</label>		        			
			        		</div>	        		
			        		<div class="row">
			        			<div class="col form-group">
				        			<input type="text" name="kode-barang[]" class="form-control kode-barang" placeholder="Kode barang" id="view-kode-barang-${indexView}" data-index="0" readonly="true" value="${item.KODE_BARANG}">
				        		</div>		        	
					        	<div class="col form-group">
					        		<input type="text" name="nama-barang[]" class="form-control" placeholder="nama barang" id="view-nama-barang-${indexView}" data-index="0" readonly="true" value="${item.NAMA_BARANG}">
					        	</div>
					        	<div class="col form-group">
				        			<input type="text" name="jenis-barang[]" class="form-control kode-barang" placeholder="Jenis barang" id="view-jenis-barang-${indexView}" data-index="0" readonly="true" value="${item.JENIS_BARANG}">
				        		</div>	
					        	<div class="col form-group">
					        		<input type="text" name="jumlah-barang[]" class="form-control jumlah-barang" placeholder="jumlah barang" id="view-jumlah-barang-${indexView}" data-index="0" readonly="true" value="${item.JUMLAH}">
					        	</div>
					        	<div class="col form-group">
					        		<input type="text" name="harga-barang[]" class="form-control harga-barang" placeholder="Harga total" id="view-harga-barang-${indexView}" data-index="0" readonly="true" value="${item.HARGA_BELI}">
					        	</div>					        		        
			        		</div>
				        </div>`               
				        indexView++
               			appendComponent += componentView
               		})
               		$("#form-view").append(appendComponent)
               		$("#modalView").modal()
                }
			})
		})

		$("#modalView").on("hidden.bs.modal", (e) => {
			$("#form-view").find(".component-view").remove()
			$("#headernota").html("")
       		$("#view-pelanggan").val("")
       		$("#view-deskripsi").val("")               		
		})

		$("#table-pengeluaran").on("click",".btn-delete",(e) => {
			let noNota = $(e.currentTarget).data("nobuku")
			let deleteIt = confirm(`Yakin ingin menghapus nota no ${noNota} ?`)
			if (deleteIt) {
				return true
			} else {
				return false
			}
		})

	})
</script>
</html>