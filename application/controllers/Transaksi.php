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
		$kodeBarang['kode'] = array();
		$kodeBarang['nama'] = array();
		if (!empty($result)) {
			foreach ($result as $kode) {
				array_push($kodeBarang['kode'], $kode->KODE_BARANG);
				$kodeBarang['nama'][$kode->KODE_BARANG] = $kode->NAMA_BARANG;
				// array_push($kodeBarang['nama'], array($kode->KODE_BARANG => $kode->NAMA_BARANG));
			}
		}				
		else
			array_push($kodeBarang['kode'], 'kode barang not found');		
		echo json_encode($kodeBarang);
	}

}