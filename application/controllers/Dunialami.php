<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dunialami extends CI_Controller
{

    public function index()
    {

        $this->load->view('user/dunia');
    }
}
