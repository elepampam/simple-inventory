<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransaksiModel extends CI_Model {
	public function checkGeneratedId($tabel, $id){
		$this->db->select("*");
		$this->db->from($tabel);
		$this->db->where("NO_BUKU",$id);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return true;
		}
		return false;
	}

	public function getBukuPengeluaranData($limit, $start, $order, $dir){
		$this->db->select("*");
		$this->db->from("buku_pengeluaran");
		$this->db->limit($limit, $start);
		$this->db->order_by($order,$dir);
		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else
			return null;
	}

	public function countBukuPengeluaran(){
		$this->db->select("*");
		$this->db->from("buku_pengeluaran");		
		$result = $this->db->get();
		return $result->num_rows();		
	}

	public function bukuPengeluaranSearch($search, $limit, $start, $order, $dir){
		$this->db->select("*");
		$this->db->from("buku_pengeluaran");
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

	public function bukuPengeluaranSearchCount($search){
		$this->db->select("*");
		$this->db->from("buku_pengeluaran");
		$this->db->like("KODE_BARANG", $search);
		$this->db->or_like("JENIS_BARANG",$search);
		$this->db->or_like("NAMA_BARANG", $search);	
		$result = $this->db->get();
		return $result->num_rows();
	}

	public function GetDetailPengeluaran($noBuku){
		$this->db->select("buku_pengeluaran.NO_BUKU,buku_pengeluaran.TANGGAL_KELUAR,buku_pengeluaran.PELANGGAN,buku_pengeluaran.DESKRIPSI,pengeluaran.JUMLAH,inventory.KODE_BARANG,inventory.NAMA_BARANG,");
		$this->db->from("buku_pengeluaran");
		$this->db->join("pengeluaran","buku_pengeluaran.NO_BUKU = pengeluaran.NO_PENGELUARAN");
		$this->db->join("inventory", "pengeluaran.KODE_BARANG = inventory.KODE_BARANG");
		$this->db->where("buku_pengeluaran.NO_BUKU", $noBuku);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		return null;
	}
}