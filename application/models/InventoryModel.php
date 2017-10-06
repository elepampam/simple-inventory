<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InventoryModel extends CI_Model {

	public function getInventoryData($limit, $start, $order, $dir){
		$this->db->select("*");
		$this->db->from("inventory");
		$this->db->limit($limit, $start);
		$this->db->order_by($order,$dir);
		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else
			return null;
	}

	public function countInventory(){
		$this->db->select("*");
		$this->db->from("inventory");		
		$result = $this->db->get();
		return $result->num_rows();		
	}

	public function inventorySearch($search, $limit, $start, $order, $dir){
		$this->db->select("*");
		$this->db->from("inventory");
		$this->db->like("KODE_BARANG", $search);
		$this->db->or_like("JENIS_BARANG",$search);
		$this->db->or_like("NAMA_BARANG", $search);	
		$this->db->limit($limit, $start);
		$this->db->order_by($order,$dir);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else
			return null;
	}

	public function inventorySearchCount($search){
		$this->db->select("*");
		$this->db->from("inventory");
		$this->db->like("KODE_BARANG", $search);
		$this->db->or_like("JENIS_BARANG",$search);
		$this->db->or_like("NAMA_BARANG", $search);	
		$result = $this->db->get();
		return $result->num_rows();
	}

	public function GetKodeBarang($key){
		$this->db->select("KODE_BARANG");
		$this->db->from('inventory');
		$this->db->like('KODE_BARANG',$key);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else
			return null;
	}

	public function GetNamaBarang($key){
		$this->db->select("NAMA_BARANG");
		$this->db->from('inventory');
		$this->db->like('KODE_BARANG',$key);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->row();
		}
		else
			return null;
	}

	public function checkItem($kodeBarang){
		$this->db->select("*");
		$this->db->from("inventory");
		$this->db->where("KODE_BARANG", $kodeBarang);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return true;
		}
		else
			return false;
	}

	public function getJumlahItem($kodeBarang){
		$this->db->select("JUMLAH");
		$this->db->from("inventory");
		$this->db->where("KODE_BARANG", $kodeBarang);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->row();
		}
		else
			return null;	
	}

	public function getAllInventory(){
		$this->db->select("*");
		$this->db->from("inventory");		
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else
			return null;		
	}

	public function getAllInventoryArray($items){
		$this->db->select("*");
		$this->db->from('inventory');
		$this->db->where_in("KODE_BARANG", $items);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else
			return null;
	}

	public function updateInventory($query){		
		$result = $this->db->query($query);
		return $result;
	}

	public function insertBukuPengeluaran($nota){
		$this->db->insert('buku_pengeluaran', $nota);
	}

	public function insertPengeluaran($item){
		$this->db->insert_batch('pengeluaran', $item);
	}

}
