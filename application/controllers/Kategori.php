<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        tidak_login();
        // cek_admin();
        $this->load->model('kategori_m');
    }

	public function index()
	{
		$data['row'] = $this->kategori_m->get();
		$this->template->load('template', 'produk/kategori/kategori_data', $data);
	}

	public function hapus($id)
	{
		$this->kategori_m->hapus($id);
        if($this->db->affected_rows() > 0){
            echo "<script>alert('Data berhasil dihapus')</script>";
        }
        echo "<script>window.location='" .site_url('kategori'). "'</script>";
	}

	public function tambah()
	{
		$kategori = new stdClass();
		$kategori->id_kategori = null;
		$kategori->nama = null;

		$data = array(
			'page' => 'tambah',
			'row' => $kategori
		);
		$this->template->load('template', 'produk/kategori/kategori_form', $data);
	}

	public function edit($id)
	{
		$query = $this->kategori_m->get($id);
		if($query->num_rows() > 0) {
			$kategori = $query->row();
			$data = array(
				'page' => 'edit',
				'row' => $kategori
			);
			$this->template->load('template', 'produk/kategori/kategori_form', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan');";
			echo "window.location='" .site_url('kategori'). "';</script>";
		}
	}

	public function proses() 
	{
		$post = $this->input->post(null, TRUE);
		if(isset($_POST['tambah'])){
			$this->kategori_m->tambah($post);
		} elseif (isset($_POST['edit'])){
			$this->kategori_m->edit($post);
		}

		if($this->db->affected_rows() > 0){
			echo "<script>alert('Data berhasil disimpan')</script>";
        }
		echo "<script>window.location='" .site_url('kategori'). "'</script>";
	}
}