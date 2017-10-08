<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
	public function index()
	{
		$this->load->view('Inventory-view');
	}

	private function toRP($angka){
		$angka = str_split($angka);
		$fixedRp = ",00";
		$index = 0;
		for ($i=count($angka)-1; $i >= 0 ; $i--) { 
			if ($index % 3 == 0 && $index != 0) {
				$fixedRp = $angka[$i].".".$fixedRp;
			}
			else
				$fixedRp = $angka[$i].$fixedRp;
			$index++;
		}
		return "Rp. ".$fixedRp;
	}	

	public function getInventory(){
		$this->load->model('InventoryModel', 'inventorymodel');
		$columns = array(
			0 => "KODE_BARANG",
			1 => "JENIS_BARANG",
			2 => "NAMA_BARANG",
			3 => "HARGA_POKOK"
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $this->input->post('order')[0]['column'];
		if ($order < 4) {
			$order = $columns[$order];
		}				
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->inventorymodel->countInventory();

		$totalFiltered = $totalData;
		if (empty($this->input->post('search')['value'])) {
				$items = $this->inventorymodel->getInventoryData($limit,$start,$order,$dir);
		}	
		else{
			$search = $this->input->post('search')['value'];			
			$items = $this->inventorymodel->inventorySearch($search,$limit,$start,$order,$dir);
			$totalFiltered = $this->inventorymodel->inventorySearchCount($search);
		}

		$data = array();		
		if (!empty($items)) {
			foreach ($items as $item) {
				$temp["KODE_BARANG"] = $item->KODE_BARANG;
				$temp["JENIS_BARANG"] = $item->JENIS_BARANG;
				$temp["NAMA_BARANG"] = $item->NAMA_BARANG;
				$temp["HARGA_POKOK"] = $this->toRP($item->HARGA_POKOK);
				$temp["JUMLAH"] = $item->JUMLAH." lembar";
				$temp["HARGA_TOTAL"] = $this->toRP($item->HARGA_POKOK * $item->JUMLAH);
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
	public function GetInventoryJSON(){
		$this->load->model("InventoryModel","inventorymodel");
		$items = $this->inventorymodel->getAllInventory();
		$response = array();		
		foreach ($items as $item) {
			array_push($response, array(
				"KODE_BARANG" => $item->KODE_BARANG,
				"JUMLAH" => $item->JUMLAH
			));
		}
		echo json_encode($response);
	}

}
