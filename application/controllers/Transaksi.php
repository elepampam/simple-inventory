<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {
	public function Pembelian(){
		$this->load->view("Pembelian-view");
	}

	public function Pengeluaran(){
		$this->load->view("Pengeluaran-view");
	}

	public function GetKodeBarang(){
		$this->load->model("InventoryModel", "inventorymodel");
		$key = $this->input->get('key');
		$result = $this->inventorymodel->GetKodeBarang($key);
		$kodeBarang = array();	
		if (!empty($result)) {
			foreach ($result as $kode) {				
				array_push($kodeBarang, $kode->KODE_BARANG);
			}
		}				
		else
			array_push($kodeBarang, 'kode barang not found');		
		echo json_encode($kodeBarang);
	}

	public function GetNamaBarang(){
		$this->load->model("InventoryModel", "inventorymodel");
		$key = $this->input->get('key');
		$result = $this->inventorymodel->GetNamaBarang($key);		
		if (!empty($result)) {
			$response = array(
				"nama" => $result->NAMA_BARANG
			);
		}				
		else{
			$response = array(
				"nama" => "nama barang tidak ditemukan"
			);
		}		
		echo json_encode($response);
	}

	public function CheckAvailableItem(){
		$kodeBarang = $this->input->get("kode-barang");
		$this->load->model("InventoryModel", "inventorymodel");
		$available = $this->inventorymodel->checkItem($kodeBarang);
		if ($available) {
			$response = array(
				"available" => true
			);	
		}	
		else{
			$response = array(
				"available" => false
			);
		}	
		echo json_encode($response);
	}

	public function CheckJumlahItem(){
		$kodeBarang = $this->input->get("kode-barang");
		$jumlahWanted = $this->input->get("jumlah");
		$this->load->model("InventoryModel", "inventorymodel");
		$item = $this->inventorymodel->getJumlahItem($kodeBarang);		
		if (!empty($item)) {			
			if ($item->JUMLAH - $jumlahWanted >= 0) {
				$response = array(
					"available" => true
				);
			}
			else{
				$response = array(
					"available" =>false
				);
			}
		}
		else{
			$response = array(
				"available" =>false
			);
		}
		echo json_encode($response);
	}

	private function updatePengeluaranInventory($items){
		$query = "REPLACE INTO `inventory` (`KODE_BARANG`,`JENIS_BARANG`,`NAMA_BARANG`,`HARGA_POKOK`,`JUMLAH`) VALUES ";
		$this->load->model('InventoryModel', 'inventorymodel');
		$result = $this->inventorymodel->getAllInventoryArray($items['kode']);						
		for ($i=0; $i < count($result) ; $i++) { 
			$result[$i]["JUMLAH"] = $result[$i]["JUMLAH"] + $items['jumlah'][$result[$i]["KODE_BARANG"]];
			$query = $query."('".$result[$i]['KODE_BARANG']."', '".$result[$i]['JENIS_BARANG']."', '".$result[$i]['NAMA_BARANG']."', '".$result[$i]['HARGA_POKOK']."', '".$result[$i]['JUMLAH']."') ";
			if (isset($result[$i+1])) {
				$query .= ", ";
			}
		}			
		$updateResult = $this->inventorymodel->updateInventory($query);
		return $updateResult;		
	}

	public function SimpanNotaPenjualan(){		
		$generatedIdNota = uniqid();
		$this->load->model("TransaksiModel", "transaksimodel");
		while ($this->transaksimodel->checkGeneratedId("buku_pengeluaran", $generatedIdNota)) {
			$generatedIdNota = uniqid();
		}
		$pelanggan = $this->input->post('nama-pelanggan');
		$deskripsi = $this->input->post('deskripsi');
		$kodeBarang = $this->input->post('kode-barang');
		$namaBarang = $this->input->post('nama-barang');
		$jumlah = $this->input->post('jumlah-barang');

		$items = array();		
		$pengeluaran = array();
		$nota = array(
			"NO_BUKU" => $generatedIdNota,
			"TANGGAL_KELUAR" => date("Y-m-d"),
			"PELANGGAN" => $pelanggan,
			"DESKRIPSI" => $deskripsi
		);

		$items["kode"] = array();				
		$items["jumlah"] = array();				
		for ($i=0; $i < count($kodeBarang); $i++) { 			
			if (isset($items["jumlah"][$kodeBarang[$i]])) {				
				$items["jumlah"][$kodeBarang[$i]] = $items["jumlah"][$kodeBarang[$i]] + $jumlah[$i] * -1;				
			}
			else{
				array_push($items["kode"], $kodeBarang[$i]);
				$items["jumlah"][$kodeBarang[$i]] = $jumlah[$i] * -1;				
			}			

			if (count($pengeluaran) == 0) {
				array_push($pengeluaran, array(
					"NO_PENGELUARAN" => $generatedIdNota,
					"KODE_BARANG" => $kodeBarang[$i],
					"JUMLAH" => $jumlah[$i]
				));	
			}		
			else{
				$isFound = false;
				for ($indeksPengeluaran=0; $indeksPengeluaran < count($pengeluaran); $indeksPengeluaran++) { 
					if ($pengeluaran[$indeksPengeluaran]["KODE_BARANG"] == $kodeBarang[$i]) {
						$pengeluaran[$indeksPengeluaran]["JUMLAH"] += $jumlah[$i];
						$isFound = true;
						break;
					}
				}
				if (!$isFound) {
					array_push($pengeluaran, array(
						"NO_PENGELUARAN" => $generatedIdNota,
						"KODE_BARANG" => $kodeBarang[$i],
						"JUMLAH" => $jumlah[$i]
					));
				}
			}	
		}						
		$this->updatePengeluaranInventory($items);		
		$this->transaksimodel->insertBukuPengeluaran($nota);
		$this->transaksimodel->insertPengeluaran($pengeluaran);

		redirect('Transaksi/Pengeluaran');
	}

	public function GetBukuPengeluaran(){
		$this->load->model('TransaksiModel', 'transaksimodel');
		$columns = array(
			0 => "NO_BUKU",
			1 => "TANGGAL_KELUAR",
			2 => "PELANGGAN",
			3 => "DESKRIPSI"
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $this->input->post('order')[0]['column'];
		if ($order < 4) {
			$order = $columns[$order];
		}				
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->transaksimodel->countBukuPengeluaran();

		$totalFiltered = $totalData;
		if (empty($this->input->post('search')['value'])) {
				$items = $this->transaksimodel->getBukuPengeluaranData($limit,$start,$order,$dir);
		}	
		else{
			$search = $this->input->post('search')['value'];			
			$items = $this->transaksimodel->bukuPengeluaranSearch($search,$limit,$start,$order,$dir);
			$totalFiltered = $this->transaksimodel->bukuPengeluaranSearchCount($search);
		}

		$data = array();		
		if (!empty($items)) {
			foreach ($items as $item) {
				$temp["NO_BUKU"] = $item->NO_BUKU;
				$temp["TANGGAL_KELUAR"] = $item->TANGGAL_KELUAR;
				$temp["PELANGGAN"] = $item->PELANGGAN;
				$temp["DESKRIPSI"] = $item->DESKRIPSI;	
				$temp["ACTION"] = 
				"<button type='button' class='btn btn-primary btn-view' data-nobuku='".$item->NO_BUKU."'><span class='oi oi-eye' title='icon menu' aria-hidden='true'></span></button>
				<a href='".site_url()."/Transaksi/DeletePengeluaran?nobuku=".$item->NO_BUKU."' class='btn btn-danger btn-delete' data-nobuku='".$item->NO_BUKU."'><span class='oi oi-trash' title='icon menu' aria-hidden='true'></span></a>";
				array_push($data, $temp);
			}
		}

		$jsonData = array(
			   "draw"            => intval($this->input->post('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data   
		);
		echo json_encode($jsonData);
	}

	public function GetBukuPembelian(){
		$this->load->model('TransaksiModel', 'transaksimodel');
		$columns = array(
			0 => "NO_BUKU",
			1 => "TANGGAL_BELI",
			2 => "TOKO_BELI",
			3 => "DESKRIPSI"
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $this->input->post('order')[0]['column'];
		if ($order < 4) {
			$order = $columns[$order];
		}				
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->transaksimodel->countBukuPembelian();

		$totalFiltered = $totalData;
		if (empty($this->input->post('search')['value'])) {
				$items = $this->transaksimodel->getBukuPembelianData($limit,$start,$order,$dir);
		}	
		else{
			$search = $this->input->post('search')['value'];			
			$items = $this->transaksimodel->bukuPembelianSearch($search,$limit,$start,$order,$dir);
			$totalFiltered = $this->transaksimodel->bukuPembelianSearchCount($search);
		}

		$data = array();		
		if (!empty($items)) {
			foreach ($items as $item) {
				$temp["NO_BUKU"] = $item->NO_BUKU;
				$temp["TANGGAL_BELI"] = $item->TANGGAL_BELI;
				$temp["TOKO_BELI"] = $item->TOKO_BELI;
				$temp["DESKRIPSI"] = $item->DESKRIPSI;	
				$temp["ACTION"] = 
				"<button type='button' class='btn btn-primary btn-view' data-nobuku='".$item->NO_BUKU."'><span class='oi oi-eye' title='icon menu' aria-hidden='true'></span></button>
				<a href='".site_url()."/Transaksi/DeletePengeluaran?nobuku=".$item->NO_BUKU."' class='btn btn-danger btn-delete' data-nobuku='".$item->NO_BUKU."'><span class='oi oi-trash' title='icon menu' aria-hidden='true'></span></a>";
				array_push($data, $temp);
			}
		}

		$jsonData = array(
			   "draw"            => intval($this->input->post('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data   
		);
		echo json_encode($jsonData);
	}

	public function GetDetailPengeluaran(){
		$noBuku = $this->input->get('no-buku');
		$this->load->model("TransaksiModel","transaksimodel");
		$items = $this->transaksimodel->GetDetailPengeluaran($noBuku);					
		$response = array();
		if (!empty($items)) {
			$response["pelanggan"] = $items[0]->PELANGGAN;
			$response["deskripsi"] = $items[0]->DESKRIPSI;
			$response["items"] = array();
			foreach ($items as $item) {
				$temp["KODE_BARANG"] = $item->KODE_BARANG;
				$temp["NAMA_BARANG"] = $item->NAMA_BARANG;
				$temp["JUMLAH"] = $item->JUMLAH;
				array_push($response["items"], $temp);
			}
		}
		else{
			$response["pelanggan"] = "tidak ditemukan";
			$response["deskripsi"] = "tidak ditemukan";
			$response["items"] = array();
		}

		echo json_encode($response);
	}

	public function DeletePengeluaran(){
		$noBuku = $this->input->get("nobuku");
		$this->load->model("TransaksiModel","transaksimodel");
		$status1 = $this->transaksimodel->DeleteBukuPengeluaran($noBuku);
		$status2 = $this->transaksimodel->DeletePengeluaran($noBuku);
		redirect("Transaksi/Pengeluaran");
	}	

	private function updatePembelianInventory($items){
		$query = "REPLACE INTO `inventory` (`KODE_BARANG`,`JENIS_BARANG`,`NAMA_BARANG`,`HARGA_POKOK`,`JUMLAH`) VALUES ";
		$this->load->model('InventoryModel', 'inventorymodel');		
		
		for ($i=0; $i < count($items) ; $i++) { 			
			$query = $query."('".$items[$i]->KODE_BARANG."', '".$items[$i]->JENIS_BARANG."', '".$items[$i]->NAMA_BARANG."', '".$items[$i]->HARGA_POKOK."', '".$items[$i]->JUMLAH."') ";
			if (isset($items[$i+1])) {
				$query .= ", ";
			}
		}		

		echo $query;
		echo "<br>";
		$updateResult = $this->inventorymodel->updateInventory($query);
		return $updateResult;		
	}
	public function SimpanNotaPembelian(){
		$generatedIdNota = uniqid();		
		$this->load->model("TransaksiModel", "transaksimodel");
		while ($this->transaksimodel->checkGeneratedId("buku_pembelian", $generatedIdNota)) {
			$generatedIdNota = uniqid();
		}

		$toko = $this->input->post("nama-toko");
		$kodeBarang = $this->input->post("kode-barang");
		$namaBarang = $this->input->post("nama-barang");
		$jenis = $this->input->post("jenis-barang");
		$jumlah = $this->input->post("jumlah-barang");
		$harga = $this->input->post("harga-barang");
		$deskripsi = $this->input->post("deskripsi");
		
		$items = $this->transaksimodel->AmbilInventory($kodeBarang);			
		$nota = array(
			"NO_BUKU" => $generatedIdNota,
			"TANGGAL_BELI" => date("Y-m-d"),
			"TOKO_BELI" => $toko,
			"DESKRIPSI" => $deskripsi
		);

		$pembelian = array();
		if (!empty($items)) {
			for ($i=0; $i < count($kodeBarang); $i++) { 
				$kodeBarang[$i] = strtoupper($kodeBarang[$i]);
				$found = false;
				foreach ($items as $item) {
					if ($kodeBarang[$i] === $item->KODE_BARANG) {
						$item->HARGA_POKOK = round((($item->JUMLAH * $item->HARGA_POKOK) + ($harga[$i])) / ($item->JUMLAH + $jumlah[$i]));
						$item->JUMLAH += $jumlah[$i];
						$found = true;
						break;
					}
				}
				if (!$found) {
					array_push($items, (object) array(
						"KODE_BARANG" => $kodeBarang[$i],
						"JENIS_BARANG" => $jenis[$i],
						"NAMA_BARANG" => $namaBarang[$i],
						"HARGA_POKOK" => $harga[$i],
						"JUMLAH" => $jumlah[$i]
					));
				}

				array_push($pembelian, array(
					"NO_PEMBELIAN" => $generatedIdNota,
					"KODE_BARANG" =>$kodeBarang[$i],
					"JUMLAH" => $jumlah[$i],
					"HARGA_BELI" => $jumlah[$i]
				));				
			}
		}								
		$this->updatePembelianInventory($items);						
		$this->transaksimodel->insertBukuPembelian($nota);
		$this->transaksimodel->insertPembelian($pembelian);
		redirect("Transaksi/Pembelian");
	}
}