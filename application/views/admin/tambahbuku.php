<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-info">Tambah Buku Baru</h6>
    </div>
    <div class="card-body">
      <?= validation_errors('<p style="color:red;">', '</p>'); ?>
      <?php
      if ($this->session->flashdata()) {
        echo "<div class='alert alert-danger alert-message'>";
        echo $this->session->flashdata('alert');
        echo "</div>";
      } ?>

      <form action="<?php echo base_url() . 'admin/tambah_buku_act' ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
          <label>Kategori</label>
          <select name="id_kategori" class="form-control">
            <option value="">--Pilih Kategori--</option>
            <?php foreach ($kategori as $k) { ?>
              <option value="<?php echo $k->id_kategori; ?>"><?php echo $k->nama_kategori; ?></option>
            <?php } ?>
          </select>
          <?php echo form_error('id_kategori'); ?>
        </div>

        <div class="form-group">
          <label>Judul Buku</label>
          <input type="text" name="judul_buku" id="judul_buku" class="form-control">
          <?php echo form_error('judul_buku'); ?>
        </div>

        <div class="form-group">
          <label>Pengarang</label>
          <input type="text" name="pengarang" id="pengarang" class="form-control">
        </div>

        <div class="form-group">
          <label>Tahun Terbit</label>
          <input type="date" name="thn_terbit" id="thn_terbit" class="form-control">
        </div>

        <div class="form-group">
          <label>Penerbit</label>
          <input type="text" name="penerbit" id="penerbit" class="form-control">
        </div>

        <div class="form-group">
          <label>ISBN</label>
          <input type="text" name="isbn" id="isbn" class="form-control">
        </div>

        <div class="form-group">
          <label>Jumlah Buku</label>
          <input type="text" name="jumlah_buku" id="jumlah_buku" class="form-control">
        </div>

        <div class="form-group">
          <label>Lokasi</label>
          <select name="lokasi" id="lokasi" class="form-control">
            <option value="Rak 1">Rak 1</option>
            <option value="Rak 2">Rak 2</option>
            <option value="Rak 3">Rak 3</option>
          </select>
        </div>

        <div class="form-group">
          <label>Gambar</label>
          <input type="file" name="foto" id="foto" class="form-control">
        </div>

        <div class="form-group">
          <label>Status Buku</label>
          <select name="status_buku" id="status_buku" class="form-control">
            <option value="1">Tersedia</option>
            <option value="0">Sedang dipinjam</option>
          </select>
          <?php echo form_error('status_buku'); ?>
        </div>


        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
        <button type="reset" class="btn btn-danger">Reset</button>


        <?php echo form_close();  ?>

    </div>
  </div>
</div>