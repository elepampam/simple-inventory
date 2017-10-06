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
				array_push($pengeluaran, array(
					"NO_PENGELUARAN" => $generatedIdNota,
					"KODE_BARANG" => $kodeBarang[$i],
					"JUMLAH" => $jumlah[$i]
				));
			}
		}		

		$this->updatePengeluaranInventory($items);
		$this->load->model("inventorymodel", "inventorymodel");
		$this->inventorymodel->insertBukuPengeluaran($nota);
		$this->inventorymodel->insertPengeluaran($pengeluaran);

		redirect('Transaksi/Pengeluaran');
	}
}