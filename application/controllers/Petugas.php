<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/auth');
        }
    }

    public function dashboard()
    {
        $data['title'] = 'Dashboard';
        $data['active_menu'] = 'dashboard';

        $data['user_name'] = $this->session->userdata('name') ? $this->session->userdata('name') : 'Petugas';
        $data['user_role'] = ucfirst($this->session->userdata('role'));

        $words = explode(' ', $data['user_name']);
        $initials = '';
        foreach ($words as $w) {
            $initials .= strtoupper($w[0]);
        }
        $data['user_initials'] = substr($initials, 0, 2);

        $data['total_recipients'] = $this->db->count_all('recipients');
        $data['active_programs']   = $this->db->get_where('programs', ['status' => 'active'])->num_rows();
        $data['total_proposals']   = $this->db->count_all('proposals');
        $data['approved_proposals'] = $this->db->get_where('proposal_items', ['selection_status' => 'accepted'])->num_rows();

        // Hitung total keseluruhan keluarga/penerima yang sudah tersalurkan di database
        // Hitung total keseluruhan keluarga/penerima yang sudah tersalurkan di database
        $data['total_tersalurkan'] = $this->db->get_where('proposal_items', ['selection_status' => 'accepted'])->num_rows();

        // Hitung data 6 bulan terakhir secara dinamis berdasarkan database
        $chart_labels = [];
        $chart_data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $time = strtotime("-$i months");
            $month_num = date('m', $time);
            $year_num = date('Y', $time);
            $month_name = date('M', $time);
            
            $indo_months = ['Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr', 'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Agu', 'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'];
            $chart_labels[] = isset($indo_months[$month_name]) ? $indo_months[$month_name] : $month_name;

            // Query akurat untuk mencocokkan tahun dan bulan pada kolom created_at
            $this->db->where('YEAR(created_at)', $year_num);
            $this->db->where('MONTH(created_at)', $month_num);
            $count = $this->db->count_all_results('proposals');
            
            $chart_data[] = $count;
        }

        $data['chart_labels'] = json_encode($chart_labels);
        $data['chart_monthly_data'] = json_encode($chart_data);

        // Ambil data aktivitas pengajuan terbaru
        $this->db->select('proposals.*, programs.title as program_name');
        $this->db->from('proposals');
        $this->db->join('programs', 'programs.program_id = proposals.program_id', 'left');
        $this->db->order_by('proposals.created_at', 'DESC');
        $this->db->limit(5);
        $data['recent_proposals'] = $this->db->get()->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('petugas/dashboard', $data);
        $this->load->view('layout/footer');
    }

    public function calon_penerima()
    {
        $data['title'] = 'Data Calon Penerima';
        $data['active_menu'] = 'calon_penerima';

        $data['user_name'] = $this->session->userdata('name');
        $words = explode(' ', $data['user_name']);
        $initials = '';
        foreach ($words as $w) { $initials .= strtoupper($w[0]); }
        $data['user_initials'] = substr($initials, 0, 2);

        $data['recipients'] = $this->db->get('recipients')->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('petugas/calon_penerima', $data);
        $this->load->view('layout/footer');
    }

    public function tambah_penerima()
    {
        $data_insert = [
            // 'nik' sudah dihapus dari sini
            'full_name'      => $this->input->post('full_name'),
            'address'        => $this->input->post('address'),
            'rt_rw'          => $this->input->post('rt_rw'),
            'phone'          => $this->input->post('phone'),
            'economic_status'=> $this->input->post('economic_status'),
            'created_by'     => $this->session->userdata('user_id'),
            'status'         => 'active'
        ];

        $this->db->insert('recipients', $data_insert);
        $this->session->set_flashdata('success', 'Data calon penerima berhasil ditambahkan!');
        redirect('index.php/petugas/calon_penerima');
    }

    public function edit_penerima($id)
    {
        $data_update = [
            // 'nik' sudah dihapus dari sini
            'full_name'      => $this->input->post('full_name'),
            'address'        => $this->input->post('address'),
            'rt_rw'          => $this->input->post('rt_rw'),
            'phone'          => $this->input->post('phone'),
            'economic_status'=> $this->input->post('economic_status')
        ];

        $this->db->where('id', $id);
        $this->db->update('recipients', $data_update);

        $this->session->set_flashdata('success', 'Data calon penerima berhasil diperbarui!');
        redirect('index.php/petugas/calon_penerima');
    }

    public function hapus_penerima($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('recipients');

        $this->session->set_flashdata('success', 'Data calon penerima berhasil dihapus!');
        redirect('index.php/petugas/calon_penerima');
    }

    public function program_bantuan()
    {
        $data['title'] = 'Program Bantuan';
        $data['active_menu'] = 'program_bantuan';

        // Data Session User
        $data['user_name'] = $this->session->userdata('name');
        $words = explode(' ', $data['user_name']);
        $initials = '';
        foreach ($words as $w) { $initials .= strtoupper($w[0]); }
        $data['user_initials'] = substr($initials, 0, 2);

        // Filter Status dari URL Query (default: 'all')
        $status_filter = $this->input->get('status');
        $data['selected_status'] = $status_filter ? $status_filter : 'all'; // PASTIKAN BARIS INI ADA

        // Sembunyikan program yang berstatus 'draft' dari petugas
        $this->db->where('status !=', 'draft');

        // Jika ada filter tambahan dari user
        if ($status_filter && $status_filter != 'all') {
            $this->db->where('status', $status_filter);
        }
        
        $data['programs'] = $this->db->get('programs')->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('petugas/program_bantuan', $data);
        $this->load->view('layout/footer');
    }

    public function pengajuan_bantuan()
    {
        $data['title'] = 'Pengajuan Bantuan';
        $data['active_menu'] = 'pengajuan_bantuan';

        // Data Session User
        $data['user_name'] = $this->session->userdata('name');
        $words = explode(' ', $data['user_name']);
        $initials = '';
        foreach ($words as $w) { $initials .= strtoupper($w[0]); }
        $data['user_initials'] = substr($initials, 0, 2);

        // Tangkap parameter GET program_id dari URL (jika ada yang diklik dari Halaman Program Bantuan)
        $data['selected_program_id'] = $this->input->get('program_id');

        // Ambil Program yang statusnya 'active'
        $data['programs'] = $this->db->get_where('programs', ['status' => 'active'])->result_array();

        // Ambil Warga yang statusnya 'active'
        $data['recipients'] = $this->db->get_where('recipients', ['status' => 'active'])->result_array();

        // Ambil Riwayat Pengajuan dari tabel proposals
        $this->db->select('proposals.*, programs.title as program_name');
        $this->db->from('proposals');
        $this->db->join('programs', 'programs.program_id = proposals.program_id', 'left');
        $this->db->order_by('proposals.created_at', 'DESC');
        $data['proposals'] = $this->db->get()->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('petugas/pengajuan_bantuan', $data);
        $this->load->view('layout/footer');
    }

    public function submit_pengajuan()
    {
        $program_id = $this->input->post('program_id');
        $recipient_ids = $this->input->post('recipient_ids');

        if (empty($program_id) || empty($recipient_ids)) {
            $this->session->set_flashdata('error', 'Pilih program dan minimal satu warga calon penerima!');
            redirect('index.php/petugas/pengajuan_bantuan');
        }

        // Generate Kode Referensi Otomatis
        $ref_code = 'SW-' . date('Y') . '-' . sprintf("%04d", rand(1, 9999));

        // 1. Insert ke tabel proposals (Menggunakan petugas_id)
        $data_proposal = [
            'reference_code' => $ref_code,
            'program_id'     => $program_id,
            'petugas_id'     => $this->session->userdata('user_id'), // Sesuaikan nama kolom ke petugas_id
            'total_proposed' => count($recipient_ids),
            'status'         => 'submitted',
            'created_at'     => date('Y-m-d H:i:s')
        ];
        $this->db->insert('proposals', $data_proposal);
        $proposal_id = $this->db->insert_id();

        foreach ($recipient_ids as $r_id) {
            $this->db->insert('proposal_items', [
                'proposal_id'  => $proposal_id,
                'recipient_id' => $r_id
            ]);
        }

        // =========================================================
        // TAMBAHKAN KODE NOTIFIKASI UNTUK MITRA DI SINI
        // =========================================================
        $notif_data = [
            'user_type' => 'mitra',
            'title'     => 'Usulan Proposal Baru',
            'message'   => 'Petugas mengirim usulan baru dengan kode ' . $ref_code,
            'link'      => 'index.php/mitra/usulan_masuk',
            'is_read'   => 0
        ];
        $this->db->insert('notifications', $notif_data);
        // =========================================================

        $this->session->set_flashdata('success', 'Pengajuan bantuan berhasil dikirim ke Mitra!');
        redirect('index.php/petugas/pengajuan_bantuan');
    }

    public function hasil_seleksi()
    {
        $data['title'] = 'Hasil Seleksi';
        $data['active_menu'] = 'hasil_seleksi';

        $data['user_name'] = $this->session->userdata('name');
        $words = explode(' ', $data['user_name']);
        $initials = '';
        foreach ($words as $w) { $initials .= strtoupper($w[0]); }
        $data['user_initials'] = substr($initials, 0, 2);

        // Ambil daftar program secara unik (dikelompokkan per program) yang sudah diproses Mitra
        $this->db->select('proposals.*, programs.title as program_name, programs.program_id');
        $this->db->from('proposals');
        $this->db->join('programs', 'programs.program_id = proposals.program_id', 'left');
        $this->db->where('proposals.status !=', 'submitted');
        $this->db->group_by('programs.program_id'); // Dikelompokkan agar nama program tidak duplikat
        $data['proposals'] = $this->db->get()->result_array();

        // Tangkap program_id dari URL (menggunakan key program_id)
        $selected_prog_id = $this->input->get('program_id');
        if (!$selected_prog_id && !empty($data['proposals'])) {
            $selected_prog_id = $data['proposals'][0]['program_id'];
        }

        $data['selected_program_id'] = $selected_prog_id;

        if ($selected_prog_id) {
            // Ambil info nama program untuk ditampilkan di header card
            $this->db->select('programs.title as program_name, programs.program_id');
            $this->db->from('programs');
            $this->db->where('programs.program_id', $selected_prog_id);
            $data['current_proposal'] = $this->db->get()->row_array();

            // Ambil semua item penerima dari proposal-proposal yang memiliki program_id yang sama
            $this->db->select('proposal_items.*, recipients.full_name, recipients.rt_rw, proposals.status as proposal_status');
            $this->db->from('proposal_items');
            $this->db->join('proposals', 'proposals.id = proposal_items.proposal_id', 'left');
            $this->db->join('recipients', 'recipients.id = proposal_items.recipient_id', 'left');
            $this->db->where('proposals.program_id', $selected_prog_id);
            $this->db->where('proposals.status !=', 'submitted');
            $data['items'] = $this->db->get()->result_array();
        }

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('petugas/hasil_seleksi', $data);
        $this->load->view('layout/footer');
    }

    public function progres_penyaluran()
    {
        $data['title'] = 'Progres Penyaluran';
        $data['active_menu'] = 'progres_penyaluran';

        $data['user_name'] = $this->session->userdata('name');
        $words = explode(' ', $data['user_name']);
        $initials = '';
        foreach ($words as $w) { $initials .= strtoupper($w[0]); }
        $data['user_initials'] = substr($initials, 0, 2);

        // Ambil daftar proposal
        $this->db->select('proposals.*, programs.title as program_name');
        $this->db->from('proposals');
        $this->db->join('programs', 'programs.program_id = proposals.program_id', 'left');
        $data['proposals'] = $this->db->get()->result_array();

        $selected_id = $this->input->get('proposal_id');
        if (!$selected_id && !empty($data['proposals'])) {
            $selected_id = $data['proposals'][0]['id'];
        }

        $data['selected_proposal_id'] = $selected_id;
        if ($selected_id) {
            $this->db->select('proposals.*, programs.title as program_name');
            $this->db->from('proposals');
            $this->db->join('programs', 'programs.program_id = proposals.program_id', 'left');
            $this->db->where('proposals.id', $selected_id);
            $data['current_proposal'] = $this->db->get()->row_array();

            // Hitung total penerima yang diterima
            $data['total_penerima'] = $this->db->get_where('proposal_items', ['proposal_id' => $selected_id, 'selection_status' => 'accepted'])->num_rows();

            // Ambil riwayat log dari tabel distributions
            $this->db->where('proposal_id', $selected_id);
            $this->db->order_by('updated_at', 'DESC');
            $data['logs'] = $this->db->get('distributions')->result_array();
        }

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('petugas/progres_penyaluran', $data);
        $this->load->view('layout/footer');
    }

    // Menu Pengaturan (Petugas)
    public function pengaturan()
    {
        $data['title'] = 'Pengaturan Akun';
        $data['active_menu'] = 'pengaturan';

        $data['user_name'] = $this->session->userdata('name') ? $this->session->userdata('name') : 'Petugas';
        $words = explode(' ', $data['user_name']);
        $initials = '';
        foreach ($words as $w) { $initials .= strtoupper($w[0]); }
        $data['user_initials'] = substr($initials, 0, 2);

        $user_id = $this->session->userdata('user_id');
        
        // Menggunakan kolom 'user_id' sesuai struktur tabel di database
        $data['user'] = $this->db->get_where('users', ['user_id' => $user_id])->row_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('petugas/pengaturan', $data);
        $this->load->view('layout/footer');
    }

    public function update_profil()
    {
        $user_id = $this->session->userdata('user_id');
        $data_update = [
            'name'  => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone')
        ];

        // Menggunakan kolom 'user_id' sesuai struktur tabel di database
        $this->db->where('user_id', $user_id);
        $this->db->update('users', $data_update);

        // Update session juga agar nama di sidebar ikut berubah secara real-time
        $this->session->set_userdata('name', $this->input->post('name'));

        $this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
        redirect('index.php/petugas/pengaturan');
    }

    public function baca_notif($id)
    {
        $notif = $this->db->get_where('notifications', ['id' => $id])->row_array();
        if ($notif) {
            // Ubah status di database jadi sudah dibaca (is_read = 1)
            $this->db->where('id', $id);
            $this->db->update('notifications', ['is_read' => 1]);
            
            // Lempar ke halaman tujuan
            redirect(base_url($notif['link']));
        } else {
            redirect('index.php/petugas/dashboard'); // (Sesuaikan role)
        }
    }
}