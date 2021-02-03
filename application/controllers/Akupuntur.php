<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akupuntur extends CI_Controller
{

    public function index()
    {

        $this->form_validation->set_rules('nama', 'Nama lengkap', 'required');
        $this->form_validation->set_rules('penyakit', 'Jenis Penyakit', 'required');
        $this->form_validation->set_rules('nomor', 'Nomor Whatsapp', 'required|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat Lengkap', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Pesanan', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('user/akupuntur');
        } else {

            $hari = date('d');
            $hariIni = $hari - 1;
            $tanggal = date('Y-m-') . $hariIni;
            $pembelian = "1";

            $data = [
                'tanggal' => $tanggal,
                'pembelian' => $pembelian
            ];
            $this->db->insert('jumlah_keseluruhan', $data);

            $this->load->model('Model_akupuntur');
            $this->Model_akupuntur->pesanAkupuntur();
            redirect('Akupuntur/berhasil_akupuntur');
        }
    }

    public function berhasil_akupuntur()
    {
        $this->load->view('user/berhasil_akupuntur');
    }
}
