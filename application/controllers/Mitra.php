<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitra extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        
        if ($this->session->userdata('role') != 'mitra' && $this->session->userdata('role') != 'partner') {
            
        }
    }

    public function dashboard()
    {
        $data['title'] = 'Dashboard';
        $data['active_menu'] = 'dashboard';

        $data['user_name'] = $this->session->userdata('name') ? $this->session->userdata('name') : 'Yayasan Peduli';
        $data['user_initials'] = 'YP';

        $data['total_programs'] = $this->db->count_all('programs');
        $data['total_usulan'] = $this->db->count_all('proposals');
        $data['penerima_terpilih'] = $this->db->get_where('proposal_items', ['selection_status' => 'accepted'])->num_rows();
        $data['penyaluran_selesai'] = $this->db->get_where('proposals', ['status' => 'Selesai Disalurkan'])->num_rows();

        $data['status_selesai'] = $this->db->get_where('proposals', ['status' => 'Selesai Disalurkan'])->num_rows();
        $this->db->from('proposals');
        $this->db->where('status !=', 'Selesai Disalurkan');
        $this->db->where('status !=', 'rejected');
        $data['status_proses'] = $this->db->count_all_results();

        $this->db->select('proposals.*, programs.title as program_name');
        $this->db->from('proposals');
        $this->db->join('programs', 'programs.program_id = proposals.program_id', 'left');
        $this->db->order_by('proposals.created_at', 'DESC');
        $this->db->limit(5);
        $data['recent_proposals'] = $this->db->get()->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar_mitra', $data);
        $this->load->view('mitra/dashboard', $data);
        $this->load->view('layout/footer');
    }

    public function program_bantuan()
    {
        $data['title'] = 'Program Bantuan Saya';
        $data['active_menu'] = 'program_bantuan';

        $data['user_name'] = $this->session->userdata('name') ? $this->session->userdata('name') : 'Yayasan Peduli';
        $data['user_initials'] = 'YP';

        $status_filter = $this->input->get('status');
        $data['selected_status'] = $status_filter;

        if ($status_filter && $status_filter != 'all') {
            $this->db->where('status', $status_filter);
        }
        
        $data['programs'] = $this->db->get('programs')->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar_mitra', $data);
        $this->load->view('mitra/program_bantuan', $data);
        $this->load->view('layout/footer');
    }

    public function tambah_program()
    {
        $quota = $this->input->post('quota');

        // Validasi: Kuota wajib lebih dari 0
        if ($quota <= 0) {
            $this->session->set_flashdata('error', 'Kuota penerima harus minimal 1 dan tidak boleh 0 atau minus!');
            redirect('index.php/mitra/program_bantuan');
            return;
        }

        $data_insert = [
            'title'         => $this->input->post('title'),
            'category'      => $this->input->post('category'),
            'description'   => $this->input->post('description'),
            'criteria'      => $this->input->post('criteria'),
            'coverage_area' => $this->input->post('coverage_area'),
            'quota'         => $quota,
            'status'        => $this->input->post('status'),
            'created_at'    => date('Y-m-d H:i:s')
        ];

        $this->db->insert('programs', $data_insert);
        $this->session->set_flashdata('success', 'Program bantuan baru berhasil dibuat!');
        redirect('index.php/mitra/program_bantuan');
    }

    public function edit_program($id)
    {
        $quota = $this->input->post('quota');

        // Validasi: Kuota wajib lebih dari 0 saat diedit
        if ($quota <= 0) {
            $this->session->set_flashdata('error', 'Kuota penerima harus minimal 1 dan tidak boleh 0 atau minus!');
            redirect('index.php/mitra/program_bantuan');
            return;
        }

        $data_update = [
            'title'         => $this->input->post('title'),
            'category'      => $this->input->post('category'),
            'description'   => $this->input->post('description'),
            'criteria'      => $this->input->post('criteria'),
            'coverage_area' => $this->input->post('coverage_area'),
            'quota'         => $quota,
            'status'        => $this->input->post('status')
        ];

        $this->db->where('program_id', $id);
        $this->db->update('programs', $data_update);

        $this->session->set_flashdata('success', 'Program bantuan berhasil diperbarui!');
        redirect('index.php/mitra/program_bantuan');
    }

    public function usulan_masuk()
    {
        $data['title'] = 'Usulan Masuk';
        $data['active_menu'] = 'usulan_masuk';

        $data['user_name'] = $this->session->userdata('name') ? $this->session->userdata('name') : 'Yayasan Peduli';

        // Ambil data proposals yang dikirim petugas, gabungkan dengan tabel programs dan users
        $this->db->select('proposals.*, programs.title as program_name, users.name as petugas_name');
        $this->db->from('proposals');
        $this->db->join('programs', 'programs.program_id = proposals.program_id', 'left');
        $this->db->join('users', 'users.user_id = proposals.petugas_id', 'left');
        $this->db->order_by('proposals.created_at', 'DESC');
        $data['proposals'] = $this->db->get()->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar_mitra', $data);
        $this->load->view('mitra/usulan_masuk', $data);
        $this->load->view('layout/footer');
    }

    public function detail_usulan($proposal_id)
    {
        $data['title'] = 'Seleksi Penerima';
        $data['active_menu'] = 'usulan_masuk';

        // Ambil data proposal utama
        $this->db->select('proposals.*, programs.title as program_name, programs.criteria, programs.quota, users.name as petugas_name');
        $this->db->from('proposals');
        $this->db->join('programs', 'programs.program_id = proposals.program_id', 'left');
        $this->db->join('users', 'users.user_id = proposals.petugas_id', 'left');
        $this->db->where('proposals.id', $proposal_id);
        $data['proposal'] = $this->db->get()->row_array();

        // Ambil daftar warga beserta economic_status dari tabel recipients
        $this->db->select('proposal_items.*, recipients.full_name, recipients.rt_rw, recipients.economic_status, recipients.status as rec_status');
        $this->db->from('proposal_items');
        $this->db->join('recipients', 'recipients.id = proposal_items.recipient_id', 'left');
        $this->db->where('proposal_items.proposal_id', $proposal_id);
        $data['items'] = $this->db->get()->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar_mitra', $data);
        $this->load->view('mitra/seleksi_penerima', $data);
        $this->load->view('layout/footer');
    }

    public function simpan_seleksi($proposal_id)
    {
        $decisions = $this->input->post('decision'); // array [item_id => 'accepted' / 'rejected']

        if (!empty($decisions)) {
            foreach ($decisions as $item_id => $status_keputusan) {
                $this->db->where('id', $item_id); 
                $this->db->update('proposal_items', ['selection_status' => $status_keputusan]);
            }

            // 1. Ambil data proposal untuk tahu proposal ini milik program apa & siapa petugasnya
            $proposal = $this->db->get_where('proposals', ['id' => $proposal_id])->row_array();
            $program_id = $proposal ? $proposal['program_id'] : null;

            // 2. Hitung berapa banyak warga yang statusnya 'accepted' (diterima) pada proposal ini
            $accepted_count = $this->db->get_where('proposal_items', [
                'proposal_id' => $proposal_id, 
                'selection_status' => 'accepted'
            ])->num_rows();

            // 3. Tentukan status proposal berdasarkan jumlah yang diterima
            if ($accepted_count > 0) {
                $proposal_status = 'aproved'; 
                $pesan_sukses = 'Hasil seleksi berhasil disimpan! (' . $accepted_count . ' warga diterima)';
            } else {
                $proposal_status = 'rejected'; 
                $pesan_sukses = 'Hasil seleksi disimpan. Semua warga dalam usulan ini ditolak.';
            }

            // 4. Update status proposal utama
            $this->db->where('id', $proposal_id);
            $this->db->update('proposals', ['status' => $proposal_status]);

            // 5. KURANGI KUOTA PROGRAM SECARA OTOMATIS
            if ($program_id && $accepted_count > 0) {
                $this->db->set('quota', 'quota - ' . (int)$accepted_count, FALSE);
                $this->db->where('program_id', $program_id);
                $this->db->update('programs');
            }

            // =========================================================
            // 6. TAMBAHKAN KODE NOTIFIKASI UNTUK PETUGAS DI SINI
            // =========================================================
            $notif_data = [
                'user_type' => 'petugas',
                'title'     => 'Hasil Seleksi Keluar',
                'message'   => 'Hasil seleksi untuk proposal ' . $proposal['reference_code'] . ' telah diperbarui oleh Mitra.',
                'link'      => 'index.php/petugas/progres_penyaluran?proposal_id=' . $proposal_id,
                'is_read'   => 0
            ];
            $this->db->insert('notifications', $notif_data);
            // =========================================================

            $this->session->set_flashdata('success', $pesan_sukses);
            redirect('index.php/mitra/usulan_masuk');
        } else {
            $this->session->set_flashdata('error', 'Belum ada keputusan seleksi yang dipilih.');
            redirect('index.php/mitra/detail_usulan/' . $proposal_id);
        }
    }

    // Halaman Progres Penyaluran
    public function progres_penyaluran()
    {
        $data['title'] = 'Progres Penyaluran';
        $data['active_menu'] = 'progres_penyaluran';
        $data['user_name'] = $this->session->userdata('name') ? $this->session->userdata('name') : 'Yayasan Peduli';

        // Ambil daftar usulan/proposal (KECUALIKAN yang berstatus 'rejected')
        $this->db->select('proposals.*, programs.title as program_name');
        $this->db->from('proposals');
        $this->db->join('programs', 'programs.program_id = proposals.program_id', 'left');
        $this->db->where('proposals.status !=', 'rejected'); // <-- Tambahan filter ini agar yang ditolak tidak masuk
        $data['proposals'] = $this->db->get()->result_array();

        // Ambil proposal yang sedang dipilih
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

            // Hitung jumlah penerima yang diterima
            $data['total_penerima'] = $this->db->get_where('proposal_items', ['proposal_id' => $selected_id, 'selection_status' => 'accepted'])->num_rows();

            // Ambil riwayat status dari tabel distributions (diurutkan dari yang terbaru)
            $this->db->where('proposal_id', $selected_id);
            $this->db->order_by('updated_at', 'DESC');
            $data['logs'] = $this->db->get('distributions')->result_array();
        }

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar_mitra', $data);
        $this->load->view('mitra/progres_penyaluran', $data);
        $this->load->view('layout/footer');
    }

    public function update_progres($proposal_id)
    {
        $status = $this->input->post('status');
        $notes = $this->input->post('notes');
        $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1;

        // 1. Update status di tabel proposals
        $this->db->where('id', $proposal_id);
        $this->db->update('proposals', ['status' => $status]);

        // 2. Simpan teks status standar
        $standard_log = 'Penyaluran diperbarui ke status: ' . $status;

        // 3. Siapkan data log untuk disimpan ke tabel distributions
        $dist_data = [
            'proposal_id' => $proposal_id,
            'status'      => $status,
            'user_id'     => $user_id,
            'updated_at'  => date('Y-m-d H:i:s')
        ];
        
        // 4. Gabungkan dengan tag <br> jika catatan diisi, jika tidak cukup teks standarnya saja
        if (!empty(trim($notes))) {
            $dist_data['notes'] = $standard_log . '<br><span class="text-muted small">Catatan: ' . htmlspecialchars(trim($notes)) . '</span>';
        } else {
            $dist_data['notes'] = $standard_log;
        }

        // 5. Insert ke database
        $this->db->insert('distributions', $dist_data);

        $this->session->set_flashdata('success', 'Status penyaluran berhasil diperbarui dan dicatat ke riwayat!');
        redirect('index.php/mitra/progres_penyaluran?proposal_id=' . $proposal_id);
    }

    public function laporan()
    {
        $data['title'] = 'Laporan';
        $data['active_menu'] = 'laporan';
        $data['user_name'] = $this->session->userdata('name') ? $this->session->userdata('name') : 'Yayasan Peduli';

        // Ambil daftar program untuk dropdown filter
        $data['programs_list'] = $this->db->get('programs')->result_array();

        // Tangkap parameter filter dari input GET
        $filter_program = $this->input->get('program_id');
        $filter_status  = $this->input->get('selection_status');
        $start_date     = $this->input->get('start_date');
        $end_date       = $this->input->get('end_date');

        // Base query untuk tabel rincian data per baris di bawah
        $this->db->select('proposal_items.*, recipients.full_name, recipients.rt_rw, recipients.economic_status, proposals.reference_code, proposals.created_at, programs.title as program_name');
        $this->db->from('proposal_items');
        $this->db->join('proposals', 'proposals.id = proposal_items.proposal_id', 'left');
        $this->db->join('programs', 'programs.program_id = proposals.program_id', 'left');
        $this->db->join('recipients', 'recipients.id = proposal_items.recipient_id', 'left');

        // Terapkan filter jika dipilih
        if (!empty($filter_program)) {
            $this->db->where('proposals.program_id', $filter_program);
        }
        if (!empty($filter_status)) {
            $this->db->where('proposal_items.selection_status', $filter_status);
        }
        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('DATE(proposals.created_at) >=', $start_date);
            $this->db->where('DATE(proposals.created_at) <=', $end_date);
        } elseif (!empty($start_date)) {
            $this->db->where('DATE(proposals.created_at) >=', $start_date);
        } elseif (!empty($end_date)) {
            $this->db->where('DATE(proposals.created_at) <=', $end_date);
        }

        $this->db->order_by('proposals.created_at', 'DESC');
        $data['detail_laporan'] = $this->db->get()->result_array();

        // Hitung statistik untuk cards atas
        $data['total_usulan'] = $this->db->count_all('proposals');
        $data['penerima_terpilih'] = $this->db->get_where('proposal_items', ['selection_status' => 'accepted'])->num_rows();
        $data['tidak_terpilih'] = $this->db->get_where('proposal_items', ['selection_status' => 'rejected'])->num_rows();
        $data['penyaluran_selesai'] = $this->db->get_where('proposals', ['status' => 'Selesai Disalurkan'])->num_rows();

        // Ambil data program beserta hitungan rekapnya
        $programs = $this->db->get('programs')->result_array();
        foreach ($programs as &$prog) {
            $this->db->where('program_id', $prog['program_id']);
            $total_prop = $this->db->count_all_results('proposals');
            
            $accepted_count = 0;
            if ($total_prop > 0) {
                $this->db->select('proposal_items.id');
                $this->db->from('proposal_items');
                $this->db->join('proposals', 'proposals.id = proposal_items.proposal_id');
                $this->db->where('proposals.program_id', $prog['program_id']);
                $this->db->where('proposal_items.selection_status', 'accepted');
                $accepted_count = $this->db->count_all_results();
            }

            $prog['total_usulan_prog'] = $total_prop;
            $prog['penerima_prog'] = $accepted_count;
            
            $quota = isset($prog['quota']) && $prog['quota'] > 0 ? $prog['quota'] : 100;
            $percentage = ($accepted_count / $quota) * 100;
            $prog['percentage'] = $percentage > 100 ? 100 : round($percentage);
        }
        $data['programs'] = $programs;

        $data['status_selesai'] = $this->db->get_where('proposals', ['status' => 'Selesai Disalurkan'])->num_rows();
        $this->db->from('proposals');
        $this->db->where('status !=', 'Selesai Disalurkan');
        $this->db->where('status !=', 'rejected');
        $data['status_proses'] = $this->db->count_all_results();

        // Simpan state filter untuk view
        $data['filter_program'] = $filter_program;
        $data['filter_status']  = $filter_status;
        $data['start_date']     = $start_date;
        $data['end_date']       = $end_date;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar_mitra', $data);
        $this->load->view('mitra/laporan', $data);
        $this->load->view('layout/footer');
    }

    public function cetak_laporan()
    {
        $data['title'] = 'Cetak Laporan Penyaluran';
        $data['user_name'] = $this->session->userdata('name') ? $this->session->userdata('name') : 'Natania';

        // Tangkap parameter filter yang sama
        $filter_program = $this->input->get('program_id');
        $filter_status  = $this->input->get('selection_status');
        $start_date     = $this->input->get('start_date');
        $end_date       = $this->input->get('end_date');

        // Query data rincian
        $this->db->select('proposal_items.*, recipients.full_name, recipients.rt_rw, recipients.economic_status, proposals.reference_code, proposals.created_at, programs.title as program_name');
        $this->db->from('proposal_items');
        $this->db->join('proposals', 'proposals.id = proposal_items.proposal_id', 'left');
        $this->db->join('programs', 'programs.program_id = proposals.program_id', 'left');
        $this->db->join('recipients', 'recipients.id = proposal_items.recipient_id', 'left');

        if (!empty($filter_program)) {
            $this->db->where('proposals.program_id', $filter_program);
        }
        if (!empty($filter_status)) {
            $this->db->where('proposal_items.selection_status', $filter_status);
        }
        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('DATE(proposals.created_at) >=', $start_date);
            $this->db->where('DATE(proposals.created_at) <=', $end_date);
        } elseif (!empty($start_date)) {
            $this->db->where('DATE(proposals.created_at) >=', $start_date);
        } elseif (!empty($end_date)) {
            $this->db->where('DATE(proposals.created_at) <=', $end_date);
        }

        $this->db->order_by('proposals.created_at', 'DESC');
        $data['detail_laporan'] = $this->db->get()->result_array();

        // Statistik ringkas untuk di atas laporan
        $data['total_usulan'] = $this->db->count_all('proposals');
        $data['penerima_terpilih'] = $this->db->get_where('proposal_items', ['selection_status' => 'accepted'])->num_rows();
        $data['tidak_terpilih'] = $this->db->get_where('proposal_items', ['selection_status' => 'rejected'])->num_rows();
        $data['penyaluran_selesai'] = $this->db->get_where('proposals', ['status' => 'Selesai Disalurkan'])->num_rows();

        // Load view khusus cetak (tanpa header/sidebar aplikasi)
        $this->load->view('mitra/cetak_laporan_pdf', $data);
    }

    // Menu Pengaturan (Mitra)
    public function pengaturan()
    {
        $data['title'] = 'Pengaturan Akun';
        $data['active_menu'] = 'pengaturan';
        $data['user_name'] = $this->session->userdata('name') ? $this->session->userdata('name') : 'Yayasan Peduli';

        $user_id = $this->session->userdata('user_id');
        
        // Menggunakan kolom 'user_id' sesuai struktur tabel di database
        $data['user'] = $this->db->get_where('users', ['user_id' => $user_id])->row_array();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar_mitra', $data);
        $this->load->view('mitra/pengaturan', $data);
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

        if ($user_id) {
            // Menggunakan kolom 'user_id' sesuai struktur tabel di database
            $this->db->where('user_id', $user_id);
            $this->db->update('users', $data_update);
        }

        // Update session nama agar langsung berubah di sidebar
        $this->session->set_userdata('name', $this->input->post('name'));

        $this->session->set_flashdata('success', 'Profil Mitra berhasil diperbarui!');
        redirect('index.php/mitra/pengaturan');
    }

    public function baca_notif($id)
    {
        // 1. Panggil instance database langsung untuk update status is_read jadi 1
        $this->db->where('id', $id);
        $this->db->update('notifications', ['is_read' => 1]);

        // 2. Ambil data notifikasi untuk tahu tujuannya
        $notif = $this->db->get_where('notifications', ['id' => $id])->row_array();
        
        if ($notif && !empty($notif['link'])) {
            // Cek apakah link sudah mengandung base_url atau index.php
            $target_link = $notif['link'];
            if (strpos($target_link, 'http') === 0) {
                redirect($target_link);
            } else {
                redirect(base_url($target_link));
            }
        } else {
            redirect('index.php/mitra/usulan_masuk');
        }
    }
}