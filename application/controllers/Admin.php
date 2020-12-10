<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends CI_Controller
{

  function index()
  {
    $data['title'] = 'Dashboard';
    $data['transaksi'] = $this->db->query("select * from transaksi order by id_pinjam
desc limit 10")->result();
    $data['anggota'] = $this->db->query("select * from anggota order by id_anggota
desc limit 10")->result();
    $data['buku'] = $this->db->query("select * from buku order by id_buku desc
limit 10")->result();
    $data['kategori'] = $this->db->query("select * from kategori order by id_kategori desc
limit 10")->result();
    $this->load->view('admin/header', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('admin/footer');
  }

  public function logout()
  {
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('role_id');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
    redirect('auth');
  }

  public function ganti_password()
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
      $this->load->view('admin/ganti_password', $data);
      $this->load->view('templates/footer');
    } else {
      $current_password = $this->input->post('current_password');
      $new_password = $this->input->post('new_password1');
      if (!password_verify($current_password, $data['user']['password'])) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
        redirect('admin/ganti_password');
      } else {
        if ($current_password == $new_password) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
          redirect('admin/changepassword');
        } else {
          // password sudah ok
          $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

          $this->db->set('password', $password_hash);
          $this->db->where('email', $this->session->userdata('email'));
          $this->db->update('user');

          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password changed!</div>');
          redirect('admin/ganti_password');
        }
      }
    }
  }

  function buku()
  {
    $data['title'] = 'Daftar Buku';
    $data['buku'] = $this->M_perpus->get_data('buku')->result();
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->view('admin/header', $data);
    $this->load->view('admin/buku', $data);
    $this->load->view('admin/footer');
  }

  function tambah_buku()
  {
    $data['title'] = 'Tambah Data Buku';
    $data['kategori'] = $this->M_perpus->get_data('kategori')->result();
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->view('admin/header', $data);
    $this->load->view('admin/tambahbuku', $data);
    $this->load->view('admin/footer');
  }

  function tambah_buku_act()
  {
    $tgl_input = date('Y-m-d');
    $id_kategori = $this->input->post('id_kategori', true);
    $judul = $this->input->post('judul_buku', true);
    $pengarang = $this->input->post('pengarang', true);
    $penerbit = $this->input->post('penerbit', true);
    $thn_terbit = $this->input->post('thn_terbit', true);
    $isbn = $this->input->post('isbn', true);
    $jumlah_buku = $this->input->post('jumlah_buku', true);
    $lokasi = $this->input->post('lokasi', true);
    $status = $this->input->post('status_buku', true);
    $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');
    $this->form_validation->set_rules('judul_buku', 'Judul Buku', 'required');
    $this->form_validation->set_rules('status', 'Status Buku', 'required');
    if ($this->form_validation->run() == false) {
      //configurasi upload Gambar
      $config['upload_path'] = './asset/upload/';
      $config['allowed_types'] = 'jpg|png|jpeg';
      $config['max_size'] = '2048';
      $config['file_name'] = 'gambar' . time();
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('foto')) {
        $image = $this->upload->data();
        $data = array(
          'id_kategori' => $id_kategori,
          'judul_buku' => $judul,
          'pengarang' => $pengarang,
          'penerbit' => $penerbit,
          'thn_terbit' => $thn_terbit,
          'isbn' => $isbn,
          'jumlah_buku' => $jumlah_buku,
          'lokasi' => $lokasi,
          'gambar' => $image['file_name'],
          'tgl_input' => $tgl_input,
          'status_buku' => $status
        );
        $this->M_perpus->insert_data($data, 'buku');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert" >
  <strong>Data Behasil Ditambah</strong> 
</div>');
        redirect(base_url() . 'admin/buku');
      } else {
        $this->load->view('admin/header');
        $this->load->view('admin/tambahbuku');
        $this->load->view('admin/footer');
      }
    }
  }

  function hapus_buku($id)
  {
    $where = array('id_buku' => $id);
    $this->M_perpus->delete_data($where, 'buku');
    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert" >
  <strong>Data Behasil Dihapus</strong> 
  
</div>');
    redirect(base_url() . 'admin/buku');
  }

  function edit_buku($id)
  {
    $data['title'] = 'Edit Data Buku';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $where = array('id_buku' => $id);
    $data['buku'] = $this->db->query("select * from buku B, kategori K where
B.id_kategori=K.id_kategori and B.id_buku='$id'")->result();
    $data['kategori'] = $this->M_perpus->get_data('kategori')->result();
    $this->load->view('admin/header', $data);
    $this->load->view('admin/editbuku', $data);
    $this->load->view('admin/footer');
  }

  function update_buku()
  {

    $id = $this->input->post('id');
    $id_kategori = $this->input->post('id_kategori', true);
    $judul = $this->input->post('judul_buku', true);
    $pengarang = $this->input->post('pengarang', true);
    $penerbit = $this->input->post('penerbit', true);
    $thn_terbit = $this->input->post('thn_terbit', true);
    $isbn = $this->input->post('isbn', true);
    $jumlah_buku = $this->input->post('jumlah_buku', true);
    $lokasi = $this->input->post('lokasi', true);
    $status = $this->input->post('status_buku', true);

    $this->form_validation->set_rules('id_kategori', 'ID Kategori', 'required');
    $this->form_validation->set_rules('judul_buku', 'Judul
Buku', 'required|min_length[4]');
    $this->form_validation->set_rules('pengarang', 'Pengarang', 'required|min_length[4]');
    $this->form_validation->set_rules('penerbit', 'Penerbit', 'required|min_length[4]');
    $this->form_validation->set_rules('thn_terbit', 'Tahun
Terbit', 'required|min_length[4]');
    $this->form_validation->set_rules('isbn', 'Nomor ISBN', 'required|numeric');
    $this->form_validation->set_rules('jumlah_buku', 'Jumlah
Buku', 'required|numeric');
    $this->form_validation->set_rules('lokasi', 'Lokasi
Buku', 'required|min_length[4]');
    $this->form_validation->set_rules('status_buku', 'Status Buku', 'required');

    if ($this->form_validation->run() != false) {
      $config['upload_path'] = './asset/upload/';
      $config['allowed_types'] = 'jpg|png|jpeg';
      $config['max_size'] = '2048';
      $config['file_name'] = 'gambar' . time();
      $this->load->library('upload', $config);
      $where = array('id_buku' => $id);

      $data = array(
        'id_kategori' => $id_kategori,
        'judul_buku' => $judul,
        'pengarang' => $pengarang,
        'penerbit' => $penerbit,
        'thn_terbit' => $thn_terbit,
        'isbn' => $isbn,
        'jumlah_buku' => $jumlah_buku,
        'lokasi' => $lokasi,
        'gambar' => $image['file_name'],
        'tgl_input' => $tgl_input,
        'status_buku' => $status
      );
      if ($this->upload->do_upload('foto')) {
        //proses upload Gambar
        $image = $this->upload->data();
        unlink('asset/upload/' . $this->input->post('old_pict', TRUE));
        $data['gambar'] = $image['file_name'];
        $this->M_perpus->update_data('buku', $data, $where);
      } else {
        $this->M_perpus->update_data('buku', $data, $where);
      }
      $this->M_perpus->update_data('buku', $data, $where);
      $this->session->set_flashdata('message', '<div class="alert alert-primary alert-dismissible fade show" role="alert" >
  <strong>Data Behasil Diperbarui</strong> 
 
</div>');
      redirect(base_url() . 'admin/buku');
    } else {
      $where = array('id_buku' => $id);
      $data['buku'] = $this->db->query("select * from buku b, kategori k
where b.id_kategori=k.id_kategori and b.id_buku='$id'")->result();
      $data['kategori'] = $this->M_perpus->get_data('kategori')->result();
      $this->load->view('admin/header');
      $this->load->view('admin/editbuku', $data);
      $this->load->view('admin/footer');
    }
  }
  public function detail($id)
  {
    $this->load->model('M_perpus');
    $detail = $this->M_perpus->detail_data($id);
    $data['detail'] = $detail;
    $this->load->view('templates/slidebar');
    $this->load->view('detail', $data);
    $this->load->view('templates/footer');
  }

  function kategori()
  {
    $data['title'] = 'Daftar Kategori';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['kategori'] = $this->M_perpus->get_data('kategori')->result();

    $this->form_validation->set_rules('nama_kategori', 'Kategori', 'required', [
      'required' => 'kategori harus diisi'
    ]);

    if ($this->form_validation->run() == false) {
      $this->load->view('admin/header', $data);
      $this->load->view('admin/kategori', $data);
      $this->load->view('admin/footer');
    } else {
      $data = [
        'nama_kategori' => $this->input->post('nama_kategori', TRUE)
      ];

      $this->M_perpus->insert_data($data, 'kategori');
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert" >
  <strong>Data Behasil Ditambah</strong> 
</div>');
      redirect('admin/kategori');
    }
  }

  function hapus_kategori($id)
  {
    $where = array('id_kategori' => $id);
    $this->M_perpus->delete_data($where, 'kategori');
    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Data Behasil Dihapus</strong> 
 
</div>');
    redirect(base_url() . 'admin/kategori');
  }


  function anggota()
  {
    $data['title'] = 'Daftar Anggota';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
    $this->load->view('admin/header', $data);
    $this->load->view('admin/anggota', $data);
    $this->load->view('admin/footer');
  }

  function tambah_anggota()
  {
    $data['title'] = 'Tambah Data Anggota';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->view('admin/header', $data);
    $this->load->view('admin/tambahanggota');
    $this->load->view('admin/footer');
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
  <strong>Data Behasil Ditambah</strong> 
</div>');
      redirect(base_url() . 'admin/anggota');
    } else {
      $this->load->view('admin/header');
      $this->load->view('admin/tambahanggota');
      $this->load->view('admin/footer');
    }
  }

  function hapus_anggota($id)
  {
    $where = array('id_anggota' => $id);
    $this->M_perpus->delete_data($where, 'anggota');
    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Data Behasil Dihapus</strong> 
 
</div>');
    redirect(base_url() . 'admin/anggota');
  }

  function edit_anggota($id)
  {
    $data['title'] = 'Edit Data Anggota';
    $where = array('id_anggota' => $id);
    $data['anggota'] = $this->db->query("select * from anggota where
id_anggota='$id'")->result();
    $this->load->view('admin/header', $data);
    $this->load->view('admin/editanggota', $data);
    $this->load->view('admin/footer');
  }

  function update_anggota()
  {
    $id = $this->input->post('id');
    $nama_anggota = $this->input->post('nama_anggota');
    $gender = $this->input->post('gender');
    $penerbit = $this->input->post('penerbit');
    $no_telp = $this->input->post('no_telp');
    $alamat = $this->input->post('alamat');
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $this->form_validation->set_rules('nama_anggota', 'Nama
Anggota', 'required');
    $this->form_validation->set_rules('no_telp', 'No.Telpon', 'required');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    if ($this->form_validation->run() != false) {
      $where = array('id_anggota' => $id);
      $data = array(
        'nama_anggota' => $nama_anggota,
        'gender' => $gender,
        'no_telp' => $no_telp,
        'alamat' => $alamat,
        'email' => $email,
        'password' => $password,
      );
      $this->M_perpus->update_data('anggota', $data, $where);
      $this->session->set_flashdata('message', '<div class="alert alert-primary alert-dismissible fade show" role="alert" >
  <strong>Data Behasil Diperbarui</strong> 
 
</div>');
      redirect(base_url() . 'admin/anggota');
    } else {
      $where = array('id_anggota' => $id);
      $data['anggota'] = $this->db->query("select * from anggota where
id_anggota='$id'")->result();
      $this->load->view('admin/header');
      $this->load->view('admin/editanggota', $data);
      $this->load->view('admin/footer');
    }
  }

  function peminjaman()
  {
    $data['title'] = 'Daftar Transaksi';
    $data['peminjaman'] = $this->db->query("SELECT * FROM transaksi T,
buku B, anggota A WHERE T.id_buku=B.id_buku and
T.id_anggota=A.id_anggota")->result();
    $this->load->view('admin/header', $data);
    $this->load->view('admin/peminjaman', $data);
    $this->load->view('admin/footer');
  }

  function tambah_peminjaman()
  {
    $data['title'] = 'Tambah Data Peminjaman';
    $w = array('status_buku' => '1');
    $data['buku'] = $this->M_perpus->edit_data($w, 'buku')->result();
    $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
    $data['peminjaman'] = $this->M_perpus->get_data('transaksi')->result();
    $this->load->view('admin/header', $data);
    $this->load->view('admin/tambah_peminjaman', $data);
    $this->load->view('admin/footer');
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
      redirect(base_url() . 'admin/peminjaman');
    } else {
      $w = array('status_buku' => '1');
      $data['buku'] = $this->M_perpus->edit_data($w, 'buku')->result();
      $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
      $this->load->view('admin/header');
      $this->load->view('admin/tambah_peminjaman', $data);
      $this->load->view('admin/footer');
    }
  }

  function hapus_peminjaman($id)
  {
    $w = array('id_pinjam' => $id);
    $data = $this->M_perpus->edit_data($w, 'transaksi')->row();
    $ww = array('id_buku' => $data->id_buku);
    $data2 = array('status_buku' => '1');
    $this->M_perpus->update_data($ww, $data->id_buku);
    $this->M_perpus->delete_data($w, 'transaksi');
    redirect(base_url() . 'admin/peminjaman');
  }

  function transaksi_hapus($id)
  {
    $w = array('id_pinjam' => $id);
    $data = $this->M_perpus->edit_data($w, 'transaksi')->row();
    $ww = array('id_buku' => $data->id_buku);
    $data2 = array('status_buku' => '1');
    $this->M_perpus->update_data('buku', $data2, $ww);
    $this->M_perpus->delete_data($w, 'transaksi');
    redirect(base_url() . 'admin/peminjaman');
  }

  function transaksi_selesai($id)
  {
    $data['title'] = 'Daftar Transaksi Selesai';
    $data['buku'] = $this->M_perpus->get_data('buku')->result();
    $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
    $this->db->query("select * from peminjaman p, anggota a, detail_pinjam d, buku b where p.id_anggota = a.id_anggota and p.id_pinjam=d.id_pinjam and d.id_buku=b.id_buku and p.id_pinjam='$id'")->result();
    $this->load->view('admin/header', $data);
    $this->load->view('admin/transaksi_selesai', $data);
    $this->load->view('admin/footer');
  }

  function transaksi_selesai_act()
  {
    $id = $this->input->post('id');
    $tgl_dikembalikan = $this->input->post('tgl_dikembalikan');
    $tgl_kembali = $this->input->post('tgl_kembali');
    $buku = $this->input->post('buku');
    $denda = $this->input->post('denda');
    $this->form_validation->set_rules('tgl_dikembalikan', 'Tanggal
dikembalkan', 'required');
    if ($this->form_validation->run() != false) {
      //hitung selisih hari
      $batas_kembali = strtotime($tgl_kembali);
      $dikembalikan = strtotime($tgl_dikembalikan);
      $selisih = abs(($batas_kembali - $dikembalikan) / (60 * 60 * 24));
      $total_denda = $denda * $selisih;
      //update status Peminjaman
      $data = array('status_peminjaman' => '1', 'total_denda' => $total_denda, 'tgl_pengembalian' => $tgl_dikembalikan, 'status_pengembalian' => '1');
      $w = array('id_pinjam' => $id);
      $this->M_perpus->update_data('peminjaman', $data, $w);
      //update status Buku
      $data2 = array('status_buku' => '1');
      $w2 = array('id_buku' => $buku);
      $this->M_perpus->update_data('buku', $data2, $w2);
      redirect(base_url() . 'admin/peminjaman');
    } else {
      $data['buku'] = $this->M_perpus->get_data('buku')->result();
      $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
      $this->db->query("select * from peminjaman p, anggota a, detail_pinjam d, buku b where p.id_anggota = a.id_anggota and p.id_pinjam=d.id_pinjam and d.id_buku=b.id_buku and p.id_pinjam='$id'")->result();
      $this->load->view('admin/header');
      $this->load->view('admin/transaksi_selesai', $data);
      $this->load->view('admin/footer');
    }
  }

  function cetak_laporan_buku()
  {
    $data['title'] = 'laporan buku';
    $data['buku'] = $this->M_perpus->get_data('buku')->result();
    $this->load->view('admin/header', $data);
    $this->load->view('admin/laporan_buku', $data);
    $this->load->view('admin/footer');
  }

  function laporan_print_buku()
  {
    $data['buku'] = $this->M_perpus->get_data('buku')->result();
    $this->load->view('admin/laporan_print_buku', $data);
  }

  function laporan_pdf_buku()
  {
    /*$this->load->library('dompdf_gen');*/
    $data['buku'] = $this->M_perpus->get_data('buku')->result();
    $this->load->view('admin/laporan_pdf_buku', $data);
    /*
$paper_size = 'A4'; // ukuran kertas
$orientation = 'landscape'; //tipe format kertas potrait atau landscape
$html = $this->output->get_output();
$this->dompdf->set_paper($paper_size, $orientation);
//Convert to PDF
$this->dompdf->load_html($html);
$this->dompdf->render();22
$this->dompdf->stream("laporan_data_buku.pdf",
array('Attachment'=>0));
// nama file pdf yang di hasilkan
*/
  }

  function cetak_laporan_anggota()
  {
    $data['title'] = 'Laporan Anggota';
    $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
    $this->load->view('admin/header', $data);
    $this->load->view('admin/laporan_anggota', $data);
    $this->load->view('admin/footer');
  }

  function laporan_print_anggota()
  {
    $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
    $this->load->view('admin/laporan_print_anggota', $data);
  }

  function laporan_pdf_anggota()
  {
    /*$this->load->library('dompdf_gen');*/
    $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
    $this->load->view('admin/laporan_pdf_anggota', $data);
    /*$paper_size = 'A4'; // ukuran kertas
$orientation = 'landscape'; //tipe format kertas potrait atau landscape
$html = $this->output->get_output();
$this->dompdf->set_paper($paper_size, $orientation);
//Convert to PDF
$this->dompdf->load_html($html);
$this->dompdf->render();
$this->dompdf->stream("laporan_data_anggota.pdf",
array('Attachment'=>0));
// nama file pdf yang di hasilkan
*/
  }

  function laporan_transaksi()
  {
    $data['title'] = 'Laporan transaksi';
    $dari = $this->input->post('dari');
    $sampai = $this->input->post('sampai');
    $this->form_validation->set_rules('dari', 'Dari Tanggal', 'required');
    $this->form_validation->set_rules('sampai', 'Sampai Tanggal', 'required');
    if ($this->form_validation->run() != false) {
      $data['laporan'] = $this->db->query("select * from peminjaman p,
detail_pinjam d,
buku b, anggota a where p.id_pinjam=d.id_pinjam and
b.id_buku=d.id_buku and a.id_anggota=p.id_anggota23
and date(p.tgl_pinjam)>='$dari'
and date(p.tgl_pinjam)<='$sampai'")->result();
      $this->load->view('admin/header', $data);
      $this->load->view('admin/laporan_filter_transaksi', $data);
      $this->load->view('admin/footer');
    } else {
      $this->load->view('admin/header', $data);
      $this->load->view('admin/laporan_transaksi');
      $this->load->view('admin/footer');
    }
  }

  function laporan_print_transaksi()
  {
    $dari = $this->input->get('dari');
    $sampai = $this->input->get('sampai');
    if ($dari != "" && $sampai != "") {
      $data['laporan'] = $this->db->query("select * from peminjaman p,
detail_pinjam d,buku b, anggota a where d.id_buku=b.id_buku and
p.id_anggota=a.id_anggota and p.id_pinjam=d.id_pinjam and date(tanggal_input) >=
'$dari'")->result();
      $this->load->view('admin/laporan_print_transaksi', $data);
    } else {
      redirect("admin/laporan_transaksi");
    }
  }

  function laporan_pdf_transaksi()
  {
    /*$this->load->library('dompdf_gen');*/
    $dari = $this->input->get('dari');
    $sampai = $this->input->get('sampai');
    $data['laporan'] = $this->db->query("select * from peminjaman p,
detail_pinjam d, buku b, anggota a
where d.id_buku=b.id_buku and p.id_anggota=a.id_anggota and
p.id_pinjam=d.id_pinjam and date(tanggal_input)
>= '$dari'")->result();
    $this->load->view('admin/laporan_pdf_transaksi', $data);
    /*$paper_size = 'A4'; // ukuran kertas
$orientation = 'landscape'; //tipe format kertas potrait atau landscape
$html = $this->output->get_output();
$this->dompdf->set_paper($paper_size, $orientation);
//Convert to PDF
$this->dompdf->load_html($html);
$this->dompdf->render();24
$this->dompdf->stream("laporan_data_transaksi.pdf",
array('Attachment'=>0));*/
  }
}
