<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->library('session');
        date_default_timezone_set('Asia/Jakarta');
    }

    // Menampilkan halaman login
    public function index()
    {
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

        // 2. Cegah kembali ke halaman login jika sudah punya session
        if ($this->session->userdata('username')) {
            redirect('barang/dashboard');
        }
        $this->load->view('login_view');
    }

    // Memproses data dari form login
    public function proses_login()
    {
        // 1. Tangkap response reCAPTCHA dari form
        $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
        
        // --- MASUKKAN SECRET KEY DARI GOOGLE DI BAWAH INI ---
        $secret = '6LeHC7UtAAAAADBh5Bz_-DKRsFnVmCoL9JtcJrbl';
        
        // 2. Kirim data ke server Google untuk dicek keasliannya
        $credential = array(
            'secret' => $secret,
            'response' => $recaptchaResponse
        );

        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        $status = json_decode($response, true);

        // 3. Jika reCAPTCHA kosong atau salah (robot), tolak login!
        if(empty($status['success'])) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning text-center">Harap centang <b>Saya bukan robot</b> terlebih dahulu!</div>');
            redirect('auth');
            return; // Hentikan eksekusi kode di bawahnya
        }

        // 4. Jika reCAPTCHA lolos, lanjutkan proses cek Username & Password ke Database
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->Login_model->cek_login($username, $password);

        if ($user) {
            $session_data = array(
                'username'  => $user['username'],
                'logged_in' => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect('barang/dashboard');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger text-center">Username atau Password salah!</div>');
            redirect('auth');
        }
    }

    // Fitur Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}