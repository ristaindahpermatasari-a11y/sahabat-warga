<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('auth/login');
    }

    public function login_process()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Cari user berdasarkan email di database
        $user = $this->db->get_where('users', ['email' => $email])->row_array();

        if ($user) {
            // Cocokkan password dengan format MD5 di database
            if (md5($password) == $user['password_hash']) {
                
                // Jika password benar, set Session Data
                $session_data = [
                    'user_id'   => $user['user_id'],
                    'name'      => $user['name'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($session_data);

                // Redirect otomatis berdasarkan role (petugas atau mitra)
                if (strtolower($user['role']) == 'petugas') {
                    redirect('index.php/petugas/dashboard');
                } else {
                    redirect('index.php/mitra/dashboard');
                }

            } else {
                // Jika password salah: Kirim flashdata error dan kembalikan ke halaman login
                $this->session->set_flashdata('error', 'Password yang Anda masukkan salah!');
                redirect('index.php/auth');
            }

        } else {
            // Jika email tidak ditemukan: Kirim flashdata error dan kembalikan ke halaman login
            $this->session->set_flashdata('error', 'Email tidak ditemukan di database!');
            redirect('index.php/auth');
        }
    }

    public function forgot_password() {
        // Menampilkan view form input email untuk reset password
        $this->load->view('auth/forgot_password_view');
    }

    // Proses update kata sandi baru dengan format MD5
    public function update_password_process() {
        $email = $this->input->post('email');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        // 1. Cek apakah password baru dan konfirmasi sama
        if ($new_password !== $confirm_password) {
            $this->session->set_flashdata('error', 'Konfirmasi kata sandi baru tidak cocok!');
            redirect('index.php/auth/forgot_password');
        }

        // 2. Cek apakah email terdaftar di database
        $user = $this->db->get_where('users', ['email' => $email])->row_array();

        if (!$user) {
            $this->session->set_flashdata('error', 'Email atau akun tersebut tidak terdaftar di sistem!');
            redirect('index.php/auth/forgot_password');
        }

        // 3. Ubah password baru ke format MD5 agar cocok dengan sistem login
        $data_update = [
            'password_hash' => md5($new_password) 
        ];

        $this->db->where('email', $email);
        $update = $this->db->update('users', $data_update);

        if ($update) {
            $this->session->set_flashdata('success', 'Kata sandi berhasil diperbarui! Silakan masuk dengan sandi baru Anda.');
            redirect('index.php/auth'); 
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui kata sandi. Silakan coba lagi.');
            redirect('index.php/auth/forgot_password');
        }
    }

    public function google_login()
    {
        $idToken = $this->input->post('id_token');
        if (!$idToken) {
            return $this->_json(false, 'Token tidak ditemukan.');
        }

        $apiKey = 'AIzaSyA9PqjWwq8CNaA61iFRw1cXuxFgz5MzBUI';
        $url = 'https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=' . $apiKey;

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS     => json_encode(['idToken' => $idToken]),
            CURLOPT_SSL_VERIFYPEER => false, // hanya untuk localhost/XAMPP
        ]);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (empty($response['users'][0]['email'])) {
            return $this->_json(false, 'Token Google tidak valid.');
        }

        $email = $response['users'][0]['email'];

        $user = $this->db->get_where('users', ['email' => $email])->row();

        if (!$user) {
            return $this->_json(false, 'Email ' . $email . ' belum terdaftar di sistem.');
        }
        if ($user->status !== 'active') {
            return $this->_json(false, 'Akun Anda tidak aktif.');
        }

        $this->session->set_userdata([
            'user_id'   => $user->user_id,
            'name'      => $user->name,
            'email'     => $user->email,
            'role'      => $user->role,
            'logged_in' => TRUE,
        ]);

        $redirect = ($user->role === 'petugas')
            ? base_url('index.php/petugas/dashboard')
            : base_url('index.php/mitra/dashboard');

        return $this->_json(true, 'OK', $redirect);
    }

    private function _json($success, $message, $redirect = null)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success'  => $success,
                'message'  => $message,
                'redirect' => $redirect,
            ]));
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('index.php/auth');
    }
}

