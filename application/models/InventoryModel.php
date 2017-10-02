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



}
