<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function programs() {
        // Ambil semua data program dari database secara langsung
        $data = $this->db->get('programs')->result_array();

        // Kembalikan data dalam format JSON
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode([
                 'status' => 'success',
                 'total' => count($data),
                 'data' => $data
             ]));
    }

    public function tambah_pengajuan() {
        // (isi fungsi tambah_pengajuan yang sebelumnya tetap di sini)
    }
}