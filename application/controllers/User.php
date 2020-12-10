<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{


    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    function tambah_anggota()
    {
        $data['title'] = 'Tambah Data Anggota';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/tambah_anggota', $data);
        $this->load->view('templates/footer');
    }
    function tambah_anggota_act()
    {
        $nama_anggota = $this->input->post('nama_anggota');
        $gender = $this->input->post('gender');
        $no_telp = $this->input->post('no_telp');
        $alamat = $this->input->post('alamat');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $this->form_validation->set_rules('nama_anggota', 'Nama Anggota', 'required');
        $this->form_validation->set_rules('no_telp', 'No.Telpon', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() != false) {
            $data = array(
                'nama_anggota' => $nama_anggota,
                'gender' => $gender,
                'no_telp' => $no_telp,
                'alamat' => $alamat,
                'email' => $email,
                'password' => $password,
            );
            $this->M_perpus->insert_data($data, 'anggota');
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert" >
          <strong>Selamat Anda Behasil Menjadi Anggota</strong> 
        </div>');
            redirect(base_url() . 'user/buku');
        } else {
            redirect(base_url() . 'user/tambah_anggota');
        }
    }
    function buku()
    {
        $data['title'] = 'Daftar buku';
        $data['buku'] = $this->M_perpus->get_data('buku')->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/buku', $data);
        $this->load->view('templates/footer');
    }

    public function detail_buku($id)
    {

        $data['title'] = 'Detail buku';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $where = array('id_buku' => $id);
        $data['buku'] = $this->db->query("select * from buku B, kategori K where
        B.id_kategori=K.id_kategori and B.id_buku='$id'")->result();
        $data['kategori'] = $this->M_perpus->get_data('kategori')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/detail_buku', $data);
        $this->load->view('templates/footer');
    }

    function tambah_peminjaman()
    {
        $data['title'] = 'Tambah Data Peminjaman';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $w = array('status_buku' => '1');
        $data['buku'] = $this->M_perpus->edit_data($w, 'buku')->result();
        $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
        $data['peminjaman'] = $this->M_perpus->get_data('transaksi')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/tambah_peminjaman', $data);
        $this->load->view('templates/footer');
    }

    function tambah_peminjaman_act()
    {
        $tgl_pencatatan = date('Y-m-d H:i:s');
        $anggota = $this->input->post('anggota');
        $buku = $this->input->post('buku');
        $tgl_pinjam = $this->input->post('tgl_pinjam');
        $tgl_kembali = $this->input->post('tgl_kembali');
        $denda = $this->input->post('denda');
        $this->form_validation->set_rules('anggota', 'Anggota', 'required');
        $this->form_validation->set_rules('buku', 'Buku', 'required');
        $this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
        $this->form_validation->set_rules('tgl_kembali', 'Tanggal
Kembali', 'required');
        $this->form_validation->set_rules('denda', 'Denda', 'required');
        if ($this->form_validation->run() != false) {
            $data = array(
                'tgl_pencatatan' => $tgl_pencatatan,
                'id_anggota' => $anggota,
                'id_buku' => $buku,
                'tgl_pinjam' => $tgl_pinjam,
                'tgl_kembali' => $tgl_kembali,
                'denda' => $denda,
                'tgl_pengembalian' => '0000-00-00',
                'total_denda' => '0',
                'status_pengembalian' => '0',
                'status_peminjaman' => '0'
            );
            $this->M_perpus->insert_data($data, 'transaksi');
            $d = array('status_buku' => '0', 'tgl_input' =>
            substr($tgl_pencatatan, 0, 10));
            $w = array('id_buku' => $buku);
            $this->M_perpus->update_data('buku', $d, $w);
            redirect(base_url() . 'user/selesai');
        } else {
            $w = array('status_buku' => '1');
            $data['buku'] = $this->M_perpus->edit_data($w, 'buku')->result();
            $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
            $this->load->view('templates/header');
            $this->load->view('user/tambah_peminjaman', $data);
            $this->load->view('templates/footer');
        }
    }

    public function selesai()
    {
        $data['title'] = 'Selesai Meminjam Buku';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/selesai', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated!</div>');
            redirect('user');
        }
    }


    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
                    redirect('user/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password changed!</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }
}
