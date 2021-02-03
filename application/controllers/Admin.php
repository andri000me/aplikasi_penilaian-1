<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('email')) {
      redirect('Auth');
    }
  }

  public function index()
  {

    $data['jumlahAkupuntur'] =  $this->Model_akupuntur->jumlahAkupuntur();
    $data['jumlahMadu'] = $this->Model_madu->jumlahMadu();
    $data['jumlahHariIni'] = $this->Model_user->jumlahHariIni();
    $data['totalJumlah'] = $this->Model_user->totalJumlah();

    $data['getUser'] = $this->Model_user->getUser();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('templates/footer');
  }

  // Akupuntur

  public function dataAkupuntur()
  {

    $this->load->model('Model_akupuntur');
    $data['pembelian'] =  $this->Model_akupuntur->pembelianAkupuntur();

    $data['getUser'] = $this->Model_user->getUser();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/data_akupuntur', $data);
    $this->load->view('templates/footer');
  }

  public function editDataAkupuntur($id_akupuntur)
  {
    $this->load->model('Model_akupuntur');
    $data['edit_akupuntur'] =  $this->Model_akupuntur->getIdAkupuntur($id_akupuntur);

    $data['getUser'] = $this->Model_user->getUser();

    $this->form_validation->set_rules('status', 'Status', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header');
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/edit_akupuntur', $data);
      $this->load->view('templates/footer');
    } else {
      $this->load->model('Model_akupuntur');
      $this->Model_akupuntur->editPesananAkupuntur();
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Pesanan Berhasil diedit</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('Admin/dataAkupuntur');
    }
  }

  public function hapusDataAkupuntur($id_akupuntur)
  {
    $this->load->model('Model_akupuntur');
    $this->Model_akupuntur->hapusPesananAkupuntur($id_akupuntur);
    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Pesanan Berhasil dihapus</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
    redirect('Admin/dataAkupuntur');
  }

  // Akhir Akupuntur

  // Madu
  public function dataMadu()
  {

    $this->load->model('Model_madu');
    $data['pembelian'] =  $this->Model_madu->pembelianMadu();
    $data['getUser'] = $this->Model_user->getUser();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/data_madu', $data);
    $this->load->view('templates/footer');
  }

  public function editDataMadu($id_madu)
  {
    $this->load->model('Model_madu');
    $data['edit_madu'] =  $this->Model_madu->getIdMadu($id_madu);
    $data['getUser'] = $this->Model_user->getUser();

    $this->form_validation->set_rules('status', 'Status', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header');
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/edit_madu', $data);
      $this->load->view('templates/footer');
    } else {
      $this->load->model('Model_madu');
      $this->Model_madu->editPesananMadu();
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Pesanan Berhasil diedit</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('Admin/dataMadu');
    }
  }

  public function hapusDataMadu($id_madu)
  {
    $this->load->model('Model_madu');
    $this->Model_madu->hapusPesananMadu($id_madu);
    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Pesanan Berhasil dihapus</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
    redirect('Admin/dataMadu');
  }

  // Akhir Madu



  public function user()
  {
    $this->load->model('Model_user');
    $data['data_user'] =  $this->Model_user->dataUser();
    $data['getUser'] = $this->Model_user->getUser();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/data_user', $data);
    $this->load->view('templates/footer');
  }

  public function tambahDataUser()
  {

    $data['getUser'] = $this->Model_user->getUser();

    $this->form_validation->set_rules('name', 'Nama', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[user.email]');
    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]');
    $this->form_validation->set_rules('password2', 'Password', 'required|matches[password1]');

    if ($this->form_validation->run() == false) {

      $this->load->view('templates/header');
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/tambah_data_user');
      $this->load->view('templates/footer');
    } else {
      $this->load->model('Model_user');
      $this->Model_user->tambahDataUser();
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>User Berhasil ditambah</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
      redirect('Admin/user');
    }
  }

  public function hapusDataUser($id)
  {
    $this->load->model('Model_user');
    $this->Model_user->hapusDataUser($id);
    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>User Berhasil dihapus</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
    redirect('Admin/user');
  }
}
